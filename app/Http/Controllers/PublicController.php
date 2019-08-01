<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Category;

class PublicController extends Controller
{   
    function defaultSideBar(){
        $categories = Category::all();
        $postRecent = Post::orderBy('id', 'desc')->where("state" , 1)->paginate(5);
        $data = [
            "categories" => $categories,
            "postRecent" => $postRecent
        ];
        return $data;
    }
    function index(){
        return view("public.index")->with($this->defaultSideBar());
    }

    function showPost($id){
        $post = new Post();
        $post->id = $id;
        $data = $this->defaultSideBar();
        $data = array_merge($data, ['post' => $post->getPost()]);
        return view("public.blog-detail")->with($data);
    }
    function showCategory($id){
        $data = $this->defaultSideBar();
        $category = new Category();
        $category->id = $id;
        $category = $category->getCategory();
        $data = array_merge($data, ['posts' => $category->getCategory()->posts]);
        return view("public.category-detail")->with($data);
    }
}
