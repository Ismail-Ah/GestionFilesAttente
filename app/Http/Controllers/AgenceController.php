<?php

namespace App\Http\Controllers;

use App\Models\Agence;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class AgenceController extends Controller
{
    public function showFormAjouterAgence(){
        return view('ajouteragence',["role"=>auth()->user()->role]);
    }
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'email' => 'required|email',
            'adress' => 'required|string|max:255',
            'telephone' => ['required','string','unique:agences,telephone','regex:/^\+?\d{10,}$/'],

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
            //return $validator;
        }

        // If validation passes, create and store the agency
        $agency = Agence::create([
            'nom' => $request->input('nom'),
            'email' => $request->input('email'),
            'adress' => $request->input('adress'),
            'telephone' => $request->input('telephone'),
        ]);

        return response()->json(['message' => 'Agence ajoutée avec succès!', 'agency' => $agency], 201);
    }

    public function agencies(){
        $agencies = Agence::all();
        return response()->json($agencies);
    }

    public function getAgence(Agence $agence){
        return response()->json($agence);
    }

    public function getAgences(){

            $agencies = Agence::paginate(4);

        return response()->json($agencies);
    }

    public function deleteAgence(Agence $agence){
        $agence->delete();
        return response()->json('hi');
    }

    public function updateAgence(Request $request, Agence $agence)
{
    // Validate the request
    $validator = Validator::make($request->all(), [
        'nom' => 'required|string|max:255',
        'email' => 'required|email',
        'adress' => 'required|string|max:255',
        'telephone' => [
            'required',
            'string',
            'regex:/^\+?\d{10,}$/',
            Rule::unique('agences', 'telephone')->ignore($agence->id),
        ],
    ]);

    // Return validation errors if any
    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // Update the agency
    $agence->update([
        'nom' => $request->input('nom'),
        'email' => $request->input('email'),
        'adress' => $request->input('adress'),
        'telephone' => $request->input('telephone'),
    ]);

    // Return a success message
    return response()->json(['message' => 'Agence modifiée avec succès!', 'agency' => $agence], 200);
}

        public function showFormEditerAgence()
        {
            return view('editer-agence',["role"=>auth()->user()->role]);
        }

    

    
}
