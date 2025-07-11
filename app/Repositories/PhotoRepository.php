<?php

namespace App\Repositories;

use App\Models\Photo;

class PhotoRepository extends BaseRepository
{
    public function __construct(Photo $model)
    {
        parent::__construct($model);
    }

    public function getAllWithAlbum()
    {
        return $this->model->with('album')->get();
    }

    public function getWithAlbum($id)
    {
        return $this->model->with('album')->find($id);
    }

    public function paginateWithAlbum($perPage = 50, $page = 1)
    {
        return $this->model->with('album')->paginate($perPage);
    }
}
