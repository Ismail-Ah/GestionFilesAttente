<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Agence;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\Files_Attente;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    public function store(Request $request, Agence $agence)
    {
        // Validation des champs
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'heure_debut' => 'required|date_format:H:i',
            'heure_fin' => 'required|date_format:H:i',
            'nom_en' => 'nullable|string|max:255',  // Optional translation in English
            'nom_ar' => 'nullable|string|max:255',  // Optional translation in Arabic
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Création du service avec les champs additionnels
        $service = $agence->services()->create([
            'nom' => $request->input('nom'),
            'etat' => 'ACTIF',
            'heure_debut' => $request->input('heure_debut'),
            'heure_fin' => $request->input('heure_fin'),
            'nom_en' => $request->input('nom_en'), // Translation in English
            'nom_ar' => $request->input('nom_ar'), // Translation in Arabic
        ]);

        // Création de la file d'attente associée
        Files_Attente::create([
            'nom' => "Service_File_D'Attente",
            'service_id' => $service->id,
        ]);

        return response()->json(['message' => 'Service ajouté avec succès!', 'service' => $service], 201);
    }

    public function fetchServices()
    {
        $services = auth()->user()->role === 'AGENT' 
            ? auth()->user()->services()->latest()->get() 
            : Service::latest()->get();

        return response()->json($services);
    }

    public function serviceInfo(Service $service)
    {
        return response()->json([
            'service' => $service,
            'numéroTicket' => $service->ticket->numéro,
            'nomAgence' => $service->agence_of_service->nom,
        ]);
    }

    public function getServices()
    {
        $services = auth()->user()->role === 'AGENT'
            ? auth()->user()->services()->with('agence', 'agent')->paginate(4)
            : Service::with('agence', 'agent')->paginate(4);

        return response()->json($services);
    }

    public function getServices2()
    {
        $services = auth()->user()->role === 'AGENT'
            ? auth()->user()->services
            : Service::all();

        return response()->json($services);
    }

    public function deleteService(Service $service)
    {
        $service->delete();
        return response()->json(['message' => 'Service supprimé avec succès!']);
    }

    public function updateService(Request $request, Service $service)
    {
        $input = $request->all();

        if (!$this->validateTimeFormat($input['heure_debut']) || !$this->validateTimeFormat($input['heure_fin'], true)) {
            return response()->json(['errors' => ['Heure de début ou Heure de fin n\'est pas au format valide.']], 422);
        }

        $validator = Validator::make($input, [
            'nom' => [
                'required',
                'string',
                'max:255',
                Rule::unique('services')->where(fn($query) => $query->where('agence_id', $request->input('agence_id')))->ignore($service->id),
            ],
            'heure_debut' => 'required',
            'heure_fin' => 'required',
            'nom_en' => 'nullable|string|max:255',  // Optional translation in English
            'nom_ar' => 'nullable|string|max:255',  // Optional translation in Arabic
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $service->update([
            'nom' => $request->input('nom'),
            'heure_debut' => $request->input('heure_debut'),
            'heure_fin' => $request->input('heure_fin'),
            'nom_en' => $request->input('nom_en'), // Translation in English
            'nom_ar' => $request->input('nom_ar'), // Translation in Arabic
        ]);

        return response()->json(['message' => 'Service modifié avec succès!', 'service' => $service], 201);
    }

    protected function validateTimeFormat($value, $includeSeconds = false)
    {
        return $includeSeconds 
            ? \DateTime::createFromFormat('H:i:s', $value) !== false 
            : \DateTime::createFromFormat('H:i', $value) !== false;
    }

    public function showFormAjouterService(Agence $agence)
    {
        return view('ajouter-service', ["role" => auth()->user()->role]);
    }

    public function showFormEditerService()
    {
        return view('editer-service', ["role" => auth()->user()->role]);
    }

    public function getServicesOfAgent(User $user){
        return response()->json($user->services()->with('agence','agent')->paginate(4));
    }
}
