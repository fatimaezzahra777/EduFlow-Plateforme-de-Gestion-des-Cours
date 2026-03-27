<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PaymentService;

class PaymentController extends Controller
{
    protected $service;

    public function __construct(PaymentService $service)
    {
        $this->service = $service;
    }

    public function checkout(Request $request)
    {
        $session = $this->service->createSession($request->course_id);

        return response()->json([
            'url' => $session->url
        ]);
    }
}