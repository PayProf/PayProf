<?php

namespace App\Http\Resources;

use App\Models\Etablissement;
use Illuminate\Http\Resources\Json\JsonResource;

class EnseignantInterventionResource extends JsonResource
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
            "interventions" => $this->interventions->map(function ($intervention) {
                return [
                    "IntituleIntervention" => $intervention->intitule_intervention,
                    "AnneeUniv" => $intervention->annee_univ,
                    "Semestre" => $intervention->semestre,
                    "DateDebut" => $intervention->date_debut,
                    "DateFin" => $intervention->date_fin,
                    "VisaUae" => $intervention->visa_uae,
                    "VisaEtab" => $intervention->visa_etab,
                    "NbrHeures" => $intervention->Nbr_heures,
                    "NomEtab" => $intervention->etablissement->nom,
                    "Ville" => $intervention->etablissement->ville,
                ];
            }),
    

            // "intituleintervention"=> $this->interventions->first()->intitule_intervention,
            // "anneeuniv"=>$this->interventions->first()->annee_univ,
            // "semestre"=>$this->interventions->first()->semestre,
            // "date_debut"=>$this->interventions->first()->date_debut,
            // "date_fin"=>$this->interventions->first()->date_fin,
            // "visa_uae"=>$this->interventions->first()->visa_uae,
            // "visa_etab"=>$this->interventions->first()->visa_etab,
            // "Nbrheures"=>$this->interventions->first()->Nbr_heures,
            // "NomEtab"=>$this->interventions->first()->etablissement->nom,
            // "ville"=>$this->interventions->first()->etablissement->ville,
                



        ];
    }
}
