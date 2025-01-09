<?php

namespace App\Http\Requests\Profile;

use App\Constants\BusinessModels;
use App\Constants\Industries;
use Illuminate\Foundation\Http\FormRequest;

class ProfileEditRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
       $businessModels = BusinessModels::MODELS;
       $industries = Industries::Industries;

        return [
            'business_name' => ['required', 'string', 'max:255'],
            'business_model' => ['required', 'in:' . implode(',', $businessModels) ],
            'industry' => ['required', 'in:' . implode(',', $industries) ],
            'description' => ['nullable', 'string', 'max:5000' ],
            'target_audience' => ['nullable', 'string', 'max:255' ],
            'unique_selling_point' => ['nullable', 'string', 'max:255' ],
            'location' => ['nullable', 'string', 'max:500' ],
            'phone_number' => [
                'nullable',
                'string',
                'regex:/^(09\d{9}|(\+639)\d{9})$/',
                'max:13',
            ],
            'website_url' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'phone_number.regex' => 'The phone number must be a valid Philippine mobile number.',
        ];
    }
}
