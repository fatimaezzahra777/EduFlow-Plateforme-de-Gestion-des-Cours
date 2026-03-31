<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Interest;
use App\Services\InterestService;

class InterestController extends Controller
{
    public function __construct(private InterestService $interestService)
    {
    }

    public function index()
    {
        return response()->json($this->interestService->all());
    }

    public function store(Request $request)
    {
        return response()->json(
            $this->interestService->create($request->nom),
            201
        );
    }
}
