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
                'nom' => ['required', 'string','max:30'],
                'code' => ['required', 'string'],
                'telephone' => ['required', 'string','min:10'],
                'FAX' => ['required', 'string','max:15'],
                'ville' => ['required', 'string'],
            ];
    }else{
        //'sometimes'=>allow a field to be optional.
        return [
            'nom'=>['sometimes','required','string','max:30'],
            'code'=>['sometimes','required',, 'string'],
            'telephone'=>['sometimes','required','string','min:10'],
            'FAX'=>['sometimes','required','string','max:15'],
            'ville'=>['sometimes','required','string'],
        ];
    }


    }

}
