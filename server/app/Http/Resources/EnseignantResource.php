<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EnseignantResource extends JsonResource
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

            'id' => $this->id ,
            "nom"=>$this->nom,
            'prenom'=>$this->prenom,
            'PPR'=>$this->PPR,
            'DateNaissance'=>$this->date_naissance,
            'IdEtablissement'=>$this->etablissement->id,
            'NomEtab'=>$this->etablissement->nom,
            'IdGrade'=>$this->grade->id,
            'CodeGrade'=>$this->grade->designation,
            'IdUser'=>$this->user_id,
            'Email'=>$this->email_perso,
            'image'=>$this->image,
            

          
          
           

       ];
    }
}
