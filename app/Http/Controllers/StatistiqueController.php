<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CourseService;

class StatistiqueController extends Controller
{
    public function __construct(private CourseService $courseService)
    {
    }

    public function show($courseId)
    {
        return response()->json(
            $this->courseService->statisticsForTeacher($courseId)
        );
    }
}
