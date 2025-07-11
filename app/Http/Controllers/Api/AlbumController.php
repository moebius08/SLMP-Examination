<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\AlbumRepository;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    protected $albumRepository;

    public function __construct(AlbumRepository $albumRepository)
    {
        $this->albumRepository = $albumRepository;
    }

    public function index()
    {
        $albums = $this->albumRepository->getAllWithUser();
        return response()->json([
            'success' => true,
            'data' => $albums,
            'count' => $albums->count()
        ]);
    }

    public function paginate(Request $request)
    {
        $perPage = $request->per_page ?? 15;
        $page = $request->page ?? 1;
        $albums = $this->albumRepository->paginate($perPage, $page);

        return response()->json([
            'success' => true,
            'data' => $albums->items(),
            'pagination' => [
                'current_page' => $albums->currentPage(),
                'last_page' => $albums->lastPage(),
                'per_page' => $albums->perPage(),
                'total' => $albums->total(),
                'count' => $albums->count()
            ]
        ]);
    }

    public function show($id)
    {
        $album = $this->albumRepository->getWithUserAndPhotos($id);

        if (!$album) {
            return response()->json(['error' => 'Album not found'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $album
        ]);
    }
}
