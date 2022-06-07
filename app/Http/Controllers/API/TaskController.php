<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Repositories\Task\TaskInterface;
use App\Repositories\TodoTask\TodoTaskInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected $taskRepository;
    protected $todoTaskRepository;
    public function __construct(TaskInterface $taskInterface, TodoTaskInterface $todoTaskInterface)
    {
        $this->taskRepository = $taskInterface;
        $this->todoTaskRepository = $todoTaskInterface;
    }
    public function createTask(CreateTaskRequest $request)
    {
        $data = $request->all();

        $task = $this->taskRepository->store($data);

        return response()->json([
            'data' => $task,
            'message' => 'Created Successfully',
        ]);
    }

    public function getAllTask()
    {
        $now = Carbon::now();

        $listTask = $this->taskRepository->getAllTask();
        $count_todo = $this->taskRepository->countTodo();
        // foreach ($listTask as &$task) {
        //     $dt = Carbon::create($task['created_at']);
        //     $task['difftime'] = $dt->diffForHumans($now);
        //     $count_todo = $this->taskRepository->countTodo();
        //     $count_done = $this->taskRepository->countDone();
        //     $task['sum_todo'] = $count_todo->todotasks_count;
        //     $task['sum_done'] = $count_done->to_do_task_dones_count;
        // }

        // collect($listTask)->map(function ($task) use ($now) {
        //     $dt = Carbon::create($task->created_at);
        //     $task->difftime = $dt->diffForHumans($now);
        //     // $count_todo = $this->taskRepository->countTodo();
        //     // $count_done = $this->taskRepository->countDone();
        //     // $task->sum_todo = $count_todo->todotasks_count;
        //     // $task->sum_done = $count_done->to_do_task_dones_count;
        // });

        // return response()->json([
        //     'data' => $count_todo
        // ]);

        return TaskResource::collection($listTask, $count_todo);
    }

    public function createTodoTask(Request $request)
    {
        $data = $request->all();
        $todoTask = $this->todoTaskRepository->store($data);
        return response()->json([
            'data' => $todoTask,
            'message' => 'Add Todo Task Successfully',
        ]);
    }
}
