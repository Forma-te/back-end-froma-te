<?php

namespace App\Repositories\Plan;

use App\Events\OrderPlanInstructor;
use App\Models\Company;
use App\Models\Plan;
use App\Models\SaleInstructor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CartPlanRepository implements CartPlanRepositoryInterface
{
    public function __construct(
        protected Plan $entity,
        protected SaleInstructor $saleInstructor,
        protected
        public Company $company
    ) {
    }

    public function getAllPlans()
    {
        return $this->entity->where('published', '1')->get();
    }

    public function createSessionPlan(Request $request, string $urlPlan)
    {
        $cartPlan = $this->entity->where('url', $urlPlan)->first();
        $request->session()->put('cartPlan', $cartPlan);
        return $cartPlan;
    }

    public function checkoutPlan()
    {
        return  ['cartPlan' => session('cartPlan')];
    }

    public function planPay()
    {
        $plan = session('cartPlan');
        if (!$plan) {
            return response()->json(['error' => 'No plan in cart'], 400);
        }

        $transaction = sprintf('%08X', mt_rand(0, 0xFFFFFFF));
        $producer = User::userByAuth()->get()->first();
        $company = $this->company->firstOrNew();
        if (!$producer) {
            return response()->json(['error' => 'Producer not found'], 404);
        }

        $newSaleInstructor = $this->saleInstructor::create([
           'producer_id' => $producer->id,
           'plan_id' => $plan->id,
           'email' => $producer->email,
           'quantity' => $plan->quantity,
           'price' => $plan->price,
           'total' => $plan->price,
           'transaction' => $transaction,
           'status' => 'started',
           'date' => date('Y-m-d')
        ]);

        event(new OrderPlanInstructor($newSaleInstructor, $company, $producer));

        return $newSaleInstructor;
    }
}
