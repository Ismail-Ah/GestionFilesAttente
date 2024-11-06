<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $table = 'services'; // Specify the table name if different from the default (optional)

    protected $fillable = [
        'nom', 'etat', 'agence_id','heure_fin','heure_debut','nom_en','nom_ar',
    ];

    public function agence(){
        return $this->belongsTo(Agence::class,'agence_id');
    }
    public function fileAttente(){
        return $this->hasMany(Files_Attente::class,'service_id');
    }
    public function ticket()
    {
    return $this->fileAttente()->latest()->first()->tickets()->latest()->first();
    }

    public function agent(){
        return $this->belongsTo(User::class,'user_id');
    }

}
