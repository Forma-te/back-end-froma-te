<?php

namespace App\Repositories\Plan;

use Illuminate\Http\Request;

interface CartPlanRepositoryInterface
{
    public function getAllPlans();
    public function createSessionPlan(Request $request, string $urlPlan);
    public function checkoutPlan();
}
