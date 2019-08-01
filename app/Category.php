<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "categories";

    function posts(){
        return $this->hasMany('App\Post');
    }

    function getAllCategory() {
        $category = Category::with("posts")->get();
        return $category;
    }

    function getCategory(){
        return Category::with("posts")->find($this->id);
    }

    function createCategory(){
        $this->save();
    }

    function updateCategory(){
       Category::where("id", $this->id)->update(["name" => $this->name]);
    }

    function deleteCategory(){
        try {
            Category::destroy($this->id);
            return [
                'status' => "success",
            ];
        } catch (\Exception $e) {
            return [
               "status" => "failed",
            ];
        }

    }
}
