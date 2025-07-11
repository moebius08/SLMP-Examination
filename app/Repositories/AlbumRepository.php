<?php

namespace App\Repositories;

use App\Models\Album;

class AlbumRepository extends BaseRepository
{
    public function __construct(Album $model)
    {
        parent::__construct($model);
    }

    public function getAllWithUser()
    {
        return $this->model->with('user')->get();
    }

    public function getWithUserAndPhotos($id)
    {
        return $this->model->with(['user', 'photos'])->find($id);
    }
}
