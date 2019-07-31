<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use KubAT\PhpSimple\HtmlDomParser;
use DB;
use CronJob;
use CronCompany;

class CronController extends Controller
{
    function getDom($link){
        $ch = curl_init($link);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("cookie: G_AUTHUSER_H=0; _ga=GA1.2.1312062635.1564059424; _gac_UA-42033311-1=1.1564059424.CjwKCAjwpuXpBRAAEiwAyRRPgXMrV0UsrvGoV10A5SAIulc42nlr7JywwE09zpL9zmH9rx7bs6k7XRoCHB8QAvD_BwE; _gcl_aw=GCL.1564059424.CjwKCAjwpuXpBRAAEiwAyRRPgXMrV0UsrvGoV10A5SAIulc42nlr7JywwE09zpL9zmH9rx7bs6k7XRoCHB8QAvD_BwE; _gcl_au=1.1.1263366454.1564059424; _gac_UA-42033311-2=1.1564059424.CjwKCAjwpuXpBRAAEiwAyRRPgXMrV0UsrvGoV10A5SAIulc42nlr7JywwE09zpL9zmH9rx7bs6k7XRoCHB8QAvD_BwE; _gac_UA-42033311-4=1.1564059424.CjwKCAjwpuXpBRAAEiwAyRRPgXMrV0UsrvGoV10A5SAIulc42nlr7JywwE09zpL9zmH9rx7bs6k7XRoCHB8QAvD_BwE; G_ENABLED_IDPS=google; _fbp=fb.1.1564059424670.517532390; _gid=GA1.2.1308154215.1564363812; fbm_403551049745808=base_domain=.itviec.com; cvmissing=value; G_AUTHUSER_H=0; recent_searches=; uvts=7903dd40-0035-41b7-6dbf-77d96ccbd939; auto_jr_lightbox=true; remember_user_token=W1syNTM1NDldLCIkMmEkMTAkdk5XdG5FRXpwQU5rNHMyTkozQi9kZSIsIjE1NjQ0NTU3MzQuOTgwMTY3Il0%3D--6f8f2364424205d4b76beafd5e94c126944a9f3c; close_jr_slidein=true; _ITViec_session=ZkdDdjlDbVdmOGtNMW1uem02NHl0N00xTnM2K3AwYi9YeUMwQ1pUUHQzSC9WS3ByQjZBZm5FcHpCQnp4SmsySk5kb3dRMzI2OVVHbjFkeGw2WitlUVJWZmpCVjA5SHJFZGJxQ3FkZGIyT21LNStkRDFpWmJQdnhJdzI0dktESnFXMzZJUi83TmtKWFIrcGU4QnBSKytlN3Z1NWVIdlJwNzA3V0dKcnlaanpQQU1hT3BNczZRSGdSTGo2am5oUjdhTDBtTFEvOGc2eHNHdnNsc3JUSUpaMVFKSDFqQmR2anhyaXdTeUVBVWppK1JsSm9yc3VZNC9OY0gwNVNVWlhISlJPSHNDcHd0T0N3OXpMN3ZSd2JVVEhFSlRmb0RpYlZ5cUxoMXgzRnJzTCtneUdsTGJLWUliQ1B3bTRIbG80NDh6dnRpNllCVWc5NDlJOUdmR2t3cUtBPT0tLWp1S09IdVNRL1MvRkJvOS9xZzlwSkE9PQ%3D%3D--d7ec6307362213dec463d46b7e51f9f9f546f2cb"));
        $content = curl_exec($ch);
        curl_close($ch);
        $dom = HtmlDomParser::str_get_html($content);
        return $dom;
    }

    //add job to file json from itviec
    function addJob(){
        $html = $this->getDom("https://itviec.com/it-jobs");
        $result = array();
        foreach($html->find('.title a') as $element){
            // dd($element);
            $url_detail = "https://itviec.com".$element->href;
            $html_detail = $this->getDom($url_detail);

            $job_title = trim($html_detail->find("h1.job_title", 0)->plaintext);
            $salary = trim($html_detail->find(".salary-text", 0)->plaintext);
            $skill = trim($html_detail->find(".tag-list", 0)->plaintext);
            $skill = preg_replace("/\s+/", ",", $skill);
            $benefit = "";
            foreach($html_detail->find(".culture_description ul") as $des){
                $benefit.=$des;
            }
            $description = '';
            foreach($html_detail->find(".description li") as $des){
                $description .= $des;
            }

            $requirement = "";

            foreach($html_detail->find(".experience li") as $des){
                $requirement .= $des;
            }
            
            array_push($result,[
                "job_title" => $job_title,
                "salary" => $salary,
                "skill" => $skill,
                "benefit" => $benefit,
                "description" => $description,
                "requirement" => $requirement
            ]);

        }
        print_r(count($result));
        // erase all data from file
        $handle = fopen ("job.json", "w+");
        fclose($handle);

        $fp = fopen('job.json', 'w');
        fwrite($fp, json_encode($result));
        fclose($fp);
       
    }

    function addCompany(){
        $html = $this->getDom("https://itviec.com/best-it-companies-2019");
        $result = array();

        foreach($html->find('.best-company__header .name a') as $element){
            $url_detail = $element->href;
            $html_detail = $this->getDom($url_detail);
            $company_name = trim($html_detail->find("h1.title", 0)->plaintext);
            $logo = $html_detail->find(".has-overtime.logo img", 0)->src;
            $outsourcing = trim($html_detail->find(".group-icon", 0)->plaintext);
            $address = trim($html_detail->find(".name-and-info span", 0)->plaintext);

            $overview = "";
            foreach($html_detail->find(".paragraph p") as $des){
                if($des->plaintext != ""){
                    $overview.= $des;
                }
            }
            array_push($result,[
                "company_name" => $company_name,
                "logo" => utf8_encode($logo),
                "employer" => $outsourcing,
                "address" => $address,
                "overview" => $overview,
            ]);
            // break;
        }
        //erase all data from file
        $handle = fopen ("company.json", "w+");
        fclose($handle);

        $fp = fopen('company.json', 'w');
        fwrite($fp, json_encode($result));
        fclose($fp);
    }

    function addJobFromTopDev(){
        $html = $this->getDom("https://topdev.vn/it-jobs");
        $result = array();
        
        foreach($html->find(".pagination a") as $page){
            
            $page_html = $this->getDom($page->href);
            foreach($page_html->find('.bold-red a') as $element){
                $url_detail = $element->href;
                $page_html = $this->getDom($url_detail);
                
                $job_title = trim($page_html->find(".job-title", 0)->plaintext);
                
                $skill = "";
                foreach($page_html->find(".tag-skill") as $ski){
                    $skill.=$ski->plaintext.",";
                }
    
                $salary = $page_html->find(".orange.text-lg", 0)->plaintext;
                $benefit = "";
                foreach($page_html->find(".benefit-name") as $ben){
                    $benefit .= $ben;
                }
    
                $description = "";
                foreach($page_html->find("#job-description") as $des){
                    $description .= $des;
                }
                $requirement = "";
                foreach($page_html->find(".job-requirement-must-have.push-top-sm") as $re){
                    $requirement .= $re;
                }
                
                array_push($result,[
                    "job_title" => $job_title,
                    "salary" => $salary,
                    "skill" => $skill,
                    "benefit" => $benefit,
                    "description" => $description,
                    "requirement" => $requirement
                ]);
                
            }
            // break;
        }
        
        //erase all data from file
        $handle = fopen ("job-topdev.json", "w+");
        fclose($handle);

        $fp = fopen('job-topdev.json', 'w');
        fwrite($fp, json_encode($result));
        fclose($fp);
        dd(count($result));
    }

    function addCompanyFromTopDev(){
        $html = $this->getDom("https://topdev.vn/it-jobs");
        $result = array();
        
        foreach($html->find(".pagination a") as $page){
            
            $page_html = $this->getDom($page->href);
            foreach($page_html->find('.bold-red a') as $element){
                $url_detail = $element->href;
                $page_html = $this->getDom($url_detail);
                $company_name = trim($page_html->find(".company-name", 0)->plaintext);
                $logo = $page_html->find(".logo", 0)->href;
                $employer = trim($page_html->find(".group-icon", 0));
                $address = trim($page_html->find(".country-name", 0)->plaintext);
    
                $overview = "";
                foreach($page_html->find(".des_full") as $ov){
                    $overview .= $ov;
                }
                
                array_push($result,[
                    "company_name" => $company_name,
                    "logo" => $logo,
                    "employer" => $employer,
                    "address" => $address,
                    "overview" => $overview,
                ]);
                
            }
            // break;
        }
        
        //erase all data from file
        $handle = fopen ("company-topdev.json", "w+");
        fclose($handle);

        $fp = fopen('company-topdev.json', 'w');
        fwrite($fp, json_encode($result));
        fclose($fp);
        dd(count($result));
    }
}
