<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdministrateurResource extends JsonResource
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
        'PPR'=>$this->PPR,
        'nom'=>$this->nom,
        'prenom'=>$this->prenom,
        'etablissement_id'=>$this->etablissement_id,
        'user_id'=>$this->user_id,
        'email_perso'=>$this->email_perso,
        
        ];
    }
}