<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Exceptions\HttpResponseException;


class StoreUserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ];
    }
    public function messages(){
        return [
            'name.required'=> 'the name is required to make a user',
            'email.required'=> 'the email is required to make a user',
            'password.required'=> 'the password is required to make a user',
            'name.string'=>'the name is required to be string',
            'email.email'=>'the email has to be an email type',
            'password.min'=>'the password has to be at minumin 6 characters long'
        ] ;
    }
    public function attributes(){
        return [
        'name'=> 'اسم المستخدم',
        'email'=> 'عنوان البريد الالكتروني',
        'password'=> 'كلمة المرور'
        ];
    }

protected function failedValidation(Validator $validator)
{
    throw new HttpResponseException(
        response()->json([
            'status' => 'failed validation',
            'errors' => $validator->errors(),
        ], 422)
    );
}
//     public function passedValidation(){
//         'password' => Hash::make($request['password'])
// }
}
