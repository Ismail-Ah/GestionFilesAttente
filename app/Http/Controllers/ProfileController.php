<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Agence;
use App\Models\Service;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function getNmbrServiceAgence(){
        return response()->json(["nmbAgences"=>Agence::count(),"nmbServices"=>Service::count(),"nmbAgents"=>User::where('role','AGENT')->count()]);
    }
    public function user(){
        $user=auth()->user();
        return response()->json(["nom"=>$user->nom,"email"=>$user->email,"role"=>$user->role]);
    }
}
