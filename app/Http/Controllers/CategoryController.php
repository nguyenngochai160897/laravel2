<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = new Category();
        $categories = $category->getAllCategory();
        return view("admin.category.index-category")->with("categories", $categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.category.add-category");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "name" => "required"
        ]);
        if($validator->fails()){
            return redirect()->route('create-category')
                        ->withErrors($validator)
                        ->withInput();
        }
        $category = new Category;
        $category->name = $request->input("name");
        $category->createCategory();
        return redirect()->route("category");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = new Category;
        $category->id = $id;
        return view("admin.category.update-category")->with("category", $category->getCategory());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            "name" => "required"
        ]);
        $category = new Category;
        $category->id = $id;
        $category->name = $request->input("name");
        $category->updateCategory();
        return redirect()->route("category");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = new Category;
        $category->id = $id;
      
        $data = $category->deleteCategory();
        if($data['status'] == "failed"){
            $message = "Co mot vai bai viet lien quan den danh muc nay?Khong the xoa";
            return redirect()->route("category")->withErrors(['errors'=> $message]);
        }
        return redirect()->route("category");
    }
}
