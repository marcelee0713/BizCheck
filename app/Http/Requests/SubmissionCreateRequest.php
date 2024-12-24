<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmissionCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // General Information
            'title' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string', 'max:10000'],

            // Competitors
            'competitors' => ['nullable', 'array'],
            'competitors.*.type' => ['required_with:competitors', 'in:DIRECT,INDIRECT'],
            'competitors.*.name' => ['required_with:competitors', 'string', 'max:255'],
            'competitors.*.description' => ['string', 'max:3500'],

            // Metrics
            'metrics' => ['nullable', 'array'],
            'metrics.*.name' => ['required_with:metrics', 'string', 'max:255'],
            'metrics.*.value' => [
                'required_with:metrics',
                'regex:/^\d{1,8}(\.\d{1,2})?$/',
            ],
            'metrics.*.description' => ['nullable', 'string', 'max:5000'],

            // Objectives and Challenges
            'objectives' => ['nullable', 'array'],
            'objectives.*' => ['string', 'max:150'],

            'challenges' => ['nullable', 'array'],
            'challenges.*' => ['string', 'max:150'],

            // Additional Insights
            'additionalInsights' => ['nullable', 'array'],
            'additionalInsights.*' => ['string', 'max:150'],
        ];
    }

    /**
     * Get custom error messages for validation errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'The title is required.',
            'title.max' => 'The title may not exceed 100 characters.',
            'description.required' => 'The description is required.',
            'description.max' => 'The description may not exceed 10,000 characters.',
            'competitors.*.type.in' => 'Competitor type must be either DIRECT or INDIRECT.',
            'metrics.*.value.regex' => 'Each metric value must be a valid number with up to 8 digits before the decimal and 2 digits after.',
        ];
    }
}
