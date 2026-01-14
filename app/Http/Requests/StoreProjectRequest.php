<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'industry' => 'required|array',
            'industry.en' => 'required|string',
            'industry.id' => 'required|string',
            'system_type' => 'required|array',
            'system_type.en' => 'required|string',
            'system_type.id' => 'required|string',
            'title' => 'required|array',
            'title.en' => 'required|string',
            'title.id' => 'required|string',
            'scope' => 'required|array',
            'scope.en' => 'required|string',
            'scope.id' => 'required|string',
            'outcome' => 'required|array',
            'outcome.en' => 'required|string',
            'outcome.id' => 'required|string',
            'featured' => 'nullable|boolean',
            'order' => 'nullable|integer',
        ];
    }
}
