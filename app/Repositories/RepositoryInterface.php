<?php

namespace App\Repositories;

interface RepositoryInterface
{
    public function getAll();
    public function store($attributes = []);
    public function update($id, $attributes = []);
    public function find($id);
    public function delete($id);
}
