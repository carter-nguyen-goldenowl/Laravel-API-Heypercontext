<?php

namespace App\Http\Requests;

use App\Repositories\Task\TaskInterface;
use App\Repositories\User\UserInterface;
use Illuminate\Foundation\Http\FormRequest;

class CreateTodoTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    protected $taskRepository;
    protected $userRepository;

    public function __construct(TaskInterface $taskInterface, UserInterface $userInterface)
    {
        $this->taskRepository = $taskInterface;
        $this->userRepository = $userInterface;
    }
    public function authorize()
    {
        $boolean = false;
        $task = $this->taskRepository->find(request()['task_id']);
        $json = json_decode($task->user_tag, true);
        $user = $this->userRepository->find(request()->user()->id);
        if ($task->user_id == request()->user()->id) {
            $boolean = true;
        } else {
            foreach ($json as $key => $item) {
                if ($item['value'] == $user->name) {
                    $boolean = true;
                }
            }
        }
        return $boolean;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
