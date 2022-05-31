<?php

namespace App\Repositories\User;

use App\Repositories\RepositoryInterface;

interface UserInterface extends RepositoryInterface
{
    public function checkEmail($email);

    public function getUser();
}
