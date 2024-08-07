<?php

namespace App\Repositories\Bank;

use App\DTO\Bank\CreateBankDTO;
use App\DTO\Bank\UpdateBankDTO;
use stdClass;

interface BankRepositoryInterface
{
    public function getAll(string $filter = '');
    public function findOne(string $id): stdClass|null;
    public function findBankByUserId(string $userId): object|null;
    public function create(CreateBankDTO $dto): stdClass;
    public function update(UpdateBankDTO $dto): stdClass|null;
    public function delete(string $id): void;
}
