<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInterventionRequest extends FormRequest
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
        return [

            'IntituleIntervention'=>['required'],
            'AnneeUniv'=>['required'],
            'Semestre'=>['required'],
            'DateDebut'=> ['required'],
            'DateFin'=>['required'],
            'NbrHeures'=>['required'],
            // 'VisaUae'=>$this->visa_uae,
            // 'VisaEtab'=>$this->visa_etab,
            'PPR'=> ['required'],
           
        ];
    }

    protected function  prepareForValidation() 
    {       $this->merge([

            'intitule_intervention'=> ucfirst($this->IntituleIntervention),
            'annee_univ'=> ucfirst($this->AnneeUniv),
            'semestre'=> ucfirst($this->Semestre),
            'date_debut'=> ucfirst($this->DateDebut),
            'Nbr_heures'=> ucfirst($this->NbrHeures),
            'date_fin'=> ucfirst($this->DateFin),
            'enseignant_id'=> ucfirst($this->IdProf),
            'etablissement_id'=> ucfirst($this->IdEtab),
            'visa_uae'=>$this->VisaUae,
            'visa_etab'=>$this->VisaEtab,
    ]);
      

    }
    


}