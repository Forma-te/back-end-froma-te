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
        $requests  = $this->activateUserPlanService->getAllUserRequests(
            page: $request->get('page', 1),
            totalPerPage: $request->get('per_page', 15),
            filter: $request->get('filter'),
        );

        dd($requests);
    }

    public function activatePlan(Request $request, $id)
    {
        $response  = $this->activateUserPlanService->activatePlan($request, $id);

        if ($response ['status'] === 'success') {
            return redirect()->route('')->with('success', $response ['message']);
        }

        return redirect()->route('')->with('error', $response['message']);
    }
}
