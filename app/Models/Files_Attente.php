<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Files_Attente extends Model
{
    use HasFactory;
    protected $table = 'files_attentes'; // Specify the table name if different from the default (optional)

    protected $fillable = [
        'nom', 'service_id', 'tempsMoyenEnAttente',
    ];
    public function tickets(){
        return $this->hasMany(Ticket::class,"files_attente_id");
    }
    public function service(){
        return $this->belongsTo(Service::class,'service_id');
    }
    public function agence(){
        return $this->service->agence();
    }

}
