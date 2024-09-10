<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Exceptions\HttpResponseException;

class updateuserrequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255', // Name is validated only if present
            'email' => [
                'sometimes',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($this->user),  // Ignore the current user's email during update
            ],
            'password' => 'sometimes|nullable|string|min:6',  // Password is optional during update
            'role' => 'sometimes|string|in:user,admin,manager', // Role is optional, validated only if present
        ];
    }

    /**
     * Custom error messages for validation.
     */
    public function messages()
    {
        return [
            'password.min' => 'The password must be at least 6 characters long.',
            'name.string' => 'The name must be a string.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email has already been taken.',
        ];
    }

    /**
     * Custom attributes for validation errors.
     */
    public function attributes()
    {
        return [
            'name' => 'اسم المستخدم',
            'email' => 'عنوان البريد الالكتروني',
            'password' => 'كلمة المرور',
        ];
    }

    /**
     * Custom response for failed validation.
     */

protected function failedValidation(Validator $validator)
{
    throw new HttpResponseException(
        response()->json([
            'status' => 'failed validation',
            'errors' => $validator->errors(),
        ], 422)
    );
}
}
