<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Agence;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class AgentController extends Controller
{
    public function createAcount(Request $request) {
        // Validate request data
        $data = $request->validate([
            'nom' => ['required', 'string', 'min:3', 'max:100', 'unique:users,nom'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users,email'],
            'password' => ['required', 'string', 'min:3'],
            'service_ids' => ['nullable', 'array'], // Ensure it's an array
            'service_ids.*' => ['integer', 'exists:services,id'], // Validate each ID in the array
        ]);
    
        // Create the agent
        $agent = User::create([
            'nom' => $data['nom'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => 'AGENT',
        ]);
    
        // Attach services to the agent
        if (isset($data['service_ids']) && is_array($data['service_ids'])) {
            foreach ($data['service_ids'] as $service_id) {
                $service = Service::find($service_id);
                if ($service) {
                    $service->user_id = $agent->id;
                    $service->save();
                }
            }
        }
    
        return response()->json("Agent added successfully", 201);
    }
    
    public function getServices() {
        $services = Service::where('user_id', auth()->user()->id)->get();
        return response()->json($services);
    }
    public function getAgents()
    {
        $agents = User::where('role', 'AGENT')->paginate(4);
        foreach($agents as $agent){
            $agent->agence = $agent->agence();
            $agent->services = $agent->services();
        }
        
    
        return response()->json($agents);
    }

    public function getAgents2()
    {
    $agents = User::where('role', 'AGENT')->get();
    foreach($agents as $agent){
        $agent->agence = $agent->agence();
        $agent->services = $agent->services;
    }
    

    return response()->json($agents);
    }

    public function deleteAgent(User $agent){
        $agent->delete();
        return response()->json('hi');
    }

    public function getAgenceAgents(Agence $agence){
        $agents = $agence->services()->with('agent')->get()->pluck('agent')->filter();
        $agents->getCollection()->transform(function ($agent) {
        $agent->agence = $agent->agence();
        $agent->services = $agent->agence();
        return $agent;
    });

        return response()->json($agents);
    }

    public function getServiceAgents(Service $service){
        return response()->json($service->agent());
    }

    public function updateAgent(Request $request, User $user) {
        // Validate request data
        $data = $request->validate( [
            'nom' => ['required', 'string', 'min:3', 'max:100', Rule::unique('users', 'nom')->ignore($user->id)],
            'email' => ['required', 'string', 'email', 'max:100', Rule::unique('users', 'email')->ignore($user->id)],
            'service_ids' => ['nullable', 'array'], // Ensure service_ids is an array
            'service_ids.*' => ['integer', 'exists:services,id'], // Validate each service ID
        ]);

        // Update user details
        $user->update([
            'nom' => $data['nom'],
            'email' => $data['email'],
        ]);
    
        $existingServices = $user->services->pluck('id')->toArray();
        foreach ($existingServices as $serviceId) {
            $service = Service::find($serviceId);
            if ($service) {
                $service->user_id = null;
                
                $service->save();
            }
        }
        if (isset($data['service_ids']) && is_array($data['service_ids'])) {
            foreach ($data['service_ids'] as $service_id) {
                $service = Service::find($service_id);
                if ($service) {
                    $service->user_id = $user->id;
                    $service->save();
                }
            }
        }
    
    
        // Return success response
        return response()->json(['message' => 'Agent updated successfully!']);
    }
    

    public function showFormAjouterAgent()
    {
        return view('create-agent',["role"=>auth()->user()->role]);
    }
    public function showFormEditerAgent()
    {
        return view('editer-agent',["role"=>auth()->user()->role]);
    }

}
