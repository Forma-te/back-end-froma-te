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

    public function findOne(string $id): stdClass|null
    {
        return $this->repository->findOne($id);
    }

    public function findBankByUserId($userId): ?object
    {
        return $this->findBankByUserId($userId);
    }

    public function create(CreateBankDTO $dto): stdClass
    {
        return $this->repository->create($dto);
    }

    public function update(UpdateBankDTO $dto): stdClass|null
    {
        return $this->repository->update($dto);
    }

    public function delete(string $id): void
    {
        $this->repository->delete($id);
    }
}
