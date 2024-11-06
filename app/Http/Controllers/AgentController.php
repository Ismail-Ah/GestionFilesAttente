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
        // Valider les données de la requête
        $data = $request->validate([
            'nom' => ['required', 'string', 'min:3', 'max:100', 'unique:users,nom'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users,email'],
            'password' => ['required', 'string', 'min:3'],
            'service_ids' => ['nullable', 'array'], // S'assurer que c'est un tableau
            'service_ids.*' => ['integer', 'exists:services,id'], // Valider chaque ID dans le tableau
            'role' =>'required',
        ]);
    
        // Créer l'agent
        $agent = User::create([
            'nom' => $data['nom'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => $data['role'],
        ]);
    
        // Associer les services à l'agent
        if (isset($data['service_ids']) && is_array($data['service_ids'])) {
            foreach ($data['service_ids'] as $service_id) {
                $service = Service::find($service_id);
                if ($service) {
                    $service->user_id = $agent->id;
                    $service->save();
                }
            }
        }
        if ($agent->role==='AGENT'){
            return response()->json("Agent ajouté avec succès", 201);
        }    
        else return response()->json("Administrateur ajouté avec succès", 201);
    }
    
    public function updateAgent(Request $request, User $user) {
        // Valider les données de la requête
        $data = $request->validate([
            'nom' => ['required', 'string', 'min:3', 'max:100', Rule::unique('users', 'nom')->ignore($user->id)],
            'email' => ['required', 'string', 'email', 'max:100', Rule::unique('users', 'email')->ignore($user->id)],
            'service_ids' => ['nullable', 'array'], // S'assurer que service_ids est un tableau
            'service_ids.*' => ['integer', 'exists:services,id'], // Valider chaque ID de service
            'role'=>'required',
        ]);
    
        // Mettre à jour les détails de l'utilisateur
        $user->update([
            'nom' => $data['nom'],
            'email' => $data['email'],
            'role' => $data['role'],
        ]);
    
        // Détacher les services existants de l'utilisateur
        $existingServices = $user->services->pluck('id')->toArray();
        foreach ($existingServices as $serviceId) {
            $service = Service::find($serviceId);
            if ($service) {
                $service->user_id = null;
                $service->save();
            }
        }
    
        // Associer les nouveaux services à l'utilisateur
        if (isset($data['service_ids']) && is_array($data['service_ids'])) {
            foreach ($data['service_ids'] as $service_id) {
                $service = Service::find($service_id);
                if ($service) {
                    $service->user_id = $user->id;
                    $service->save();
                }
            }
        }
    
        // Retourner une réponse de succès
        return response()->json(['message' => 'Utilisateur modifié avec succès!']);
    }
    
    
    public function getServices() {
        $services = Service::where('user_id', auth()->user()->id)->get();
        return response()->json($services);
    }
    public function getAgents()
    {
        $agents = User::where('role','!=', 'ADMIN')->get();
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

    
    

    public function showFormAjouterAgent()
    {
        return view('create-agent',["role"=>auth()->user()->role]);
    }
    public function showFormEditerAgent()
    {
        return view('editer-agent',["role"=>auth()->user()->role]);
    }

}