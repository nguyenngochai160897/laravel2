<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = "companies";
    function jobs(){
        return $this->hasMany("App\Job");
    }
    
    function address_details(){
        return $this->hasMany("App\AddressDetail");
    }

    function getAllCompany($option=null){
        // $company_col = \Schema::getColumnListing($this->table);
        // $address_detail_col = \Schema::getColumnListing("address_details");
        // $job_col = \Schema::getColumnListing("jobs");
        // $company_col = array_unique(array_merge($company_col, $address_detail_col, $job_col));

        if(array_key_exists($option['searchTerm'],["name", "salary", "market", "job"])){
            return [
                "statusCode" => 401,
                "error" => "search field not allow"
            ];
        }
        $company = Company::with("jobs", "address_details")->get();
        return $company;
    }
}
