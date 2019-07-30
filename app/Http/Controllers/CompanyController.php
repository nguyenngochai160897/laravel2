<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use KubAT\PhpSimple\HtmlDomParser;
use App\Company;
use DB;
use App\AddressDetail;
use App\Job;
use App\Exports\CompaniesExport;
use Maatwebsite\Excel\Facades\Excel;

class CompanyController extends Controller
{
    function getDom($link){
        $ch = curl_init($link);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Cookie: G_AUTHUSER_H=0; _ga=GA1.2.1312062635.1564059424; _gid=GA1.2.171356033.1564059424; _gac_UA-42033311-1=1.1564059424.CjwKCAjwpuXpBRAAEiwAyRRPgXMrV0UsrvGoV10A5SAIulc42nlr7JywwE09zpL9zmH9rx7bs6k7XRoCHB8QAvD_BwE; _gcl_aw=GCL.1564059424.CjwKCAjwpuXpBRAAEiwAyRRPgXMrV0UsrvGoV10A5SAIulc42nlr7JywwE09zpL9zmH9rx7bs6k7XRoCHB8QAvD_BwE; cvmissing=value; _gcl_au=1.1.1263366454.1564059424; _gac_UA-42033311-2=1.1564059424.CjwKCAjwpuXpBRAAEiwAyRRPgXMrV0UsrvGoV10A5SAIulc42nlr7JywwE09zpL9zmH9rx7bs6k7XRoCHB8QAvD_BwE; _gac_UA-42033311-4=1.1564059424.CjwKCAjwpuXpBRAAEiwAyRRPgXMrV0UsrvGoV10A5SAIulc42nlr7JywwE09zpL9zmH9rx7bs6k7XRoCHB8QAvD_BwE; G_ENABLED_IDPS=google; _fbp=fb.1.1564059424670.517532390; fbm_403551049745808=base_domain=.itviec.com; auto_promote_submit_review=true; uvts=0288dc1c-b956-40af-5c6a-80488c6b80a7; remember_user_token=W1syNTM1NDldLCIkMmEkMTAkdk5XdG5FRXpwQU5rNHMyTkozQi9kZSIsIjE1NjQwNTk1MjQuMzkyOTI5MyJd--cf2981c547e5baa42172db744fcc8012a1a00229; _ITViec_session=dGpvUEtOY09DK0xLcmlORHBLbTFpQVU3bGZBcHpOUTE4Z2R5cGNqUHpDNGNwKzVYSnRzKzVZVkszdDZ2eHl3Tk5ubGVqdjRVbFlFU2IvS3ZSS0dhcGdSWDVUdk5tWnBGQnAvbCtWZWpzbWhDNTAxNXEydlc0aDBqSENud1haaGFOYzgvZVdsZkdwSVlQSUplbTBzbmlyRE5YYUxkNTRpb1A2d2psaWhsMGhtaC85YW1nVWtGU0htNU1MK245ay9nclJBOVkrMjlwOWxDbElENFZ6anhWWmRHWTJYYjFPMVZEQjQ5WWcxaXdMYTZHZFNvOThsVkc2VkpIemozRU9KNnV0MGdOdzZVYnkzZy9xMDByYW43SWQwQnh3UXVDVUZDR3NJYXJwazIxYnZwSjAzTWo2YmZkbWFueWtyWjBIOGZDQlJIWEd2QjRDWHJCMUo5N1dRcEVnPT0tLVRHeVF2cDZFVlpteWxwL1BKZDJLcGc9PQ%3D%3D--d5e1e40f44bd948e9c2a937442292994ce41184a; fbsr_403551049745808=a3jPN9WohpjrMloFframcKMa0QL-Y_OH1qD61wQ7yKY.eyJjb2RlIjoiQVFEY2h2YlB4RUdvYlJXNkthZ1VnU1YtdGtaeUVjTnZpakE4M0k1Snh0MzdYRWRMbmdJRUJ5UkNhVEhCV3Zvb3FRc2prNG1oRjlNel9XQXRkNGsxM25OQktQc3E4ekZxcWYtNWY4NzA4NFlIN2dTeEZ4SmZuZ3ozVUg5MUc2SDNaQUJDbzVVYnp0MUZuSGU3R09qdERLMndUZDJ4MzBrUXNhY3NGczY2YUtuSUJVYlVaajV1azl1WFpHODhULVU2NWU3Q3VKa1F4Yl8tb091YTFUWE9sNGNuOXJObUtZSGdWcnVtT2E2WjFINW9CM2pCbXlBWDhkbktUX3JxQWNMZUhoSFZZZzVQQ1NPVW1VMGVkT3B6TDNUZDg3UjdzcDZwYmVhcXdWYlhsN0Z4dlcycFdLOEI4WXYtNDZzT0dvejRpSkZycmZWVmxxV1NERkk5elpsSy1qWDUiLCJ1c2VyX2lkIjoiNDU2MDA1MDUxNDAzNDQ1IiwiYWxnb3JpdGhtIjoiSE1BQy1TSEEyNTYiLCJpc3N1ZWRfYXQiOjE1NjQwNjA3Mjl9"));
        $content = curl_exec($ch);
        curl_close($ch);
        $dom = HtmlDomParser::str_get_html($content);
        return $dom;
    }

