<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;

class loginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // allows user access
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|string|email|max:255|exists:users,email', // التحقق من وجود البريد الإلكتروني
            'password' => 'required|string|min:6',
        ];
    }

    /**
     * Define custom attribute names.
     */
    public function attributes(): array
    {
        return [
            'email' => 'عنوان البريد الالكتروني',
            'password' => 'كلمة المرور',
        ];
    }

    /**
     * Define custom error messages.
     */
    public function messages(): array
    {
        return [
            'email.required' => 'عنوان البريد الالكتروني مطلوب',
            'email.exists' => 'عنوان البريد الالكتروني غير مسجل في نظامنا',
            'password.required' => 'كلمة المرور مطلوبة ويجب أن تكون على الأقل 6 محارف',
            'password.min' => 'كلمة المرور يجب أن تكون على الأقل 6 محارف',
        ];
    }

    /**
     * Handle a failed validation attempt. 
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
