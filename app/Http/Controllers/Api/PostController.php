<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\PostRepository;

class PostController extends Controller
{
    protected $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function index()
    {
        $posts = $this->postRepository->getAllWithUser();
        return response()->json([
            'success' => true,
            'data' => $posts,
            'count' => $posts->count()
        ]);
    }

    public function paginate(Request $request)
    {
        $perPage = $request->per_page ?? 15;
        $page = $request->page ?? 1;
        $posts = $this->postRepository->paginate($perPage, $page);

        return response()->json([
            'success' => true,
            'data' => $posts->items(),
            'pagination' => [
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                'per_page' => $posts->perPage(),
                'total' => $posts->total(),
                'count' => $posts->count()
            ]
        ]);
    }
    public function show($id)
    {
        $post = $this->postRepository->getWithUserAndComments($id);

        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $post
        ]);
    }
}