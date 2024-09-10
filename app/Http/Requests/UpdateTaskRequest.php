<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class UpdateTaskRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        return [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'priority' => 'sometimes|required|in:low,medium,high',
            'status' => 'sometimes|required|in:pending,in_progress,completed',
            'due_date' => 'sometimes|nullable|date_format:d-m-Y H:i',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'The task title is required when provided.',
            'title.string' => 'The task title must be a string.',
            'title.max' => 'The task title may not be greater than 255 characters.',
            'description.string' => 'The description must be a string.',
            'priority.required' => 'The task priority is required when provided.',
            'priority.in' => 'The priority must be one of the following values: low, medium, or high.',
            'status.required' => 'The task status is required when provided.',
            'status.in' => 'The status must be one of the following values: pending, in progress, or completed.',
            'due_date.date_format' => 'The due date must be in the format "d-m-Y H:i".',
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
}
