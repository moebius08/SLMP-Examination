<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function getAllWithRelations()
    {
        return $this->model->with(['posts', 'albums', 'todos'])->get();
    }

    public function getWithRelations($id)
    {
        return $this->model->with(['posts', 'albums', 'todos'])->find($id);
    }
}
