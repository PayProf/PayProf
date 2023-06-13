<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDirecteurRequest extends FormRequest
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
            'PPR'=>['required','max:10','unique:directeurs'],
            'nom'=>['required'],
            'prenom'=>['required'],
            'DateNaissance'=>['required','date'],
            'email_perso'=>['required','email','unique:directeurs'],
            // 'etablissement_id'=>['required']
            
            
           // 'IdUser'=>['required'],
        ];
    }
}
