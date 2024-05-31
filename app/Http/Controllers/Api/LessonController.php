<?php

namespace App\Http\Controllers\Api;

use App\Adapters\ApiAdapter;
use App\DTO\Lesson\CreateLessonDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateLessonRequest;
use App\Http\Resources\LessonResource;
use App\Services\LessonService;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function __construct(
        protected LessonService $lessonService
    ) {
    }

    public function index(Request $request)
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
        $module = $this->lessonService->new(
            CreateLessonDTO::makeFromRequest($request)
        );

        return new LessonResource($module);
    }




}
