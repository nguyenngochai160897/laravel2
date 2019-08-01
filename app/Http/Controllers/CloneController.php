<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use KubAT\PhpSimple\HtmlDomParser;
use DB;
use function GuzzleHttp\json_encode;

class CloneController extends Controller
{
    function clone($name){
        //main dom
        $dom = HtmlDomParser::file_get_html("https://topdev.vn/it-jobs");
        foreach($dom->find(".pagination a") as $page){ // for each page
            $page_html = HtmlDomParser::file_get_html($page->href);
            foreach($page_html->find('.bold-red a') as $element){ // for each row/page
                $url_detail = $element->href;
                //dom detail
                $page_html = HtmlDomParser::file_get_html($url_detail);


                //............job.................
                if($name == "job"){
                    $job_title = trim($page_html->find(".job-title", 0)->plaintext);
                    $quantity = \rand(10, 100);
                    $description = "";
                    foreach($page_html->find("#job-description") as $des){
                        $description .= $des;
                    }
                    $job_level = \rand(1, 6);
                    $experience = \rand(1,2);
                    $requirement_must = "";
                    foreach($page_html->find(".job-requirement-must-have.push-top-sm") as $re){
                        $requirement_must .= $re;
                    }
                    $benefit = "";
                    foreach($page_html->find(".benefit-name") as $ben){
                        $benefit .= $ben;
                    }
                    $work_location = array();
                    foreach( $page_html->find(".work-location") as $lo){
                        array_push($work_location, trim($lo->plaintext));
                    }
                    $skill = array();
                    foreach($page_html->find(".tag-skill") as $ski){
                        array_push($skill, trim($ski->plaintext));
                    }

                    $salary = $page_html->find(".orange.text-lg", 0)->plaintext;
                    $target_age = array();
                    array_push($target_age, rand(23, 30));
                    $display_target_age = $target_age[0];
                    $status = rand(0, 1);

                    DB::table("clone_job_topdev")->insert([
                        "position_name" => $job_title,
                        "quantity" => $quantity,
                        "job_description" => $description,
                        "job_level" => $job_level,
                        "experience" => $experience,
                        "requirement_must" => $requirement_must,
                        "businesses_expect" => $benefit,
                        "work_location" => json_encode($work_location),
                        "skill" => json_encode($skill),
                        "salary" => json_encode($salary),
                        "target_age" => json_encode($target_age),
                        "display_target_age" => $display_target_age,
                        "status" => $status
                    ]);
                }
                //............company.................
                else if($name == "company"){
                    $name = trim($page_html->find(".company-name", 0)->plaintext);
                    $logo = $page_html->find(".logo", 0)->src;
                    $cover_image = $page_html->find(".img-responsive", 0)->src;
                    $address = "";
                    foreach($page_html->find(".company-address") as $add){
                        $address.=$add->plaintext;
                    }

                    $phone_number = "";
                    $nums = '0123456789';
                    $numsLength = strlen($nums);
                    for ($i = 0; $i < 10; $i++) {
                        $phone_number .= $nums[rand(0, $numsLength - 1)];
                    }
                    $member = $page_html->find(".group-icon", 0);
                    if($member == "") $member = null;
                    else $member = trim($member->plaintext);
                    $description = "";
                    foreach($page_html->find(".des_full") as $des){
                        $description.=$des;
                    }
                    DB::table("clone_company_topdev")->insert([
                        "name" => $name,
                        "logo" => $logo,
                        "cover_image" => $cover_image,
                        "address" => $address,
                        "phone_number" => $phone_number,
                        "member_scale" => $member,
                        "description" => $description
                    ]);
                }

                
            }
        }
        
    }
}
