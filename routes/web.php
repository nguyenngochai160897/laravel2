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

Route::get("/", function(){
    return view("admin.user.register");
});

Route::auth();

Route::get("/cron", "CronController@addJob");
