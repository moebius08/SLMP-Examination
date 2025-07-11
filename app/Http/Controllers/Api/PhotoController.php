<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\PhotoRepository;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    protected $photoRepository;

    public function __construct(PhotoRepository $photoRepository)
    {
        $this->photoRepository = $photoRepository;
    }

    public function index()
    {
        $photos = $this->photoRepository->getAllWithAlbum();
        return response()->json([
            'success' => true,
            'data' => $photos,
            'count' => $photos->count()
        ]);
    }

    public function paginate(Request $request)
    {
        $perPage = $request->per_page ?? 50; // Default to 50 per page for photos
        $page = $request->page ?? 1;
        $photos = $this->photoRepository->paginateWithAlbum($perPage, $page);

        return response()->json([
            'success' => true,
            'data' => $photos->items(),
            'pagination' => [
                'current_page' => $photos->currentPage(),
                'last_page' => $photos->lastPage(),
                'per_page' => $photos->perPage(),
                'total' => $photos->total(),
                'count' => $photos->count()
            ]
        ]);
    }

    public function show($id)
    {
        $photo = $this->photoRepository->getWithAlbum($id);

        if (!$photo) {
            return response()->json(['error' => 'Photo not found'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $photo
        ]);
    }
}
