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
      *     tags={"Courses"},
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
    *     tags={"Courses"},
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

    /**
     * @OA\Post(
     *     path="/api/courses",
     *     tags={"Courses"},
     *     summary="Create a new course",
     *     description="Creates a new course based on the data provided in the request.",
     *     operationId="store",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Course data",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="category_id", type="integer", example=1),
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Course Name"),
     *             @OA\Property(property="url", type="string", example="ABC123"),
     *             @OA\Property(property="description", type="string", example="Course Description"),
     *             @OA\Property(property="image", type="string", example="https://example.com/images/course.jpg"),
     *             @OA\Property(property="code", type="string", example="ABC123"),
     *             @OA\Property(property="total_hours", type="integer", example=60),
     *             @OA\Property(property="free", type="boolean", example=true),
     *             @OA\Property(property="published", type="boolean", example=true),
     *             @OA\Property(property="price", type="number", format="float", example=99.99),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Course created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="category_id", type="integer"),
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="url", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="image", type="string"),
     *             @OA\Property(property="code", type="string"),
     *             @OA\Property(property="total_hours", type="integer"),
     *             @OA\Property(property="free", type="boolean"),
     *             @OA\Property(property="published", type="boolean"),
     *             @OA\Property(property="price", type="number", format="float"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="category_id", type="array",
     *                     @OA\Items(type="string", example="The category_id field is required."),
     *                 ),
     *                  @OA\Property(property="name", type="array",
     *                     @OA\Items(type="string", example="The course name field is required."),
     *                 ),
     *
     *             ),
     *         ),
     *     ),
     * )
     */

    public function store(StoreUpdateCourseRequest $request)
    {
        // Cria um novo curso a partir dos dados do request
        $course = $this->courseService->new(
            CreateCourseDTO::makeFromRequest($request)
        );

        return new CourseStoreResource($course);
    }

    /**
     * @OA\Put(
     *     path="/api/courses/{courseId}",
     *     tags={"Courses"},
     *     summary="Update a course",
     *     description="Updates an existing course based on the data provided in the request.",
     *     operationId="update",
     *     @OA\Parameter(
     *         name="courseId",
     *         in="path",
     *         required=true,
     *         description="ID of the course to update",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Course data",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="category_id", type="integer", example=1),
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Course Name"),
     *             @OA\Property(property="url", type="string", example="ABC123"),
     *             @OA\Property(property="description", type="string", example="Course Description"),
     *             @OA\Property(property="image", type="string", example="https://example.com/images/course.jpg"),
     *             @OA\Property(property="code", type="string", example="ABC123"),
     *             @OA\Property(property="total_hours", type="integer", example=60),
     *             @OA\Property(property="free", type="boolean", example=true),
     *             @OA\Property(property="published", type="boolean", example=true),
     *             @OA\Property(property="price", type="number", format="float", example=99.99),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Course updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Updated Course Name"),
     *             @OA\Property(property="description", type="string", example="Updated Course Description"),
     *             @OA\Property(property="image", type="string", example="Updated https://example.com/images/course.jpg"),
     *             @OA\Property(property="code", type="string", example="Updated ABC123"),
     *             @OA\Property(property="total_hours", type="integer", example=60),
     *             @OA\Property(property="free", type="boolean", example=true),
     *             @OA\Property(property="published", type="boolean", example=true),
     *             @OA\Property(property="price", type="number", format="float", example=99.99),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Course not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Not Found")
     *         ),
     *     ),
     * )
     */

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

    /**
     * @OA\Delete(
     *     path="/api/courses/{courseId}",
     *     tags={"Courses"},
     *     summary="Delete a course",
     *     description="Deletes an existing course based on the provided ID.",
     *     operationId="destroy",
     *     @OA\Parameter(
     *         name="courseId",
     *         in="path",
     *         required=true,
     *         description="ID of the course to delete",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Course deleted successfully",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Course not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Not Found")
     *         ),
     *     ),
     * )
     */

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
