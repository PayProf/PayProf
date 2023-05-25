<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EnseignantPaymentsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
            return [
                'Nom'=>$this->nom,
                'Prenom'=>$this->prenom,
                'Email'=>$this->email_perso,
                "paiements"=>$this->paiements->map(function($paiements){
                return [
                    
                'VolumeHoraire'=>$paiements->VH,
                'TauxHoraire'=>$paiements->Taux_H,
                'Brute'=>$paiements->Brut,
                'InteretSurRevenu'=>$paiements->IR,
                'Net'=>$paiements->Net,
                'AnneeUniv'=>$paiements->Annee_univ,
                'Semestre'=>$paiements->Semestre,
                'NomEtab'=>$paiements->etablissement->nom,
                'Ville'=>$paiements->etablissement->ville,
                    


            ];
            }),
            

        ];

    }
}
