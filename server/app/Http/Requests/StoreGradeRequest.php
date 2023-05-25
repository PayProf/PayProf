<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGradeRequest extends FormRequest
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

            'Designation'=>['required'],
            'ChargeStatutaire'=>['required'],
            'TauxHoraireVacation'=>['required'],
            
        ];
    }
    protected function prepareForValidation()
    {
        $this->merge([

            'designation'=>ucfirst($this->Designation),
            'charge_statutaire'=>ucfirst($this->ChargeStatutaire),
            'Taux_horaire_vacation'=>ucfirst($this->TauxHoraireVacation),
           
        ]);
    }
}
