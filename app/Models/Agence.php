<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agence extends Model
{
    use HasFactory;
    protected $table = 'agences'; // Specify the table name if different from the default (optional)

    protected $fillable = [
        'nom', 'email', 'adress', 'telephone',
    ];

    public function services(){
        return $this->hasMany(Service::class,"agence_id");
    }
}
