<?php

namespace App\Repositories\User;

use App\DTO\User\CreateUserDTO;
use App\DTO\User\UpdateUserDTO;
use App\Models\User as Model;
use App\Repositories\User\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    private $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getAll(string $filter = '')
    {
        $users = $this->model
                    ->where(function ($query) use ($filter) {
                        if ($filter) {
                            $query->where('email', $filter);
                            $query->orWhere('name', 'LIKE', "%{$filter}%");
                        }
                    })
                    ->get();
        return $users;
    }

    public function findById(string $id): object|null
    {
        return $this->model
                    ->find($id);
    }

    public function findByEmail(string $email)
    {
        return $this->model->where('email', $email)->first();
    }

    public function findByAuth()
    {
        return $this->model->UserByAuth()->get();
    }

    public function create(CreateUserDTO $dto): object
    {
        return $this->model->create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => $dto->password
        ]);
    }

    public function update(UpdateUserDTO $dto): object|null
    {
        if (!$user = $this->findById($dto->id)) {
            return null;
        }

        $user->update($dto);

        return $user;
    }

    public function delete(string $id): bool
    {
        if (!$user = $this->findById($id)) {
            return false;
        }

        return $user->delete();
    }
}
