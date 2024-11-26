<?php

namespace App\Repositories\User;

use App\DTO\User\CreateUserDTO;
use App\DTO\User\UpdateBibliographyUserDTO;
use App\DTO\User\UpdatePasswordUserDTO;
use App\DTO\User\UpdateUserDTO;
use App\Models\User;

interface UserRepositoryInterface
{
    public function getAll(string $filter = '');
    public function findById(string $id): object|null;
    public function findByEmail(string $email);
    public function create(CreateUserDTO $dto): object;
    public function update(UpdateUserDTO $dto): ?User;
    public function UpdatePasswordUser(UpdatePasswordUserDTO $dto): ?User;
    public function updateBibliographyUser(UpdateBibliographyUserDTO $dto): ?User;
    public function delete(string $id): bool;
    public function getAllProducers(string $filter = null, int $page = 1, int $totalPerPage = 10);
}
