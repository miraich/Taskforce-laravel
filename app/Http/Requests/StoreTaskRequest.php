<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
            'title' => 'required|string|min:10|max:40',
            'description' => 'required|string|min:10|max:150',
            'category' => 'exists:categories,id',
            'address' => 'nullable|string',
            'budget' => 'required|integer|min:500',
            'deadline' => 'required|date|after_or_equal:' . now()->format('d-m-Y H:i:s'),
            'files' => 'sometimes',
        ];
    }
}
