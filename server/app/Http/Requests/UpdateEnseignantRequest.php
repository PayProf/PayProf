<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        $method=$this->method(); // to check the http method 
           
        if($method=="PUT"){
                return [          
                    
                    //all the fields will be sent to the db (also the the fields unchanged )

                        'PPR'=>['required'],
                        'nom'=>['required'],
                        'prenom'=>['required'],
                        'DateNaissance'=>['required','date'],
                      //  'Etablissement'=>['required'],
                        'Grade'=>['required'],
                       // 'email_perso'=>['required','email','unique:enseignants'],
                       // 'IdUser',
                       
                    ];
            }

            else // if the method is PATCH
            { 
                
                return
                 [                 
                    
                    // only the specified fileds will be modified and sent to the db
                    'email_perso'=>['sometimes','required','email','unique:enseignants,email'],
                 ];
                
            }
    }
    // protected function prepareForValidation()
    // {
    //     $this->merge([
    //         'date_naissance'=> ucfirst($this->DateNaissance),
    //        // 'etablissement_id'=>ucfirst($this->IdEtablissement),
    //         'grade_id'=>ucfirst($this->IdGrade),
    //        // 'user_id'=>ucfirst($this->IdUser),
    //     ]);
    // }
}
