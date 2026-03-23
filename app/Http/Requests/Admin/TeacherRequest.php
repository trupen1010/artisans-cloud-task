<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class TeacherRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:15',
            'status' => 'required|in:active,inactive',
        ];

        if ($this->method() == 'PUT') {
            $teacher = $this->route('teacher');
            if ($teacher) {
                $userId = $teacher->user_id;
                $rules['email'] = "required|email|unique:users,email,$userId";
                $rules['password'] = 'nullable|string|min:8|confirmed';
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
            'name.required' => 'Teacher name is required',
            'name.string' => 'Teacher name must be a valid string',
            'name.max' => 'Teacher name must not exceed 100 characters',

            'email.required' => 'Email address is required',
            'email.email' => 'Email must be a valid email address',
            'email.unique' => 'This email address is already registered',

            'password.required' => 'Password is required',
            'password.string' => 'Password must be a valid string',
            'password.min' => 'Password must be at least 8 characters',
            'password.confirmed' => 'Password confirmation does not match',

            'phone.string' => 'Phone number must be a valid string',
            'phone.max' => 'Phone number must not exceed 15 characters',

            'status.required' => 'Status is required',
            'status.in' => 'Selected status is invalid',
        ];
    }
}
