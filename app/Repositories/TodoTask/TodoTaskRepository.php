<?php

namespace App\Repositories\TodoTask;

use App\Models\TodoTask;
use App\Repositories\BaseRepository;

class TodoTaskRepository extends BaseRepository implements TodoTaskInterface
{
    public function __construct(TodoTask $model)
    {
        $this->model = $model;
    }
}
