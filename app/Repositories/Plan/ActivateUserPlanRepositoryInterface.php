<?php

namespace App\Repositories\Plan;

use App\Repositories\PaginationInterface;
use Illuminate\Http\Request;

interface ActivateUserPlanRepositoryInterface
{
    public function getAllUserRequests(int $page = 1, int $totalPerPage = 15, string $filter = null): PaginationInterface;
    public function activatePlan(Request $request, $id);
    public function getUserRequestsById($id);
    public function getActivePlans(int $page = 1, int $totalPerPage = 15, string $filter = null): PaginationInterface;
}
