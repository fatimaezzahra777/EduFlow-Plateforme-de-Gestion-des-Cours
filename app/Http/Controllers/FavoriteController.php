<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FavoriteService;

class FavoriteController extends Controller
{
    protected $favoriteService;

    public function __construct(FavoriteService $favoriteService)
    {
        $this->favoriteService = $favoriteService;
    }

    public function store(Request $request)
    {
        return response()->json(
            $this->favoriteService->addToFavorites($request->integer('course_id')),
            201
        );
    }

    public function destroy($courseId)
    {
        return response()->json(
            $this->favoriteService->removeFromFavorites((int) $courseId)
        );
    }

    public function index()
    {
        return response()->json(
            $this->favoriteService->getFavorites()
        );
    }
}
