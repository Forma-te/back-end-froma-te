<?php

namespace App\Http\Controllers\Api\Producer;

use App\Adapters\ApiAdapter;
use App\DTO\Lesson\CreateFileLessonDTO;
use App\DTO\Lesson\CreateLessonDTO;
use App\DTO\Lesson\CreateNameLessonDTO;
use App\DTO\Lesson\UpdateEditNameLessonDTO;
use App\DTO\Lesson\UpdateFileLessonDTO;
use App\DTO\Lesson\UpdateLessonDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateEditNameLessonRequest;
use App\Http\Requests\StoreUpdateFileLessonRequest;
use App\Http\Requests\StoreUpdateLessonRequest;
use App\Http\Requests\StoreView;
use App\Http\Resources\LessonFileResource;
use App\Http\Resources\LessonProducerResource;
use App\Services\LessonService;
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

    public function createLesson(StoreUpdateLessonRequest $request)
    {
        $lesson = $this->lessonService->new(
            CreateLessonDTO::makeFromRequest($request)
        );

        return new LessonProducerResource($lesson);
    }


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


    public function updateLesson(StoreUpdateLessonRequest $request, string $id)
    {
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

    public function createFileLesson(StoreUpdateFileLessonRequest $request)
    {

        $lessonFile = $this->lessonService->createFileLesson(
            CreateFileLessonDTO::makeFromRequest($request)
        );

        return new LessonFileResource($lessonFile);
    }

    public function updateFileLesson(StoreUpdateFileLessonRequest $request, string $id)
    {
        $lessonFile = $this->lessonService->updateFileLesson(
            UpdateFileLessonDTO::makeFromRequest($request, $id)
        );

        if (!$lessonFile) {
            return response()->json([
                'error' => 'Not Found'
            ], Response::HTTP_NOT_FOUND);
        }

        return new LessonFileResource($lessonFile);
    }

    public function viewed(StoreView $request)
    {
        $this->lessonService->markLessonViewed($request->lessonId);

        return response()->json(['success' => true]);
    }

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
