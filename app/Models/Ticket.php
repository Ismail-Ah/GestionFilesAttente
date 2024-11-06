<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'numéro', 'statut', 'files_attente_id',
    ];

    public function fileAttente()
    {
        return $this->belongsTo(Files_Attente::class,'files_attente_id');
    }

    public function service()
    {
        return $this->fileAttente->service();
    }

    public function agence()
    {
        return $this->fileAttente->agence;
    }
}
