<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaiementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return[
            'Id'=>$this->id,
            'Id enseignant'=>$this->enseignant_id,
            'Id etablissement'=>$this->etablissement_id,
            'Volume horaire'=>$this->VH,
            'Taux horaire'=>$this->Taux_H,
            'Salaire brut'=>$this->Brut,
            'Impot sur le revenu'=>$this->IR,
            'Salaire Net'=>$this->Net,
            'Année universitaire'=>$this->Annee_univ,
            'Semestre'=>$this->Semestre,

        ];

    }
}
