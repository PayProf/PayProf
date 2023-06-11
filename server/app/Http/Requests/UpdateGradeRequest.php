<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGradeRequest extends FormRequest
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
        $method = $this->method();          //to know the type of the request method(PUT||PATCH)

        if ($method == 'PUT') {
            return [
                'Designation' => ['required'],
                'ChargeStatutaire' => ['required'],
                'TauxHoraireVacation' => ['required'],
            ];
        } else                                //if the method is PATCH
        {
            return [
                'Designation' => ['sometimes', 'required'],
                'ChargeStatutaire' => ['sometimes', 'required'],
                'TauxHoraireVacation' => ['sometimes', 'required'],
            ];
        }
    }

    protected function prepareForValidation()
    {


        if ($this->Designation) {
            $this->merge(['designation' => ucfirst($this->Designation),]);
        }
        if ($this->ChargeStatutaire) {
            $this->merge(['charge_statutaire' => ucfirst($this->ChargeStatutaire),]);
        }
        if ($this->TauxHoraireVacation) {
            $this->merge(['Taux_horaire_vacation' => ucfirst($this->TauxHoraireVacation),]);
        }
    }
}
