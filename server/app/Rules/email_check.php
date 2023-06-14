<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class email_check implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Vérifier si la valeur du champ est au format email attendu
        return filter_var($value, FILTER_VALIDATE_EMAIL) && strpos($value, '@payprof.com') !== false ;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ' Entree une adresse email au format example@payprof.com.';
    }
}
