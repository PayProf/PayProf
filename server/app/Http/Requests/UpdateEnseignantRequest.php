<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEnseignantRequest extends FormRequest
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
        $method = $this->method();        // to check the http method 

        if ($method == 'PUT') {
            return [

                //all the fields will be sent to the db (also the the fields unchanged )

                'PPR' => ['required'],
                'nom' => ['required'],
                'prenom' => ['required'],
                'DateNaissance' => ['required', 'date'],
                //  'Etablissement'=>['required'],
                'Grade' => ['required'],
                // 'email_perso'=>['required','email','unique:enseignants'],
                // 'IdUser',

            ];
        } else    // if the method is PATCH
        {

            return
                [

                    // only the specified fileds will be modified and sent to the db
                    'email_perso' => ['sometimes', 'required', 'email', 'unique:enseignants,email_perso'],
                ];
        }
    }
    protected function prepareForValidation()
    {

        if ($this->DateNaissance) {
            $this->merge(['date_naissance' => ucfirst($this->DateNaissance)]);
        }
        if ($this->dEtablissement) {
            $this->merge(['etablissement_i' => ucfirst($this->IdEtablissement)]);
        }
        if ($this->IdGrade) {
            $this->merge(['grade_id' => ucfirst($this->IdGrade)]);
        }
        if ($this->IdUser) {
            $this->merge(['user_id' => ucfirst($this->IdUser)]);
        }
    }
}
