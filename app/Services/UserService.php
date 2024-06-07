<?php

namespace App\Services;

use App\DTO\User\CreateUserDTO;
use App\DTO\User\UpdateUserDTO;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
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
        return $this->repository->getAll($filter);

    }

    public function findById(string $id): object|null
    {
        return $this->repository->findById($id);
    }

    public function findByEmail(string $email)
    {
        return $this->repository->findByEmail($email);
    }

    public function create(CreateUserDTO $dto): object
    {
        // Criar o usuário no repositório
        $user = $this->repository->create($dto);

        // Gerar o token de autenticação
        $token = $user->createToken($dto->device_name)->plainTextToken;

        // Retornar o usuário e o token
        return (object) [
            'user' => $user,
            'token' => $token
        ];
    }

    public function update(UpdateUserDTO $dto): object|null
    {
        return $this->repository->update($dto);
    }

    public function delete(string $id): bool
    {
        return $this->repository->delete($id);
    }
}