    //add db
    function addCompany(){
        $html = $this->getDom("https://itviec.com/jobs-company-index");
        $result = array();
        $count = 0;
        foreach($html->find('.skill-tag__link') as $element){
            $url_detail = "https://itviec.com".$element->href;
            $resource = $url_detail;
            $company = $element->plaintext;
            $html_detail = $this->getDom($url_detail);
            $num_emps = trim($html_detail->find(".group-icon", 0)->plaintext);
            $market = trim($html_detail->find(".country .name", 0)->plaintext);
            $address = trim($html_detail->find(".name-and-info span", 0)->plaintext);
            $address_details = array();
            foreach($html_detail->find(".full-address-mobile") as $add){
                array_push($address_details, trim($add->plaintext));
            }
            $jobs = array();
            $job_names = array();
            $job_salarys = array();
            foreach($html_detail->find(".title a") as $job){
                array_push($job_names, trim($job->plaintext));
            }
            foreach($html_detail->find(".salary-text") as $job){
                array_push($job_salarys, ($job->plaintext));
            }
           
            for ($i = 0; $i < count($job_names); $i++) { 
                array_push($jobs, array(
                    "name" => $job_names[$i],
                    "salary" => trim($job_salarys[$i]),
                ));
            }
           
            array_push($result, array(
                "resource" =>$resource,
                "name" => $company,
                "num_employees" => $num_emps,
                "market" => $market,
                "address" => $address,
                "address_detail" => $address_details,
                "jobs" => $jobs
            ));
        }
        //save db
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Company::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        AddressDetail::truncate();
        Job::truncate();
        foreach($result as $r){
            $company = new Company;
            $company->resource = $r['resource'];
            $company->name = $r['name'];
            $company->num_employees = $r['num_employees'];
            $company->market = $r['market'];
            $company->address = $r['address'];
            $company->save();
            foreach($r['address_detail'] as $add){
                $address_detail = new AddressDetail;
                $address_detail->name = $add;
                $address_detail->company_id = $company->id; 
                $address_detail->save();
            }
            foreach($r['jobs'] as $j){
                $job = new Job();
                $job->company_id = $company->id;
                $job->name = $j["name"];
                $job->salary = $j["salary"];
                $job->save();
            }
        }
    }

    function getAllCompany(){
        $company = new Company();
        $companies = $company->getAllCompany();
        
        $jobs = array();
        $address_details="";
        $result = array();
        foreach($companies as $company){
            foreach($company['address_details'] as $address){
                $address_details.=$address['name']."</br>";
            }
            foreach($company['jobs'] as $job){
                $job_name = $job['name'];
                $job_salary = $job['salary'];
                array_push($result, array(
                    "id" => $company['id'],
                    "company_name" => $company['name'],
                    "resource" => $company['resource'],
                    "num_employees" => $company['num_employees'],
                    "market" => $company['market'],
                    "address" => $company['address'],
                    "job_name" => $job_name,
                    "job_salary" => $job_salary,
                    "address_details" => $address_details
                ));
            }
        }
        // dd($result);
        return view("company")->with("companies", $result);
    }

    function exportCompany(){
        return Excel::download(new CompaniesExport, 'company.xlsx');
        
    }
}
