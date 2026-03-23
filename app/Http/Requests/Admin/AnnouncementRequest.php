<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AnnouncementRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:200',
            'body' => 'required|string',
            'target' => 'required|in:teachers,students,parents,both',
        ];
    }

    /**
     * Get custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Announcement title is required',
            'title.string' => 'Announcement title must be a valid string',
            'title.max' => 'Announcement title must not exceed 200 characters',

            'body.required' => 'Announcement body/description is required',
            'body.string' => 'Announcement body must be a valid string',

            'target.required' => 'Target audience is required',
            'target.in' => 'Selected target is invalid',
        ];
    }
}
