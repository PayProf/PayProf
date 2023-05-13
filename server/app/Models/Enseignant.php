<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Enseignant extends Model
{
    use HasFactory;
    public function etablissement(){
        return $this->belongsTo(Etablissement::class);
    }

    public function grade(){
        return $this->belongsTo(Grade::class);
    }

    public function interventions()
    {
        return $this->hasMany(Intervention::class);
    }

    public function paiements()
    {
        return $this->hasMany(Paiements::class);
    }

    public function cash()
    {
        $inter=DB::table('interventions')
        ->where([
            ['visa_uae','=',1,],
            ['visa_etab','=',1,],
            ['enseignant_id','=',2,]
        ])
        ->first();
      ;
    
      $ens_id=$inter->enseignant_id;

       $ens=DB::table('paiements')
       ->where(
          
           'enseignant_id','=',$ens_id
       )
       ->first();
        $price=$ens->Net + ($ens->VH * $ens->Taux_H );
          $donnees=array($price,$ens->Annee_univ,$inter->intitule_intervention);
        return$donnees  ;

    }
}
