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
        return $this->inscriptionService->inscri($request->course_id);
    }


    public function cancel($id)
    {
        return $this->inscriptionService->cancel($id);
    }

    public function myCourses()
    {
        return $this->inscriptionService->myInscription();
    }
}