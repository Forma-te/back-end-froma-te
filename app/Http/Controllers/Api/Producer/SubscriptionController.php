<?php

namespace App\Http\Controllers\Api\Producer;

use App\Adapters\ApiAdapter;
use App\Http\Controllers\Controller;
use App\Services\Admin\ActivateUserPlanService;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function __construct(
        protected ActivateUserPlanService $activateUserPlanService
    ) {
    }

    public function getSubscription(Request $request)
    {
        $data = $this->activateUserPlanService->getProducerWithApprovedStatus();

        if ($data !== null) {
            $historical = $this->activateUserPlanService->getProducerHistorical(
                totalPerPage: $request->get('per_page', 10),
            );

            return response()->json([
                'data' => $data,
                'historical' =>  ApiAdapter::paginateToJson($historical),
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Nenhum dado encontrado.',
        ], 404);
    }
}
