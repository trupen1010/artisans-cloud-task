<?php

namespace App\Http\Requests\Admin;

use App\Models\Teacher;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTeacherRequest extends FormRequest
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
        $teacherId = $this->route('teacher');
        $userId = Teacher::find($teacherId)?->user_id;

        return [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', "unique:users,email,{$userId}"],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'phone' => ['nullable', 'string', 'max:15'],
            'status' => ['required', 'in:active,inactive'],
        ];
    }
}
