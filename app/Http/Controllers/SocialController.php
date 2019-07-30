<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use App\User;
use Auth;

class SocialController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        $getInfo = Socialite::driver($provider)->user(); 
        $user = $this->createUser($getInfo,$provider); 
        auth()->login($user); 
        return redirect()->to('/');
    }

    function createUser($getInfo,$provider){
        $user = User::where('email', $getInfo->email)->first();
        
        if (!$user) {
       
            $user = User::create([
                'name'     => $getInfo->name,
                'email'    => $getInfo->email,
                'provider_id' => $getInfo->id,
                "provider" => $provider
            ]);
        }
        return $user;
    }

    public function logout(Request $request) {
        Auth::logout();
        return redirect('/login');
    }
}
