<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    function category(){
        return $this->belongsTo("App\Category");
    }
    function getAllPost($option){
        
        if($option['search']['category_id']=="all" && $option['search']['state']=="all"){
            return Post::with("category")->paginate($option['limit']);
        }
        //...
        if($option['search']['category_id'] != "all" && $option['search']['state']=="all"){
            return Post::with("category")->where(["category_id"=> $option['search']['category_id']])->paginate($option['limit']);
        }
        if($option['search']['category_id'] == "all" && $option['search']['state'] != "all"){
            return Post::with("category")->where(["state"=> $option['search']['state']])->paginate($option['limit']);
        }
        return Post::with("category")->where(["state"=> $option['search']['state'], "category_id"=> $option['search']['category_id']])->paginate($option['limit']);
    }
    function getPost(){
        return Post::find($this->id);
    }
    function createPost(){
        $this->save();
    }
    function updatePost(){
        Post::where("id", $this->id)->update([
            "title" => $this->title,
            "category_id" => $this->category_id,
            "image" => $this->image,
            "snapshort" => $this->snapshort,
            "content" => $this->content,
            "state" => $this->state
        ]);
    }
    function deletePost() {
        Post::destroy($this->id);
    }
}
