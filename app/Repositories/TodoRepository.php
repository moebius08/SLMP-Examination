<?php

namespace App\Repositories;

use App\Models\Todo;

class TodoRepository extends BaseRepository
{
    public function __construct(Todo $model)
    {
        parent::__construct($model);
    }

    public function getAllWithUser()
    {
        return $this->model->with('user')->get();
    }

    public function getWithUser($id)
    {
        return $this->model->with('user')->find($id);
    }
}
