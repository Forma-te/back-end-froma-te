<?php

namespace App\Services;

use App\DTO\Bank\CreateBankDTO;
use App\DTO\Bank\UpdateBankDTO;
use App\Repositories\Bank\BankRepositoryInterface;
use stdClass;

class BankService
{
    private $repository;

    public function __construct(BankRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAll(string $filter = '')
    {
        return $bank =  $this->repository->getAll($filter);
    }

    public function findById(string $id): object|null
    {
        return $this->repository->findById($id);
    }

    public function findByEmail($userId): ?object
    {
        return $this->findByEmail($userId);
    }

    public function create(CreateBankDTO $dto): stdClass
    {
        return $this->repository->create($dto);
    }

    public function update(UpdateBankDTO $dto): object|null
    {
        return $this->repository->update($dto);
    }

    public function delete(string $id): bool
    {
        return $this->repository->delete($id);
    }
}
