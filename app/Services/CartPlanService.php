<?php

namespace App\Services;

use App\Repositories\Plan\CartPlanRepositoryInterface;
use Illuminate\Http\Request;

class CartPlanService
{
    public function __construct(
        protected CartPlanRepositoryInterface $repository
    ) {
    }

    public function getAllPlans()
    {
        return $this->repository->getAllPlans();
    }

    public function createSessionPlan(Request $request, string $urlPlan)
    {
        return $this->repository->createSessionPlan($request, $urlPlan);
    }

    public function checkoutPlan()
    {
        return $this->repository->checkoutPlan();
    }
}
