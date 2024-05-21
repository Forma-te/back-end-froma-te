<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Auth;
use App\Models\Course;

class CourseRepository
{
    protected $entity;

    public function __construct(Course $model)
    {
        $this->entity = $model;
    }

    public function getAllCourse()
    {
        if (Auth::check()) {
            $loggedInUserId = Auth::id();

            return $this->entity->whereHas('users', function ($query) use ($loggedInUserId) {
                $query->where('users.id', $loggedInUserId);
            })->whereHas('sales', function ($query) {
                $query->where('sales.status', 'approved');
            })->with('modules.lessons.views')->get();
        } else {
            return [];
        }
    }

    public function getCourse(string $identify)
    {
        return $this->entity->with('modules.lessons')->findOrFail($identify);
    }
}
