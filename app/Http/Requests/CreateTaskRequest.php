<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'priority' => 'numeric|nullable',
            'start_date' => 'required|date',
            'end_date' => "required|date",
            'user_tag' => "json|nullable",
            'has_tag' => "json|nullable",
            'status' => 'numeric|nullable',
            'description' => 'required|nullable',
        ];
    }
}
