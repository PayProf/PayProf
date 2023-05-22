<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    
    public function IdEnseignant($prof)
    {
        $enseignant = DB::table('enseignants')
                      ->select('id')
                      ->where('PPR', $prof)
                      ->first();
        return $enseignant->id;

    }

    // public function IdEtablissement($etab)
    // {
    //     $etablissement = DB::table('etablissements')
    //                   ->select('id')
    //                   ->where('nom', $etab)
    //                   ->first();
    //     return $etablissement->id;

    // }


    public function etablissement()
    {
        return $this->belongsTo(Etablissement::class );
      
    }

    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class );
      
    }



}
