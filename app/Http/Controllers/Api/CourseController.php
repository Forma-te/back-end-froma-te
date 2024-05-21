<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Repositories\Eloquent\CourseRepository;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    protected $repository;

    public function __construct(CourseRepository $courseRepository)
    {
        $this->repository = $courseRepository;
    }

    public function getCoursesForAuthenticatedUser()
    {
        return CourseResource::collection($this->repository->getCoursesForAuthenticatedUser());
    }

    public function getCourseById($id): object
    {
        return new CourseResource($this->repository->getCourseById($id));
    }
}
