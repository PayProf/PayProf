<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEtablissementRequest extends FormRequest
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
        
            
            return [
                'nom' => ['required', 'string','max:30'],
                'code' => ['required', 'string'],
                'telephone' => ['required', 'string','min:10'],
                'FAX' => ['required', 'string','max:15'],
                'ville' => ['required', 'string'],
            ];
            
        
            
    }
}
