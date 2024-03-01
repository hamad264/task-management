<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string',
            'description' => 'required|string',
            'priority' => 'integer',
            'due_date' => 'date',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Task title is required.',
            'description.required' => 'Task description is required.',
            'priority.integer' => 'Priority must be an integer.',
            'due_date.date' => 'Invalid due date format.',
        ];
    }
}
