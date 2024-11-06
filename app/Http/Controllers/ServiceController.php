<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Agence;
use App\Models\Service;
use App\Models\Files_Attente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{
    public function store(Request $request, Agence $agence)
    {
        try {
            $validator = $this->validateService($request,$agence->id);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
    
            $service = $agence->services()->create($this->serviceData($request));
            Files_Attente::create([
                'service_id' => $service->id,
            ]);
    
            return response()->json(['message' => 'Service ajouté avec succès!', 'service' => $service], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de l\'ajout du service: ' . $e->getMessage()], 500);
        }
    }
    
    public function updateService(Request $request, Service $service)
    {
        try {
            $validator = $this->validateService($request, $service->agence_id,$service->id);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            $service->update($this->serviceData($request));
            return response()->json(['message' => 'Service modifié avec succès!', 'service' => $service], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la modification du service: ' . $e->getMessage()], 500);
        }
    }
    

    public function fetchServices()
    {
        $services = $this->getServicesQuery()->latest()->get();
        return response()->json($services);
    }

    public function serviceInfo(Service $service)
    {
        return response()->json([
            'service' => $service,
            'numéroTicket' => $service->ticket()->numéro ?? null,
            'agence' => $service->agence,
        ]);
    }

    public function getServices(Agence $agence = null)
    {
        $query = $agence ? $agence->services() : Service::query();
        $services = $query->with('agence', 'agent')->get();
        return response()->json($services);
    }

    public function getServices1() {
        $user = auth()->user();
    
        if ($user->role === 'AGENT') {
            // Obtenez les services associés à l'utilisateur avec les relations nécessaires
            $services = $user->services()->with('agence', 'agent')->get();
        } else {
            // Obtenez tous les services avec les relations nécessaires
            $services = Service::query()->with('agence', 'agent')->get();
        }
    
        return response()->json($services);
    }
    
    public function getServices2(Agence $agence)
    {
        // Si l'utilisateur n'est pas authentifié, on retourne les services de l'agence.
        if (!auth()->check()) {
            return response()->json($agence->services);
        }
    
        $user = auth()->user();
    
        // Si l'utilisateur est un AGENT, on vérifie s'il appartient à l'agence demandée.
        if ($user->role === 'AGENT') {
            $services = $user->services;
    
            // Vérification si le premier service de l'utilisateur appartient à l'agence spécifiée.
            if ($services->isNotEmpty() && $services->first()->agence_id === $agence->id) {
                return response()->json($services);
            } else {
                // Retourne une réponse avec un code 403 (Accès refusé) si l'agence ne correspond pas.
                return response()->json(['message' => 'Accès refusé'], 403);
            }
        }
    
        // Si l'utilisateur n'est pas un AGENT ou l'agence correspond, on retourne les services de l'agence.
        return response()->json($agence->services);
    }

    public function getServices3(Agence $agence)
    {
        
    
        // Si l'utilisateur n'est pas un AGENT ou l'agence correspond, on retourne les services de l'agence.
        return response()->json($agence->services);
    }
    

    public function getServicesForQueue(Agence $agence)
    {
        $services = $agence->services->map(function ($service) {
            $file = $service->fileAttente()->latest()->first();
            $service->currentTicket = $file ? $file->tickets()->where('statut', 'EN_ATTENT')->first()->numéro ?? null : null;
            return $service;
        });

        return response()->json([
            'services' => $services,
            'agence_nom' => $agence->nom
        ]);
    }

    public function deleteService(Service $service)
    {
        $service->delete();
        return response()->json(['message' => 'Service supprimé avec succès!']);
    }

   
    public function showFormAjouterService(Agence $agence)
    {
        return view('ajouter-service', ["role" => auth()->user()->role]);
    }

    public function showFormEditerService()
    {
        return view('editer-service', ["role" => auth()->user()->role]);
    }

    public function getServicesOfAgent(User $user)
    {
        return response()->json($user->services()->with('agence', 'agent')->get());
    }

    public function changeEtatService(Service $service)
    {
        $service->etat = $service->etat === 'ACTIF' ? 'INACTIF' : 'ACTIF';
        $service->save();
        return response()->json();
    }

    private function validateService(Request $request, $agence_id, $ignoreId = null)
    {
        return Validator::make($request->all(), [
            'nom' => [
                'required',
                'string',
                'max:500',
                Rule::unique('services')
                    ->where(function ($query) use ($request, $agence_id) {
                        return $query->where('nom', $request->nom)
                                     ->where('agence_id', $agence_id);
                    })
                    ->ignore($ignoreId),
            ],
            'heure_debut' => 'required',
            'heure_fin' => 'required',
            'nom_en' => 'nullable|string|max:500',
            'nom_ar' => 'nullable|string|max:500',
        ]);
    }

    private function serviceData(Request $request)
    {
        return [
            'nom' => $request->input('nom'),
            'etat' => 'ACTIF',
            'heure_debut' => $request->input('heure_debut'),
            'heure_fin' => $request->input('heure_fin'),
            'nom_en' => $request->input('nom_en'),
            'nom_ar' => $request->input('nom_ar'),
        ];
    }

    private function getServicesQuery()
    {
        return auth()->user()->role === 'AGENT'
            ? auth()->user()->services()
            : Service::query();
    }
}
