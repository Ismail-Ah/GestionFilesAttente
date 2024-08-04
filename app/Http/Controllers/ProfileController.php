<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Agence;
use App\Models\Service;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function getNmbrServiceAgence(){
        return response()->json(["nmbAgences"=>Agence::count(),"nmbServices"=>Service::count(),"nmbAgents"=>User::where('role','AGENT')->count()]);
    }
    public function user(){
        $user=auth()->user();
        return response()->json($user);
    }
    public function user2(User $user){
        return response()->json($user);
    }
    public function updateProfileImage(Request $request, User $user)
{
    try {
        // Valider le fichier téléchargé
        $request->validate([
            'image' => ['required', 'image', 'max:2048'],
        ]);

        // Vérifier si un fichier est présent
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($user->profile_image && $user->profile_image !== "/fallback-avatar.jpg") {
                Storage::delete('public/' . $user->profile_image);
            }

            // Obtenir le fichier et générer un nom unique
            $file = $request->file('image');
            $uniqueFileName = $user->id . "-" . uniqid() . ".jpg"; // Générer un nom de fichier unique

            // Redimensionner l'image et la convertir au format JPEG
            $image = imagecreatefromstring(file_get_contents($file));
            $resizedImage = imagescale($image, 300, 300);
            ob_start();
            imagejpeg($resizedImage);
            $imageData = ob_get_clean();

            // Stocker l'image redimensionnée dans un fichier
            Storage::put('public/profile_images/' . $uniqueFileName, $imageData);

            // Mettre à jour le chemin de l'image dans la base de données
            $user->profile_image = $uniqueFileName;
            $user->save();
        }

        return response()->json(['message' => 'Image de profil mise à jour avec succès!']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Erreur lors de la mise à jour de l\'image de profil: ' . $e->getMessage()], 500);
    }
}


    public function getLogo(){
        return response()->json(auth()->user()->profile_image);
    }
}
