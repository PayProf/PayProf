<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreEnseignantRequest extends FormRequest
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
            'PPR'=>['required'],
            'nom'=>['required'],
            'prenom'=>['required'],
            'DateNaissance'=>['required','date'],
            'IdEtablissement'=>['required'],
            'IdGrade'=>['required'],
            'IdUser'=>['required'],
        ];
    }
    protected function prepareForValidation()
    {
        $this->merge([
            'date_naissance'=> ucfirst($this->DateNaissance),
            'etablissement_id'=>ucfirst($this->IdEtablissement),
            'grade_id'=>ucfirst($this->IdGrade),
            'user_id'=>ucfirst($this->IdUser),
        ]);
    }

     
    
}
