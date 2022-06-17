<?php

namespace App\Repositories\Task;

use App\Models\Task;
use App\Repositories\BaseRepository;

class TaskRepository extends BaseRepository implements TaskInterface
{
    public function __construct(Task $model)
    {
        $this->model = $model;
    }

    public function getAllTask()
    {
        return $this->model->with(['user', 'todotasks'])->withCount(['todotasks', 'toDoTaskDones'])->get();
    }

    public function getTaskByName($name)
    {
        return $this->model->where('name', 'like', "%{$name}%")->with(['user', 'todotasks'])->withCount(['todotasks', 'toDoTaskDones'])->get();
    }
}
