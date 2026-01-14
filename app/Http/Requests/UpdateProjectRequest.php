<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
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
            'industry' => 'sometimes|array',
            'industry.en' => 'sometimes|string',
            'industry.id' => 'sometimes|string',
            'system_type' => 'sometimes|array',
            'system_type.en' => 'sometimes|string',
            'system_type.id' => 'sometimes|string',
            'title' => 'sometimes|array',
            'title.en' => 'sometimes|string',
            'title.id' => 'sometimes|string',
            'scope' => 'sometimes|array',
            'scope.en' => 'sometimes|string',
            'scope.id' => 'sometimes|string',
            'outcome' => 'sometimes|array',
            'outcome.en' => 'sometimes|string',
            'outcome.id' => 'sometimes|string',
            'featured' => 'nullable|boolean',
            'order' => 'nullable|integer',
        ];
    }
}
