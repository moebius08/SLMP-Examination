<?php

namespace App\Repositories;

use App\Models\Comment;

class CommentRepository extends BaseRepository
{
    public function __construct(Comment $model)
    {
        parent::__construct($model);
    }

    public function getAllWithPost()
    {
        return $this->model->with('post')->get();
    }

    public function getWithPost($id)
    {
        return $this->model->with('post')->find($id);
    }
}
