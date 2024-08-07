<?php

namespace App\Repositories\Admin\Plan;

use App\DTO\Admin\Plan\CreatePlanDTO;
use App\DTO\Admin\Plan\UpdatePlanDTO;
use App\Repositories\PaginationInterface;
use Illuminate\Http\Request;

interface PlanRepositoryInterface
{
    public function paginate(int $page = 1, int $totalPerPage  = 15, string $filter = null): PaginationInterface;
    public function store(CreatePlanDTO $dto);
    public function show(string $url);
    public function edit(string $url);
    public function update(UpdatePlanDTO $dto);
    public function delete(string $url);
}
