<?php


namespace App\Helpers;

class ValidationRules
{
    public static function password()
    {
        return [
            'required',
            'string',
            'min:8',
            'regex:/[A-Z]/',     // Uppercase
            'regex:/[a-z]/',     // Lowercase
            'regex:/[0-9]/',     // Digit
            'regex:/[@$!%*?&]/', // Special char
            'confirmed',
        ];
    }

    public static function email()
    {
        return [
            'required',
            'string',
            'email',
            'max:255',
            'unique:users,email', // Must be unique in the users table
        ];
    }
}
