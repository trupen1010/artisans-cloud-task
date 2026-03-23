<?php

namespace App\Http\Requests\Teacher;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ParentRequest extends FormRequest
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
        $rules = [
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:parents,email',
            'phone' => 'nullable|string|max:15',
            'status' => 'required|in:active,inactive',
        ];

        if ($this->method() == 'PUT') {
            $parent = $this->route('parent');
            if ($parent) {
                $rules['email'] = "required|email|unique:parents,email,{$parent->id}";
            }
        }

        return $rules;
    }

    /**
     * Get custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Parent name is required',
            'name.max' => 'Parent name must not exceed 100 characters',
            'email.required' => 'Email address is required',
            'email.email' => 'Email must be a valid email address',
            'email.unique' => 'This email address is already registered',
            'status.required' => 'Status is required',
            'status.in' => 'Selected status is invalid',
        ];
    }
}
