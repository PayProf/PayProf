<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GradeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {    return [
        
        'IdGrade' =>$this->id,
        'Designation'=>$this->designation,
        'ChargeStatutaire'=>$this->charge_statutaire,
        'TauxHoraireVacation'=>$this->Taux_horaire_vacation,
            
            ];

    }
}
