<?php

namespace App\Http\Controllers;

use App\Models\Inscription;
use Illuminate\Http\Request;
use App\Services\InscriptionService;

class InscriptionController extends Controller
{
    protected $inscriptionService;

    public function __construct(InscriptionService $inscriptionService)
    {
        $this->inscriptionService = $inscriptionService;
    }

    public function inscri(Request $request)
    {
        return response()->json(
            $this->inscriptionService->inscri($request->integer('course_id')),
            201
        );
    }


    public function cancel($id)
    {
        return response()->json(
            $this->inscriptionService->cancel($id)
        );
    }

    public function myCourses()
    {
        return response()->json(
            $this->inscriptionService->myInscription()
        );
    }
}
