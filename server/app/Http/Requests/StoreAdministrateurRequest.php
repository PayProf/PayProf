<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdministrateurRequest extends FormRequest
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
                'PPR' => ['required', 'numeric','min:7'],
                'nom' => ['required', 'string','max:30'],
                'prenom' => ['required', 'string','max:30'],
                'etablissement_id' => ['required','exists:etablissements'],
                'email_perso' => ['required', 'email']
            ];
        
    }
}
