<?php

namespace App\Http\Requests;

use App\Constants\BusinessModels;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
       $businessModels = BusinessModels::MODELS;

        return [
            'business_name' => ['required', 'string', 'max:255'],
            'business_model' => ['required', 'in:' . implode(',', $businessModels) ],
            'description' => ['nullable', 'string', 'max:5000' ],
            'target_audience' => ['nullable', 'string', 'max:255' ],
            'unique_selling_point' => ['nullable', 'string', 'max:255' ],
            'location' => ['nullable', 'string', 'max:500' ],
            'phone_number' => ['nullable', 'string', 'max:255' ],
            'website_url' => ['nullable', 'string', 'max:255'],
            // 'email' => [
            //     'required',
            //     'string',
            //     'lowercase',
            //     'email',
            //     'max:255',
            //     Rule::unique(User::class)->ignore($this->user()->id),
            // ],
        ];
    }
}
