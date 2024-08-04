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
            $this->validateService($request);
    
            $service = $agence->services()->create($this->serviceData($request));
            Files_Attente::create([
                'nom' => "Fichier_Service_D'Attente",
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
            $this->validateService($request, $service->id);
    
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
            'nomAgence' => $service->agence->nom,
            'agence_id' => $service->agence->id,
        ]);
    }

    public function getServices(Agence $agence = null)
    {
        $query = $agence ? $agence->services() : Service::query();
        $services = $query->with('agence', 'agent')->get();
        return response()->json($services);
    }

    public function getServices2(Agence $agence)
    {
        if (!auth()->check()) {
            return response()->json($agence->services);
        }

        $user = auth()->user();
        if ($user->role === 'AGENT' && $user->agence->id != $agence->id) {
            return response()->json(null); // or appropriate response indicating restricted access
        }

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

    private function validateService(Request $request, $ignoreId = null)
    {
        Validator::make($request->all(), [
            'nom' => [
                'required',
                'string',
                'max:255',
                Rule::unique('services')->ignore($ignoreId),
            ],
            'heure_debut' => 'required|date_format:H:i',
            'heure_fin' => 'required|date_format:H:i',
            'nom_en' => 'nullable|string|max:255',
            'nom_ar' => 'nullable|string|max:255',
        ])->validate();
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
