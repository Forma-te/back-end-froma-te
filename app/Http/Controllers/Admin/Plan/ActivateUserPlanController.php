<?php

namespace App\Http\Controllers\Admin\Plan;

use App\Http\Controllers\Controller;
use App\Services\Admin\ActivateUserPlanService;
use Illuminate\Http\Request;

class ActivateUserPlanController extends Controller
{
    public function __construct(
        protected ActivateUserPlanService $activateUserPlanService
    ) {
    }

    public function getAllUserRequests(Request $request)
    {
        $requests = $this->activateUserPlanService->getAllUserRequests(
            page: $request->get('page', 1),
            totalPerPage: $request->get('per_page', 15),
            filter: $request->get('filter'),
        );

        return view('admin.pages.plan.plan-requests', [
            'requests' => $requests
        ]);
    }

    public function getUserRequestsById($id)
    {
        $data = $this->activateUserPlanService->getUserRequestsById($id);

        return view('admin.pages.plan.activate-user-plan', compact('data'));
    }

    public function activatePlan(Request $request, $id)
    {
        $response  = $this->activateUserPlanService->activatePlan($request, $id);

        if ($response) {
            return redirect()
                ->back()
                ->with(['success' => 'Confirmação do pagamento realizado com sucesso!']);
        } else {
            return response()
                ->back()
                ->json(['error' => 'Fail Insert', 500]);
        }
    }

    public function getActivePlans(Request $request)
    {
        $activePlans = $this->activateUserPlanService->getActivePlans(
            page: $request->get('page', 1),
            totalPerPage: $request->get('per_page', 15),
            filter: $request->get('filter'),
        );

        return view('', [
            'activePlans' => $activePlans,
            'items' => $activePlans->items()
        ]);
    }
}
