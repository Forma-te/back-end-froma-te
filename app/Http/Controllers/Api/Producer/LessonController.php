<?php

namespace App\Http\Controllers\Api\Producer;

use App\Adapters\ApiAdapter;
use App\DTO\Lesson\CreateLessonDTO;
use App\DTO\Lesson\CreateNameLessonDTO;
use App\DTO\Lesson\UpdateEditNameLessonDTO;
use App\DTO\Lesson\UpdateLessonDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateEditNameLessonRequest;
use App\Http\Requests\StoreUpdateLessonRequest;
use App\Http\Resources\LessonProducerResource;
use App\Services\LessonService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LessonController extends Controller
{
    public function __construct(
        protected LessonService $lessonService
    ) {
    }

    public function getAllLesson(Request $request)
    {
        $module = $this->lessonService->paginate(
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
     *     path="/api/lesson",
     *     summary="Create a new lesson",
     *     description="Creates a new lesson based on the provided request data.",
     *     operationId="createLesson",
     *     tags={"Lessons"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreUpdateLessonRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Lesson created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/LessonProducerResource")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid request data"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */

    public function createLesson(StoreUpdateLessonRequest $request)
    {
        $lesson = $this->lessonService->new(
            CreateLessonDTO::makeFromRequest($request)
        );

        return new LessonProducerResource($lesson);
    }

    /**
     * @OA\Get(
     *     path="/api/module/{moduleId}/lessons",
     *     summary="Get lessons by module ID",
     *     description="Retrieves all lessons associated with a given module ID.",
     *     operationId="getLessonByModuleId",
     *     tags={"Lessons"},
     *     @OA\Parameter(
     *         name="moduleId",
     *         in="path",
     *         required=true,
     *         description="ID of the module",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/LessonProducerResource")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Resource not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Resource not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */

    public function getLessonByModuleId(string $moduleId)
    {
        $lessons = $this->lessonService->getLessonByModuleId($moduleId);

        if (is_null($lessons) || $lessons->isEmpty()) {
            return response()->json([
                'error' => 'Resource not found'
            ], Response::HTTP_NOT_FOUND);
        }

        return LessonProducerResource::collection($lessons);
    }

    /**
     * @OA\Put(
     *     path="/api/lesson/{id}",
     *     summary="Update a lesson",
     *     description="Updates an existing lesson based on the provided request data.",
     *     operationId="updateLesson",
     *     tags={"Lessons"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the lesson to update",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreUpdateLessonRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lesson updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/LessonProducerResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Not Found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */

    public function updateLesson(StoreUpdateLessonRequest $request, string $id)
    {
        $validated = $request->validated();
        logger()->info('Dados validados na API:', $validated);

        $lesson = $this->lessonService->update(
            UpdateLessonDTO::makeFromRequest($request, $id)
        );

        if (!$lesson) {
            return response()->json([
                'error' => 'Not Found'
            ], Response::HTTP_NOT_FOUND);
        }

        return new LessonProducerResource($lesson);
    }

    public function editNameLesson(StoreUpdateEditNameLessonRequest $request, string $id)
    {
        $lesson = $this->lessonService->editNameLesson(
            UpdateEditNameLessonDTO::makeFromRequest($request, $id)
        );

        if (!$lesson) {
            return response()->json([
                'error' => 'Not Found'
            ], Response::HTTP_NOT_FOUND);
        }

        return new LessonProducerResource($lesson);
    }

    public function createNameLesson(StoreUpdateEditNameLessonRequest $request)
    {
        $lesson = $this->lessonService->createNameLesson(
            CreateNameLessonDTO::makeFromRequest($request)
        );

        return new LessonProducerResource($lesson);
    }

    /**
     * @OA\Delete(
     *     path="/api/lesson/{id}",
     *     summary="Delete a lesson",
     *     description="Deletes an existing lesson based on the provided ID.",
     *     operationId="deleteLesson",
     *     tags={"Lessons"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the lesson to delete",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Lesson deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Not Found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */

    public function destroyLesson(string $id)
    {
        if (!$this->lessonService->findById($id)) {
            return response()->json([
                'error' => 'Not Found'
            ], Response::HTTP_NOT_FOUND);
        }

        $this->lessonService->delete($id);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }


}
