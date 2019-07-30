<?php

namespace App\Exports;

use App\Company;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class CompaniesExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $company = new Company;
        $companies = $company->getAllCompany();

        
        $result = array();
        foreach($companies as $company){
            $jobs = array();
            $address_details="";
            foreach($company['address_details'] as $address){
                $address_details.=$address['name'].", ";
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
                    "address_details" => $address_details,
                    "job_name" => $job_name,
                    "job_salary" => $job_salary,
                    
                ));
            }
        }
        return collect($result);
    }

    public function headings(): array
    {
        return [
            'id',
            'company_name',
            'resource',
            'num_employees',
            'market',
            'address',
            "address_details",
            "job_name",
            "job_salary"
        ];
    }

}
