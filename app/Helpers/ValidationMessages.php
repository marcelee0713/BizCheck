<?php

namespace App\Helpers;

class ValidationMessages
{
    public static function password()
    {
        return [
            'password.required'  => 'The password field is required.',
            'password.string'    => 'The password must be a valid string.',
            'password.min'       => 'The password must be at least 8 characters long.',
            'password.regex'     => 'The password must include at least one uppercase letter, one lowercase letter, one number, and one special character.',
            'password.confirmed' => 'The password confirmation does not match.',
        ];
    }
}
