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

    public function findOne(string $id): ?stdClass
    {
        $bank = $this->model->find($id);
        if (!$bank) {
            return null;
        }
        return (object) $bank->toArray();
    }

    public function findBankByUserId(string $userId): ?object
    {
        return $this->model->where('user_id', $userId)->get();
    }

    public function create(CreateBankDTO $dto): stdClass
    {
        $bank = $this->model->create($dto->toArray());

        return (object) $bank->toArray();
    }

    public function update(UpdateBankDTO $dto): stdClass|null
    {
        $bank = $this->model->find($dto->id);

        if ($bank) {
            $bank->update((array) $dto);
            return (object) $bank->toArray();
        }

        return null;
    }

    public function delete(string $id): void
    {
        $this->model->findOrFail($id)->delete();
    }
}
