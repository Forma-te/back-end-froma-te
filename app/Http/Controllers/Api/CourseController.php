<?php

namespace App\Http\Controllers\Api;

use App\Adapters\ApiAdapter;
use App\DTO\Course\CreateCourseDTO;
use App\DTO\Course\UpdateCourseDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateCourseRequest;
use App\Http\Resources\CourseResource;
use App\Http\Resources\CourseStoreResource;
use App\Models\Category;
use App\Repositories\Eloquent\CourseRepository;
use App\Services\CourseService;
use Dotenv\Util\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CourseController extends Controller
{
    public function __construct(
        protected CourseRepository $repository,
        protected CourseService $courseService
    ) {

    }

    public function index(Request $request)
    {
        $course = $this->courseService->paginate(
            page: $request->get('page', 1),
            totalPerPage: $request->get('per_page', 15),
            filter: $request->filter,
        );

        return ApiAdapter::paginateToJson($course);
    }

    public function create()
    {
        $categories = Category::get()->pluck('name', 'id');

        return response()->json($categories, Response::HTTP_OK);
    }

    private function errorResponse($message, $statusCode)
    {
        return response()->json(['error' => $message], $statusCode);
    }

    public function show(string $id)
    {
        $course = $this->courseService->findById($id);

        if (!$course) {
            return $this->errorResponse('Resource not found', Response::HTTP_NOT_FOUND);
        }

        return new CourseStoreResource($course);
    }

    public function store(StoreUpdateCourseRequest $request)
    {
        // Cria um novo curso a partir dos dados do request
        $course = $this->courseService->new(
            CreateCourseDTO::makeFromRequest($request)
        );

        return new CourseStoreResource($course);
    }

    public function edit(string $id)
    {
        $course = $this->courseService->findById($id);
        if (!$course) {
            return $this->errorResponse('Resource not found', Response::HTTP_NOT_FOUND);
        }
        return new CourseStoreResource($course);
    }

    public function update(StoreUpdateCourseRequest $request, string $id)
    {
        $course = $this->courseService->update(
            UpdateCourseDTO::makeFromRequest($request, $id)
        );

        if (!$course) {
            return response()->json([
                'error' => 'Not Found'
            ], Response::HTTP_NOT_FOUND);
        }

        return new CourseStoreResource($course);
    }

    public function destroy(string $id)
    {
        if (!$this->courseService->findById($id)) {
            return response()->json([
                'error' => 'Not Found'
            ], Response::HTTP_NOT_FOUND);
        }

        $this->courseService->delete($id);

        return response()->json([], Response::HTTP_NO_CONTENT);

    }

    public function getCoursesForAuthenticatedUser()
    {
        return CourseResource::collection($this->repository->getCoursesForAuthenticatedUser());
    }

    public function getCourseById($id): object
    {
        return new CourseResource($this->repository->getCourseById($id));
    }
}
