<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;

class UpdateInsightRequest extends FormRequest
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
            'slug' => [
                'sometimes',
                'string',
                Rule::unique('insights', 'slug')->ignore($this->route('insight'), 'slug')
            ],
            'title' => 'sometimes|array',
            'title.en' => 'sometimes|string',
            'title.id' => 'sometimes|string',
            'excerpt' => 'sometimes|array',
            'excerpt.en' => 'sometimes|string',
            'excerpt.id' => 'sometimes|string',
            'content' => 'sometimes|array',
            'content.en' => 'sometimes|string',
            'content.id' => 'sometimes|string',
            'category' => 'sometimes|array',
            'category.en' => 'sometimes|string',
            'category.id' => 'sometimes|string',
            'read_time' => 'nullable|string',
            'published' => 'nullable|boolean',
            'featured_image' => 'nullable|url',
        ];
    }
}
