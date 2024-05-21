<?php

namespace App\Services;

use App\Repositories\CourseRepositoryInterface;

class CourseService
{
    public function __construct(
        protected CourseRepositoryInterface $repository
    ) {
    }

    public function create(array $data)
    {
        $this->repository->create($data);
    }

    public function findById(string $id)
    {
        return $this->repository->findById($id);
    }

    public function update(string $id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function delete(string $id)
    {
        return $this->repository->delete($id);
    }

    public function getCoursesForAuthenticatedUser(string $id)
    {
        return $this->repository->getCoursesForAuthenticatedUser($id);
    }

    public function getCourseById(string $id)
    {
        return $this->repository->getCourseById($id);
    }
}
