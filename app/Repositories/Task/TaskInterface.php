<?php

namespace App\Repositories\Task;

use App\Repositories\RepositoryInterface;

interface TaskInterface extends RepositoryInterface
{
    public function getAllTask();

    public function countTodo();

    public function countDone();
}
