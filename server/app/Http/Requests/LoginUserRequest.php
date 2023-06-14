<?php

namespace App\Http\Requests;

use App\Rules\email_check;
use Illuminate\Foundation\Http\FormRequest;

class LoginUserRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', new email_check],
            'password'=>['required','string','min:6']
        ];
    }
}
