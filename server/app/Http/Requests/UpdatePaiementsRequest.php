<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaiementsRequest extends FormRequest
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
        $method = $this->method();
        if ($method == 'PUT') {
            return [
                'enseignant_id' => ['required'],
                'etablissement_id' => ['required'],
                'VH' => ['required'],
                'Taux_H' => ['required'],
                'Brut' => ['required'],
                'IR' => ['required'],
                'Net' => ['required'],
                'Annee_univ' => ['required'],
                'Semestre' => ['required']

            ];
        } else {
            //'sometimes'=>allow a field to be optional.
            return [
                'enseignant_id' => ['sometimes', 'required'],
                'etablissement_id' => ['sometimes', 'required'],
                'VH' => ['sometimes', 'required'],
                'Taux_H' => ['sometimes', 'required'],
                'Brut' => ['sometimes', 'required'],
                'IR' => ['sometimes', 'required'],
                'Net' => ['sometimes', 'required'],
                'Annee_univ' => ['sometimes', 'required'],
                'Semestre' => ['sometimes', 'required']

            ];
        }
    }
}
