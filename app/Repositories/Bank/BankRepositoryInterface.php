<?php

namespace App\Repositories\Bank;

use App\DTO\Bank\CreateBankDTO;
use App\DTO\Bank\UpdateBankDTO;
use stdClass;

interface BankRepositoryInterface
{
    public function getAll(string $filter = '');
    public function findById(string $id): object|null;
    public function findByUserId(string $email): object|null;
    public function create(CreateBankDTO $dto): stdClass;
    public function update(UpdateBankDTO $dto): object|null;
    public function delete(string $id): bool;
}
