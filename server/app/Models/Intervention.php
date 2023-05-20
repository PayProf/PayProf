<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intervention extends Model
{
    use HasFactory;
     protected $fillable=
     [
        'intitule_intervention',
        'annee_univ',
        'semestre',
        'date_debut',
        'Nbr_heures',
        'date_fin',
        'enseignant_id',
        'etablissement_id',
        'visa_uae',
        'visa_etab',
     ];


    public function etablissement()
    {
        return $this->belongsTo(Etablissement::class );
      
    }

    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class );
      
    }

}
