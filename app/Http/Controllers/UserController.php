<?php

namespace App\Http\Controllers;

use App\Listeners\exampleListener;
use App\Models\User;
use App\Events\exampleEvent;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function register(Request $request){
        $infoUser = $request->validate([
            "email"=> ["required",'email',Rule::unique('users','email')],
            "password"=>["required",'confirmed','min:8'],
            "nom"=>["required",'min:3','max:20',Rule::unique('users','nom')],
        ]);
        $infoUser['password']=bcrypt($infoUser["password"]);
        $user = User::create($infoUser);
        auth()->login($user);
        return redirect("/")->with("success","Account created successfuly.");
    }
    public function login(Request $request){
        $infoUser = $request->validate([
            "password"=>["required",'min:8'],
            "email"=>["required",'min:3','email'],
        ]);
        if (auth()->attempt(["email"=> $infoUser["email"],"password"=> $infoUser["password"]])) {
            $request->session()->regenerate();
            $url = "/";
            if (auth()->user()->role=='ADMINISTRATION' || auth()->user()->role==='AGENT'){
                $url='/dashboard';
            }
            else if (auth()->user()->role=='ADMIN'){
                $url='/profile';
            }
            return redirect($url)->with("success","You are login in.");
        }
        else{
            return redirect("/")->with("error","Invalid Login.");
        }
}
    public function logout(Request $request){
        auth()->logout();
        return redirect("/")->with("success","You are loggin out.");

    }
}