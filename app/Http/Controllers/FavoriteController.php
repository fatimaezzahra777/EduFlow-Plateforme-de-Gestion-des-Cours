<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    protected $favoriteService;

    public function __construct(FavoriteService $favoriteService)
    {
        $this->favoriteService = $favoriteService;
    }

    public function add(Request $request)
    {
        return $this->favoriteService->addToFavorites($request);
    }

    public function remove($courseId)
    {
        return $this->favoriteService->removeFromFavorites($courseId);
    }

    public function index()
    {
        return $this->favoriteService->getFavorites();
    }
}












