<?php

namespace App\Repositories;

use App\Models\Post;

class PostRepository extends BaseRepository
{
    public function __construct(Post $model)
    {
        parent::__construct($model);
    }

    public function getAllWithUser()
    {
        return $this->model->with('user')->get();
    }

    public function getWithUserAndComments($id)
    {
        return $this->model->with(['user', 'comments'])->find($id);
    }
}
