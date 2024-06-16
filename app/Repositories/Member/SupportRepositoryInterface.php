<?php

namespace App\Repositories\Member;

interface SupportRepositoryInterface
{
    public function getByStatus(string $status): array;
    public function findById(string $id): object|null;
}
