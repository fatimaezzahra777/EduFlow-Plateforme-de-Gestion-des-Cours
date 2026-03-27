<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GroupController extends Controller
{
    protected $groupService;

    public function __construct(GroupService $groupService)
    {
        $this->groupService = $groupService;
    }

    public function index($courseId)
    {
        return $this->groupService->getGroupsByCourse($courseId);
    }

    public function students($groupId)
    {
        return $this->groupService->getStudentsByGroup($groupId);
    }
}
