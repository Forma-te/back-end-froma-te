<?php

namespace App\Http\Controllers\Api;

use App\Adapters\ApiAdapter;
use App\DTO\Course\CreateCourseDTO;
use App\DTO\Course\UpdateCourseDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateCourseRequest;
use App\Http\Resources\CourseResource;
use App\Http\Resources\CourseStoreResource;
use App\Repositories\Course\CourseRepository;
use App\Services\CourseService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use OpenApi\Annotations as OA;

class CourseController extends Controller
{
    public function __construct(
        protected CourseRepository $repository,
        protected CourseService $courseService
    ) {

    }

    /**
      * @OA\Get(
      *     path="/api/courses",
      *     tags={"Cursos"},
      *     summary="Get all courses",
      *     description="Retrieves a list of all courses.",
      *     operationId="index",
      *
      *     @OA\Response(
      *         response=200,
      *         description="Successful operation",
      *         @OA\JsonContent(
      *             type="array",
      *             @OA\Items(ref="#/components/schemas/Course")
      *         )
      *     ),
      *     @OA\Response(
      *         response=400,
      *         description="Bad request"
      *     ),
      *     @OA\Response(
      *         response=500,
      *         description="Internal server error"
      *     )
      * )
      */

    public function index(Request $request)
    {
        $course = $this->courseService->paginate(
            page: $request->get('page', 1),
            totalPerPage: $request->get('per_page', 15),
            filter: $request->filter,
        );

        return ApiAdapter::paginateToJson($course);
    }

    private function errorResponse($message, $statusCode)
    {
        return response()->json(['error' => $message], $statusCode);
    }

    /**
    * @OA\Get(
    *     path="/api/courses/{courseId}",
    *     tags={"Cursos"},
    *     summary="Get course by ID",
    *     description="Returns details of a single course based on the provided course ID",
    *     operationId="show",
    *     @OA\Parameter(
    *         name="courseId",
    *         in="path",
    *         description="ID of course to return",
    *         required=true,
    *         @OA\Schema(
    *             type="integer",
    *             format="int64"
    *         )
    *     ),
    *      @OA\Response(
    *         response=200,
    *         description="successful operation",
    *         @OA\JsonContent(ref="#/components/schemas/Course"),
    *         @OA\XmlContent(ref="#/components/schemas/Course"),
    *     ),
    *     @OA\Response(
    *         response=400,
    *         description="Invalid ID supplier"
    *     ),
    *     @OA\Response(
    *         response=404,
    *         description="Resource not found"
    *     ),
    *     security={
    *         {"api_key": {}}
    *     }
    * )
    *
    * @param int $id
    */

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

    public function getCoursesForModuleCreation()
    {
        $courses = $this->courseService->getCoursesForModuleCreation();

        if (empty($courses)) {
            return response()->json([
                'error' => 'Resource not found'
            ], Response::HTTP_NOT_FOUND);
        }
        return response()->json($courses);
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
