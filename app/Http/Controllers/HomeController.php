<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    {
        return view('dashboard',["role"=>auth()->user()->role]);
    }

    public function statistiques()
    {
        return view('statistiques',["role"=>auth()->user()->role]);
    }

    public function profile()
    {
        return view('profile',["role"=>auth()->user()->role]);
    }
}
