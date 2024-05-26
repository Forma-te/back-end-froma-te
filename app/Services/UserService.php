<?php

namespace App\Services;

use App\Repositories\User\UserRepositoryInterface;
use stdClass;

class UserService
{
    private $repository;

    public function __construct(UserRepositoryInterface $repository)
    {

        $this->repository = $repository;

    }

    public function getAll(string $filter = '')
    {
        return $users =  $this->repository->getAll($filter);

    }

    public function findById(string $id): object|null
    {
        return $this->repository->findById($id);
    }
    public function create(array $data): object
    {
        return $this->repository->create($data);
    }
    public function update(string $id, array $data): object|null
    {
        return $this->repository->update($id, $data);
    }
    public function delete(string $id): bool
    {
        return $this->repository->delete($id);
    }
}
