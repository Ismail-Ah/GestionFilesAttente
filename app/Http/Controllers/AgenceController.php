<?php

namespace App\Http\Controllers;

use App\Models\Agence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AgenceController extends Controller
{
    public function showFormAjouterAgence()
    {
        return view('ajouteragence', ['role' => auth()->user()->role]);
    }

    public function store(Request $request)
    {
        $validator = $this->validateAgence($request);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        $agency = Agence::create($request->only(['nom', 'email', 'adress', 'telephone']));
    
        return response()->json(['message' => 'Agence ajoutée avec succès!', 'agency' => $agency], 201);
    }
    
    public function updateAgence(Request $request, Agence $agence)
    {
        $validator = $this->validateAgence($request, $agence->id);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        $agence->update($request->only(['nom', 'email', 'adress', 'telephone']));
    
        return response()->json(['message' => 'Agence modifiée avec succès!', 'agency' => $agence], 200);
    }
    
    public function getAgences()
    {
        return response()->json(Agence::all());
    }

    public function getAgence(Agence $agence)
    {
        return response()->json($agence);
    }

    public function deleteAgence(Agence $agence)
    {
        $agence->delete();
        return response()->json('Agence supprimée avec succès!');
    }

   

    public function showFormEditerAgence()
    {
        return view('editer-agence', ['role' => auth()->user()->role]);
    }

    private function validateAgence(Request $request, $ignoreId = null)
    {
        return Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'email' => 'required|email',
            'adress' => 'required|string|max:255',
            'telephone' => [
                'required',
                'string',
                'regex:/^\+?\d{10,}$/',
                Rule::unique('agences', 'telephone')->ignore($ignoreId),
            ],
        ]);
    }
}
