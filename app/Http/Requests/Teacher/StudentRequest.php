<?php

namespace App\Http\Requests\Teacher;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StudentRequest extends FormRequest
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
            'email' => 'required|email|unique:students,email',
            'phone' => 'nullable|string|max:15',
            'parent_id' => [
                'nullable',
                Rule::exists('parents', 'id')->where(function (Builder $query) {
                    $teacherId = Auth::user()?->teacher?->id;

                    if ($teacherId) {
                        $query->where('teacher_id', $teacherId);
                    }
                }),
            ],
            'status' => 'required|in:active,inactive',
        ];

        if ($this->method() == 'PUT') {
            $student = $this->route('student');
            if ($student) {
                $rules['email'] = "required|email|unique:students,email,{$student->id}";
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
            'name.required' => 'Student name is required',
            'name.max' => 'Student name must not exceed 100 characters',
            'email.required' => 'Email address is required',
            'email.email' => 'Email must be a valid email address',
            'email.unique' => 'This email address is already registered',
            'parent_id.exists' => 'Selected parent does not exist',
            'status.required' => 'Status is required',
            'status.in' => 'Selected status is invalid',
        ];
    }
}
