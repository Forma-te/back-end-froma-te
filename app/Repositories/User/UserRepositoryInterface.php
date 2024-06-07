<?php

namespace App\Repositories\User;

use App\DTO\User\CreateUserDTO;
use App\DTO\User\UpdateUserDTO;

interface UserRepositoryInterface
{
    public function getAll(string $filter = '');
    public function findById(string $id): object|null;
    public function findByEmail(string $email);
    public function create(CreateUserDTO $dto): object;
    public function update(UpdateUserDTO $dto): object|null;
    public function delete(string $id): bool;
}
