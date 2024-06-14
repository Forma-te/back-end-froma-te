<?php

namespace App\Http\Controllers\Api\Producer;

use App\Adapters\ApiAdapter;
use App\DTO\Module\CreateModuleDTO;
use App\DTO\Module\UpdateModuleDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateModuleRequest;
use App\Http\Resources\ModuleProducerResource;
use App\Services\ModuleService;
use Illuminate\Database\Eloquent\Collection;
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

    /**
     * @OA\Post(
     *     path="/api/module",
     *     operationId="createModule",
     *     tags={"Modules"},
     *     summary="Create a new module",
     *     description="Creates a new module using the provided data",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreUpdateModuleRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Module created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/ModuleProducerResource")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Invalid input"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Unauthenticated"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Forbidden"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Internal server error"
     *             )
     *         )
     *     )
     * )
     */

    public function createModule(StoreUpdateModuleRequest $request)
    {
        $module = $this->moduleService->new(
            CreateModuleDTO::makeFromRequest($request)
        );

        return new ModuleProducerResource($module);
    }


    /**
     * @OA\Get(
     *     path="/api/course/{courseId}/modules",
     *     operationId="getModulesByCourse",
     *     tags={"Modules"},
     *     summary="Get modules by course ID",
     *     description="Returns the modules associated with a given course ID",
     *     @OA\Parameter(
     *         name="courseId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         description="The ID of the course"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Modules retrieved successfully",
     *         @OA\JsonContent(ref="#/components/schemas/ModuleProducerResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Resource not found",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Resource not found"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Internal server error"
     *             )
     *         )
     *     )
     * )
     */

    public function getModulesByCourse(string $courseId)
    {
        $modules = $this->moduleService->getModulesByCourseId($courseId);

        if ($modules instanceof Collection && $modules->isEmpty()) {
            return response()->json([
                'error' => 'Resource not found'
            ], Response::HTTP_NOT_FOUND);
        }

        return ModuleProducerResource::collection($modules);
    }

    /**
     * @OA\Put(
     *     path="/api/module/{id}",
     *     operationId="updateModule",
     *     tags={"Modules"},
     *     summary="Update an existing module",
     *     description="Updates the details of an existing module by its ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         description="The ID of the module to be updated"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreUpdateModuleRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Module updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/ModuleProducerResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Resource not found",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Not Found"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Internal server error"
     *             )
     *         )
     *     )
     * )
     */

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

    /**
     * @OA\Delete(
     *     path="/api/module/{id}",
     *     operationId="destroyModule",
     *     tags={"Modules"},
     *     summary="Delete a module",
     *     description="Deletes an existing module by its ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         description="The ID of the module to be deleted"
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Module deleted successfully",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Resource not found",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Not Found"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Internal server error"
     *             )
     *         )
     *     )
     * )
     */

    public function destroyModule(string $id)
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
