<?php

namespace App\Repositories\Interfaces;

interface RepositoryInterface
{
    public function all();
    public function find($id);
    public function findOrFail($id);
    public function with(array $relations);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function paginate($perPage = 15);
}
