<?php

namespace App\Repositories\Eloquent;

use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Repositories\CourseRepositoryInterface;

class CourseRepository implements CourseRepositoryInterface
{
    protected $entity;

    public function __construct(Course $model)
    {
        $this->entity = $model;
    }


    public function getAll(string $filter = ''): array
    {
        if (!empty($filter)) {
            return $this->entity->where('name', 'like', "%{$filter}%")->get()->toArray();
        }
        return $this->entity->all()->toArray();
    }

    public function findById(string $id): object|null
    {
        return $this->entity->find($id);
    }

    public function create(array $data): object
    {
        return $this->entity->create($data);
    }

    public function update(string $id, array $data): object|null
    {
        $course = $this->entity->find($id);
        if ($course) {
            $course->update($data);
            return $course;
        }
        return null;
    }

    public function delete(string $id): bool
    {
        $course = $this->entity->find($id);
        if ($course) {
            return $course->delete();
        }
        return false;

    }

    public function getCoursesForAuthenticatedUser(): array
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

    public function getCourseById(string $id): object|null
    {
        return $this->entity->with('modules.lessons')->findOrFail($id);
    }
}
