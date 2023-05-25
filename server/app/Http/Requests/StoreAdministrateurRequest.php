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
            'PPR'=>['required'],
            'nom'=>['required'],
            'prenom'=>['required'],
            'etablissement_id'=>['required'],
            // 'user_id'=>['required'],
            'email_perso'=>['required','email'],
          //  'Email'=>['required','email'],
            ];
    }
}
