<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Interest;

class InterestController extends Controller
{
    public function index()
    {
        return Interest::all();
    }

    public function store(Request $request)
    {
        $interest = Interest::create([
            'name' => $request->nom
        ]);

        return response()->json($interest);
    }
}