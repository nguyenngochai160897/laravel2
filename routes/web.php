<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('company');
// });

// Route::get("/list-company", "CompanyController@getAllCompany");

// Route::get("/export", "CompanyController@exportCompany");

// Route::get("/", function(){
//     return view("index");
// })->middleware("auth");

// Route::get("/login", function(){
//     return view("login");
// })->name("login");

// Route::get('/login/{provider}', 'SocialController@redirect');
// Route::get('/callback/{provider}', 'SocialController@callback');
// Route::get("/logout", 'SocialController@logout');

Route::get("/register", function(){
    return view("admin.user.register");
});

Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        return view("admin.dashboard.index");
    })->middleware("auth")->name("dashboard");
   
    Route::prefix("category")->group(function(){
        Route::get("/", "CategoryController@index")->name("category");
        Route::get("/add-category", "CategoryController@create");
        Route::post("/add-category", "CategoryController@store")->name("add-category");
        Route::get("/update-category/{id}", "CategoryController@edit")->name("edit-category");
        Route::post("/update-category/{id}", "CategoryController@update")->name("update-category");
        Route::post("/delete-category/{id}", "CategoryController@destroy")->name("delete-category");
    });

    Route::prefix("post")->group(function(){
        Route::get("/", "PostController@index")->name("post");
        Route::get("/add-post", "PostController@create");
        Route::post("/add-post", "PostController@store")->name("add-post");
        Route::get("/update-post/{id}", "PostController@edit")->name("edit-post");
        Route::post("/update-post/{id}", "PostController@update")->name("update-post");
        Route::post("/delete-post/{id}", "PostController@destroy")->name("delete-post");
    });

    Route::get("/login", function(){
        return view("admin.user.login");
    })->name("get-login");
    Route::post("/login","UserController@login")->name("login");

    Route::get("/register", function(){return view("admin.user.register");})->name("get-register");
    Route::post("/register", "UserController@register")->name("register");

    Route::post("/logout", "UserController@logout")->name("logout");
});

Route::get("blog", function(){ return view("public.index");});
Route::get("blog/{id}", function(){ return view("public.post-detail");});
Route::get("category/{id}", function(){ return view("public.category-detail");});


// clone job from itviec.com
Route::get("/job-itviec", "CronController@addJob");
Route::get("/company-itviec", "CronController@addCompany");

//clone job from topdev
Route::get("/job-topdev", "CronController@addJobFromTopDev");
Route::get("/company-topdev", "CronController@addCompanyFromTopDev");

//clone job, company from topdev to add db
Route::get("/clone/{name}", "CloneController@clone");
