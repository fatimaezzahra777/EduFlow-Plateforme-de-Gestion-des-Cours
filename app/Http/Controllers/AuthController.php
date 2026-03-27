<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    protected $service;

    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    public function register(Request $request)
    {
        $data = $this->service->register($request);

        return response()->json([
            'user' => new UserResource($data['user']),
            'token' => $data['token']
        ]);
    }

    public function login(Request $request)
    {
        try {
            $data = $this->service->login($request);

            return response()->json([
                'user' => new UserResource($data['user']),
                'token' => $data['token']
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function me()
    {
        return new UserResource($this->service->me());
    }

    public function logout()
    {
        return response()->json($this->service->logout());
    }
}