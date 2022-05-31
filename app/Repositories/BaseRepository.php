<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

abstract class BaseRepository implements RepositoryInterface
{
    protected $model;

    public function __construct()
    {
        if ($this->model) {
            $this->setModel($this->model);
        }
    }

    public function setModel(string $modelClass): self
    {
        $this->model = app($modelClass);

        return $this;
    }

    protected function getModel()
    {
        if ($this->model instanceof Model) {
            return $this->model;
        }
        throw new ModelNotFoundException(
            'You must declare your repository $model attribute with an Illuminate\Database\Eloquent\Model '
                . 'namespace to use this feature.'
        );
    }

    public function store($attributes = [])
    {
        return $this->model->create($attributes);
    }
}
