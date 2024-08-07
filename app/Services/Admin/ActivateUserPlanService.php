<?php

namespace App\Services\Admin;

use App\Repositories\PaginationInterface;
use App\Repositories\Plan\ActivateUserPlanRepository;
use Illuminate\Http\Request;

class ActivateUserPlanService
{
    public function __construct(
        protected ActivateUserPlanRepository $repository
    ) {
    }

    public function getAllUserRequests(
        int $page = 1,
        int $totalPerPage  = 15,
        string $filter = null
    ): PaginationInterface {
        return $this->repository->getAllUserRequests(
            page: $page,
            totalPerPage: $totalPerPage,
            filter: $filter,
        );
    }

    public function getUserRequestsById($id)
    {
        return $this->repository->getUserRequestsById($id);
    }

    public function activatePlan(Request $request, $id): array
    {
        try {
            $this->repository->activatePlan($request, $id);

            return ['status' => 'success', 'message' => 'Plano ativado com sucesso'];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => 'Failed to activate plan: ' . $e->getMessage()];
        }
    }

    public function getActivePlans(
        int $page = 1,
        int $totalPerPage  = 15,
        string $filter = null
    ): PaginationInterface {
        return $this->repository->getActivePlans(
            page: $page,
            totalPerPage: $totalPerPage,
            filter: $filter,
        );
    }

}
