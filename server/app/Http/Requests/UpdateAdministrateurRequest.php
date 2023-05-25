<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdministrateurRequest extends FormRequest
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
        if($method=='PUT'){
        return [
            'PPR'=>['required'],
            'nom'=>['required'],
            'prenom'=>['required'],
            'etablissement_id'=>['required'],
            'user_id'=>['required'],
            'email_perso'=>['required','email'],
            ];
        }else{
            return [
                'PPR'=>['sometimes','required'],
                'nom'=>['sometimes','required'],
                'prenom'=>['sometimes','required'],
                'etablissement_id'=>['sometimes','required'],
                'user_id'=>['sometimes','required'],
                'email_perso'=>['sometimes','required','email'],
                ];
        }
    }
}
