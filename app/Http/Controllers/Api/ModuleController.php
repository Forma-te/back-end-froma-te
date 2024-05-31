<?php

namespace App\Http\Controllers\Api;

use App\Adapters\ApiAdapter;
use App\DTO\Module\CreateModuleDTO;
use App\DTO\Module\UpdateModuleDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateModuleRequest;
use App\Http\Resources\ModuleProducerResource;
use App\Http\Resources\ModuleResource;
use App\Repositories\Module\ModuleRepository;
use App\Services\ModuleService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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

    private function errorResponse($message, $statusCode)
    {
        return response()->json(['error' => $message], $statusCode);
    }

    public function getModulesByCourse(string $courseId)
    {
        $module = $this->moduleService->getModulesByCourseId($courseId);

        if(!$module) {
            return $this->errorResponse('Resource not found', Response::HTTP_NOT_FOUND);
        }

        return new ModuleProducerResource($module);
    }

    public function createModule(StoreUpdateModuleRequest $request)
    {
        $module = $this->moduleService->new(
            CreateModuleDTO::makeFromRequest($request)
        );

        return new ModuleProducerResource($module);
    }

    public function updateModule(StoreUpdateModuleRequest $request, string $id)
    {
        $module = $this->moduleService->update(
            UpdateModuleDTO::makeFromRequest($request, $id)
        );

        if(!$module) {
            return response()->json([
                'error' => 'Not Found'
            ], Response::HTTP_FOUND);
        }

        return new ModuleProducerResource($module);
    }

    public function destroy(string $id)
    {
        if(!$this->moduleService->findById($id)) {
            return response()->json([
                'error' => 'Not Found'
            ], Response::HTTP_FOUND);
        }

        $this->moduleService->delete($id);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

}
