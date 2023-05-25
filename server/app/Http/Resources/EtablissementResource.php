<?php

namespace App\Http\Resources;

use App\Models\Enseignant;
use Illuminate\Http\Resources\Json\JsonResource;

class EtablissementResource extends JsonResource
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
            'id'=>$this->id,
            'code'=>$this->code,
            'nom'=>$this->nom,
            'ville'=>$this->ville,
            'Telephone'=>$this->telephone,
            'FAX'=>$this->FAX,
            'Nombre des enseignants'=>$this->Nbrenseignants,
            'Enseignants'=>EnseignantResource::collection($this->whenLoaded('Enseignants')),
            //allows you to specify an action to be taken on a related model
            // if it has been loaded. 
            'Interventions'=>InterventionResource::collection($this->whenLoaded('Interventions')),
            'Administrateurs'=>AdministrateurResource::collection($this->whenLoaded('Administrateur')),
        ];
        
    }
}