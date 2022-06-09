<?php

namespace App\Http\Requests;

use App\Repositories\Task\TaskInterface;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    protected $taskRepository;

    public function __construct(TaskInterface $taskInterface)
    {
        $this->taskRepository = $taskInterface;
    }
    public function authorize()
    {
        $task = $this->taskRepository->find(request()['id']);

        if ($task->user_id == request()->user()->id) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'filled',
            'priority' => 'filled|numeric|nullable',
            'start_date' => 'filled|date',
            'end_date' => 'filled|date',
            'user_tag' => 'filled|json|nullable',
            'has_tag' => 'filled|json|nullable',
            'status' => 'filled|numeric|nullable',
            'description' => 'filled|nullable',
        ];
    }
}
