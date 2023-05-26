<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaiementsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return True;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
       
        return [
            'enseignant_id'=>['required'],
            'etablissement_id'=>['required'],
            'VH'=>['required'],
            'Taux_H'=>['required'],
            'Brut'=>['required'],
            'IR'=>['required'],
            'Net'=>['required'],
            'Annee_univ'=>['required'],
            'Semestre'=>['required']

        ];
    
    }
}
