<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\TodoRepository;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    protected $todoRepository;

    public function __construct(TodoRepository $todoRepository)
    {
        $this->todoRepository = $todoRepository;
    }

    public function index()
    {
        $todos = $this->todoRepository->getAllWithUser();
        return response()->json([
            'success' => true,
            'data' => $todos,
            'count' => $todos->count()
        ]);
    }

    public function paginate(Request $request)
    {
        $perPage = $request->per_page ?? 15;
        $page = $request->page ?? 1;
        $todos = $this->todoRepository->paginate($perPage, $page);

        return response()->json([
            'success' => true,
            'data' => $todos->items(),
            'pagination' => [
                'current_page' => $todos->currentPage(),
                'last_page' => $todos->lastPage(),
                'per_page' => $todos->perPage(),
                'total' => $todos->total(),
                'count' => $todos->count()
            ]
        ]);
    }

    public function show($id)
    {
        $todo = $this->todoRepository->getWithUser($id);

        if (!$todo) {
            return response()->json(['error' => 'Todo not found'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $todo
        ]);
    }
}
