<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInsightRequest extends FormRequest
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
            'slug' => 'required|string|unique:insights,slug',
            'title' => 'required|array',
            'title.en' => 'required|string',
            'title.id' => 'required|string',
            'excerpt' => 'required|array',
            'excerpt.en' => 'required|string',
            'excerpt.id' => 'required|string',
            'content' => 'required|array',
            'content.en' => 'required|string',
            'content.id' => 'required|string',
            'category' => 'required|array',
            'category.en' => 'required|string',
            'category.id' => 'required|string',
            'read_time' => 'nullable|string',
            'published' => 'nullable|boolean',
            'featured_image' => 'nullable|url',
        ];
    }
}
