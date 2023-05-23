<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InterventionShowMoreResource extends JsonResource
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

            'IntituleIntervention'=>$this->intitule_intervention,
            'AnneeUniv'=>$this->annee_univ,
            'Semestre'=>$this->semestre,
            'DateDebut'=> $this->date_debut,
            'DateFin'=>$this->date_fin,
            'VisaUae'=>$this->visa_uae,
            'VisaEtab'=>$this->visa_etab,
            'PPRProf'=> $this->enseignant->PPR,
            'NomEtab'=>$this->etablissement->nom,
            'VilleEtab'=>$this->etablissement->ville,
            'NomProf'=>$this->enseignant->nom,
            'PrenomProf'=>$this->enseignant->prenom,
            'EmailProf'=>$this->enseignant->email_perso,
            'NbrHeures'=>$this->Nbr_heures,
        ];

        }
}
