<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Etablissement extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'nom',
        'telephone',
        'ville',
        'FAX',

    ];
 
    public function enseignants()
    {
        return $this->hasMany(Enseignant::class);
    }

    public function administrateurs()
    {
        return $this->hasMany(Administrateur::class);
    }

    public function interventions()
    {
        return $this->hasMany(Intervention::class);
    }

    public function paiements()
    {
        return $this->hasMany(Paiements::class);
    }

    public function directeur()
    {
        return $this->hasOne(Directeur::class);
    }
}
