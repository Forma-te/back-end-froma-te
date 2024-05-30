<?php

namespace App\Http\Controllers\Api;

use App\Adapters\ApiAdapter;
use App\Http\Controllers\Controller;
use App\Http\Resources\ModuleResource;
use App\Repositories\Module\ModuleRepository;
use App\Services\ModuleService;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function __construct(
        protected ModuleService $moduleService
    ) {
    }

    public function index(Request $request)
    {
        $module = $this->moduleService->paginate(
            totalPerPage: $request->get('per_page', 15),
            filter: $request->filter,
        );

        return ApiAdapter::paginateToJson($module);

    }
}
