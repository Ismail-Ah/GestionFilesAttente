<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Agence;
use App\Models\Service;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
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

    public function liveSearch(Request $request)
{
    try {
        $query = $request->input('query');

        if (!$query) {
            return response()->json(['error' => 'Query parameter is required'], 400);
        }

        $agents = User::where('nom', 'LIKE', "%{$query}%")->with('agence', 'services')->get();
        $services = auth()->user()->role === 'AGENT'
                ? auth()->user()->services()->where('nom', 'LIKE', "%{$query}%")->with('agence', 'agent')->get()
                : Service::where('nom', 'LIKE', "%{$query}%")->with('agence', 'agent')->get();
        $agencies = Agence::where('nom', 'LIKE', "%{$query}%")->get();

        return response()->json([
            'agents' => $agents,
            'services' => $services,
            'agences' => $agencies
        ]);
    } catch (\Exception $e) {
        \Log::error('Live Search Error: ' . $e->getMessage());

        return response()->json(['error' => 'Internal Server Error'], 500);
    }
}

    public function liveQueue()
{
    return view('liveQueue');
}
public function homeQueue(Agence $agence)
{
    return view('homeQueue');
}
}
