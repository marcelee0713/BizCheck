<?php

namespace App\Http\Requests;

use App\Constants\BusinessModels;
use App\Constants\Industries;
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
       $businessModels = BusinessModels::MODELS;
       $industries = Industries::Industries;

        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:10000' ],

        ];
    }
}
