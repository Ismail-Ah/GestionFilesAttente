<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Agence;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function dashboard()
    {
        return $this->renderView('dashboard');
    }

    public function statistiques()
    {
        return $this->renderView('statistiques');
    }

    public function profile()
    {
        return $this->renderView('profile');
    }

    public function liveQueue()
    {
        return view('liveQueue');
    }

    public function liveSearch(Request $request)
    {
        try {
            $query = $request->input('query');

            if (empty($query)) {
                return response()->json(['error' => 'Query parameter is required'], 400);
            }

            $agents = User::where('nom', 'LIKE', "%{$query}%")
                ->with('agence', 'services')
                ->get();

            $services = $this->getServicesByRole($query);
            $agencies = Agence::where('nom', 'LIKE', "%{$query}%")->get();

            return response()->json([
                'agents' => $agents,
                'services' => $services,
                'agencies' => $agencies
            ]);
        } catch (\Exception $e) {
            Log::error('Live Search Error: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while processing your request'], 500);
        }
    }

    private function renderView($view)
    {
        return view($view, ['role' => auth()->user()->role]);
    }

    private function getServicesByRole($query)
    {
        $user = auth()->user();
        if ($user->role === 'AGENT') {
            return $user->services()
                ->where('nom', 'LIKE', "%{$query}%")
                ->with('agence', 'agent')
                ->get();
        }

        return Service::where('nom', 'LIKE', "%{$query}%")
            ->with('agence', 'agent')
            ->get();
    }
}
