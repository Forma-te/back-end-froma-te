<?php

namespace App\Repositories\Bank;

use App\DTO\Bank\CreateBankDTO;
use App\DTO\Bank\UpdateBankDTO;
use App\Models\Bank as Model;
use stdClass;

class BankRepository implements BankRepositoryInterface
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
                      ->where('type', 'instructor')
                      ->with('CoursesTutor', 'student')
                      ->get();
        return $users;
    }

    public function findById(string $id): object|null
    {
        return $this->model
                    ->where('type', 'instructor')
                    ->with('CoursesTutor', 'student')
                    ->find($id);
    }

    public function findByUserId(string $userId): ?object
    {
        return $this->model->where('user_id', $userId)->get();
    }

    public function create(CreateBankDTO $dto): stdClass
    {
        $bank = $this->model->create($dto->toArray());

        return (object) $bank->toArray();
    }

    public function update(UpdateBankDTO $dto): object|null
    {
        if (!$bank = $this->findById($dto->id)) {
            return null;
        }

        $bank->update($dto);

        return $bank;
    }

    public function delete(string $id): bool
    {
        if (!$user = $this->findById($id)) {
            return false;
        }

        return $user->delete();
    }
}
