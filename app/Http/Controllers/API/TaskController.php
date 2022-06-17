<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\CreateTodoTaskRequest;
use App\Http\Requests\DeleteTaskRequest;
use App\Http\Requests\DeleteTodoTaskRequest;
use App\Http\Requests\SetCompleteTodoTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Jobs\SendEmailForTask;
use App\Repositories\Task\TaskInterface;
use App\Repositories\TodoTask\TodoTaskInterface;
use App\Repositories\User\UserInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;

class TaskController extends Controller
{
    protected $taskRepository;
    protected $todoTaskRepository;
    protected $userRepository;
    public function __construct(TaskInterface $taskInterface, TodoTaskInterface $todoTaskInterface, UserInterface $userInterface)
    {
        $this->taskRepository = $taskInterface;
        $this->todoTaskRepository = $todoTaskInterface;
        $this->userRepository = $userInterface;
    }

    public function getAllTask()
    {
        $now = Carbon::now();
        $listTask = $this->taskRepository->getAllTask();
        collect($listTask)->map(function ($task) use ($now) {
            $dt = Carbon::create($task->updated_at);
            $task->difftime = $dt->diffForHumans($now);
        });

        return TaskResource::collection($listTask);
    }

    public function createTask(CreateTaskRequest $request)
    {
        $data = $request->all();

        $task = $this->taskRepository->store($data);

        $arr = json_decode($task->user_tag, true);
        $names = [];
        foreach ($arr as $key => $value) {
            array_push($names, $value['value']);
        }

        $emails = $this->userRepository->getMailByName($names);

        SendEmailForTask::dispatch($emails);

        Redis::flushDB();

        return response()->json([
            'data' => $task,
            'message' => 'Created Successfully',
        ]);
    }

    public function updateTask(UpdateTaskRequest $request, $id)
    {
        $data = $request->all();

        $this->taskRepository->update($id, $data);

        $task = $this->taskRepository->find($id);

        return response()->json([
            'data' => $task,
            'message' => 'Updated Successfully'
        ]);
    }

    public function deleteTask(DeleteTaskRequest $request, $id)
    {
        return response()->json([
            'data' => $this->taskRepository->delete($id),
            'message' => 'Deleted Successfully',
        ]);
    }

    public function createTodoTask(CreateTodoTaskRequest $request)
    {
        $data = $request->all();
        $todoTask = $this->todoTaskRepository->store($data);
        $task = $this->taskRepository->find($todoTask->task_id);
        $task->status = 200;
        $task->save();
        return response()->json([
            'data' => $todoTask,
            'message' => 'Add Todo Task Successfully',
        ]);
    }

    public function deleteTodoTask(DeleteTodoTaskRequest $request, $id)
    {
        return response()->json([
            'data' => $this->todoTaskRepository->delete($id),
        ]);
    }

    public function setCompleteTodoTask(SetCompleteTodoTaskRequest $request, $id)
    {
        $todoTask = $this->todoTaskRepository->find($id);
        $todoTask->status = 1;
        $todoTask->save();

        return response()->json([
            'data' => $todoTask,
        ]);
    }

    public function searchTaskByName($name)
    {
        if (Redis::get($name)) {
            $arr_listTask = json_decode(Redis::get($name), true);
            $collection_listTask = collect($arr_listTask);
            return TaskResource::collection($collection_listTask);
        } else {
            $now = Carbon::now();
            $listTask = $this->taskRepository->getTaskByName($name);
            collect($listTask)->map(function ($task) use ($now) {
                $dt = Carbon::create($task->updated_at);
                $task->difftime = $dt->diffForHumans($now);
            });
            Redis::set($name, $listTask);
            return TaskResource::collection($listTask);
        }
    }
}
