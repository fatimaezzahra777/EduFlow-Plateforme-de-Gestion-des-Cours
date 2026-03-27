<?php

namespace App\Services;

use App\Models\Course;

class CourseService
{
    public function getAll()
    {
        return Course::with('teacher')->get();
    }

    public function find($id)
    {
        return Course::with('teacher')->findOrFail($id);
    }

    public function create($request)
    {
        return Course::create([
            'titre' => $request->titre,
            'description' => $request->description,
            'prix' => $request->prix,
            'teacher_id' => auth()->id()
        ]);
    }

    public function update($request, $id)
    {
        $course = Course::findOrFail($id);
        $course->update($request->all());

        return $course;
    }

    public function delete($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return ['message' => 'Course deleted successfully'];
    }
}