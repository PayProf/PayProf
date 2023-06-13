<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInterventionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
         $method=$this->method();

        if($method == "PATCH"){
            return [

                //all the fields will be sent to the db (also the the fields unchanged )

//                'IntituleIntervention'=>['required'],
//                'AnneeUniv'=>['required'],
//                'Semestre'=>['required'],
//                'DateDebut'=> ['required'],
//                'DateFin'=>['required'],
//                'NbrHeures'=>['required'],
//                'PPR'=>['required'],
                    'VisaUae'=>['sometimes','required'],
                    'VisaEtab' =>['sometimes','required'],
                    'IntituleIntervention'=>['sometimes','required'],
                    'AnneeUniv'=>['sometimes','required'],
                    'Semestre'=>['sometimes','required'],
                    'DateDebut'=> ['sometimes'],
                    'DateFin'=>['sometimes'],
                    'NbrHeures'=>['sometimes'],
                    'PPR'=>['sometimes'],

                ];
        }
}
// protected function prepareForValidation()

//     {           if ($this->VisaUae)   {$this->merge(['visa_uae'=> ucfirst($this->VisaUae),]);}
//                 if ($this->VisaEtab)   {$this->merge(['visa_etab'=> ucfirst($this->VisaEtab),]);}


//     }

}

