<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etablissement extends Model
{
    use HasFactory;
    public function enseignants(){
        return $this->hasMany(Enseignant::class);
    }

    public function administrateurs(){
        return $this->hasMany(Administrateur::class);
    }

    public function interventions(){
        return $this->hasMany(Intervention::class);
    }

    public function paiements()
    {
        return $this->hasMany(Paiements::class);
    }

}
