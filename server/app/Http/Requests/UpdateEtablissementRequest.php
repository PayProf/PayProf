<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEtablissementRequest extends FormRequest
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
        //return an array of validation rules for the form fields.
        $method=$this->method();
        if($method=='PUT'){
        return [
            'nom'=>['required'],
            'code'=>['required'],
            'telephone'=>['required'],
            'FAX'=>['required'],
            'ville'=>['required'],
        ];
    }else{
        //'sometimes'=>allow a field to be optional.
        return [
            'nom'=>['sometimes','required'],
            'code'=>['sometimes','required'],
            'telephone'=>['sometimes','required'],
            'FAX'=>['sometimes','required'],
            'ville'=>['sometimes','required'],
        ];
    }


    }

}
