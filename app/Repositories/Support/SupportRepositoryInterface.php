<?php

namespace App\Repositories\Support;

interface SupportRepositoryInterface
{
    public function getByStatus(string $status): array;
    public function findById(string $id): object|null;
}
