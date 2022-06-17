<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\BaseRepository;
use App\Repositories\User\UserInterface;

class UserRepository extends BaseRepository implements UserInterface
{
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function checkEmail($email)
    {
        return $this->model::where('email', $email)->first();
    }

    public function getMailByName($names)
    {
        return  $this->model->whereIn('name', $names)->pluck('email');
    }
}
