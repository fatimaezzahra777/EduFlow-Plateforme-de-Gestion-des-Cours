<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CourseService;
use App\Http\Resources\CourseResource;

class CourseController extends Controller
{
    protected $service;

    public function __construct(CourseService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return CourseResource::collection(
            $this->service->getAll()
        );
    }

    public function show($id)
    {
        return new CourseResource(
            $this->service->find($id)
        );
    }

    public function store(Request $request)
    {
        $course = $this->service->create($request);

        return new CourseResource($course);
    }

    public function update(Request $request, $id)
    {
        $course = $this->service->update($request, $id);

        return new CourseResource($course);
    }

    public function destroy($id)
    {
        return response()->json(
            $this->service->delete($id)
        );
    }
}