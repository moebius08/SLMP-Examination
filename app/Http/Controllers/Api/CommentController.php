<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\CommentRepository;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    protected $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function index()
    {
        $comments = $this->commentRepository->getAllWithPost();
        return response()->json([
            'success' => true,
            'data' => $comments,
            'count' => $comments->count()
        ]);
    }

    public function paginate(Request $request)
    {
        $perPage = $request->per_page ?? 15;
        $page = $request->page ?? 1;
        $comments = $this->commentRepository->paginate($perPage, $page);

        return response()->json([
            'success' => true,
            'data' => $comments->items(),
            'pagination' => [
                'current_page' => $comments->currentPage(),
                'last_page' => $comments->lastPage(),
                'per_page' => $comments->perPage(),
                'total' => $comments->total(),
                'count' => $comments->count()
            ]
        ]);
    }

    public function show($id)
    {
        $comment = $this->commentRepository->getWithPost($id);

        if (!$comment) {
            return response()->json(['error' => 'Comment not found'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $comment
        ]);
    }
}
