<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validator;
use App\User;

class UserController extends Controller
{
    // public $successStatus = 200;

    // public function login(Request $request){ 
    //     $validator = Validator::make($request->all(), [ 
    //         'email' => 'required|email', 
    //         'password' => 'required', 
    //     ]);
    //     if ($validator->fails()) { 
    //         return response()->json(['error'=>$validator->errors()], 401);            
    //     }
    //     if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
    //         $user = Auth::user(); 
    //         $success['token'] =  $user->createToken('token_user')->accessToken; 
    //         return response()->json(['success' => $success], $this->successStatus); 
    //     } 
    //     else{ 
    //         return response()->json(['error'=>'Unauthorized'], 401); 
    //     } 
    // }

    // public function register(Request $request) 
    // { 
    //     $validator = Validator::make($request->all(), [ 
    //         'name' => 'required', 
    //         'email' => 'required|email', 
    //         'password' => 'required', 
    //         'c_password' => 'required|same:password', 
    //     ]);
    //     if ($validator->fails()) { 
    //         return response()->json(['error'=>$validator->errors()], 401);            
    //     }
    //     //check email must unique
    //     $user = User::where("email", request("email"))->get();
    //     if($user){
    //         return response()->json(['error' => "email have been existed"], 409);
    //     }
    //     $input = $request->all(); 
    //     $input['password'] = bcrypt($input['password']); 
    //     $user = User::create($input); 
    //     $success['token'] =  $user->createToken('token_user')->accessToken; 
    //     // $success['name'] =  $user->name;
    //     return response()->json(['success'=>$success], $this-> successStatus); 
    // }

    // public function details() 
    // { 
    //     $user = Auth::user(); 
    //     return response()->json(['success' => $user], $this-> successStatus); 
    // } 

    function login(Request $request){
        $validator = Validator::make($request->all(),[
            "email" => "required|email",
            "password" => "required|min:8"
        ]);
        if(Auth::attemp(['email' => $request->input('email'), "password" => $request->input("password")])){
            return redirect()->route('/admin');
        }
    }
}
