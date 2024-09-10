<?php
namespace App\Http\Requests;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateTaskRequest extends FormRequest
{
    /**
     * Summary of authorize determinig if the user is authorized or not
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'nullable|in:low,medium,high',
            'status' => 'nullable|in:pending,in_progress,completed',
            'due_date' => 'nullable|date_format:d-m-Y H:i',
            'assigned_to' => 'nullable|exists:users,id',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'The task title is required.',
            'title.string' => 'The task title must be a string.',
            'title.max' => 'The task title may not be greater than 255 characters.',
            'description.string' => 'The description must be a string.',
            'priority.in' => 'The priority must be one of the following: low, medium, or high.',
            'status.in' => 'The status must be one of the following: pending, in progress, or completed.',
            'due_date.date_format' => 'The due date must be in the format "d-m-Y H:i".',
            'assigned_to.exists' => 'The user assigned to the task must exist in the users table.',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'Task Title',
            'description' => 'Task Description',
            'priority' => 'Task Priority',
            'status' => 'Task Status',
            'due_date' => 'Due Date',
            'assigned_to' => 'Assigned User',
        ];
    }
/**
 * Summary of failedValidation
 * @param \Illuminate\Contracts\Validation\Validator $validator
 * @throws \Illuminate\Http\Exceptions\HttpResponseException 
 * @return never just throuw httpResponseException for the messeages of the errors
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
