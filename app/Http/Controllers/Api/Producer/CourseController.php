<?php

namespace App\Http\Controllers\Api\Producer;

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
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Gate;
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
     *     summary="Get a paginated list of courses",
     *     description="Returns a paginated list of courses based on the provided query parameters.",
     *     operationId="index",
     *     tags={"Courses"},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Current page number",
     *         required=false,
     *         @OA\Schema(type="integer", default=1)
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Number of items per page",
     *         required=false,
     *         @OA\Schema(type="integer", default=15)
     *     ),
     *     @OA\Parameter(
     *         name="filter",
     *         in="query",
     *         description="Additional filter for searching courses",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Paginated list of courses",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Course")
     *             ),
     *             @OA\Property(
     *                 property="meta",
     *                 type="object",
     *                 @OA\Property(property="current_page", type="integer"),
     *                 @OA\Property(property="from", type="integer"),
     *                 @OA\Property(property="last_page", type="integer"),
     *                 @OA\Property(property="path", type="string"),
     *                 @OA\Property(property="per_page", type="integer"),
     *                 @OA\Property(property="to", type="integer"),
     *                 @OA\Property(property="total", type="integer")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid request"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
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
    *     path="/api/course/{courseId}",
    *     tags={"Courses"},
    *     summary="Get course by ID",
    *     description="Returns details of a single course based on the provided course ID",
    *     operationId="getCourseById",
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

    public function getCourseById(string $id)
    {
        $course = $this->courseService->findById($id);

        return new CourseResource($course);
    }

    /**
     * @OA\Post(
     *     path="/api/course",
     *     tags={"Courses"},
     *     summary="Create a new course",
     *     description="Creates a new course based on the data provided in the request.",
     *     operationId="createCourse",
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

    public function createCourse(StoreUpdateCourseRequest $request)
    {
        // Cria um novo curso a partir dos dados do request
        $course = $this->courseService->new(
            CreateCourseDTO::makeFromRequest($request)
        );

        return new CourseStoreResource($course);
    }

    /**
     * Updates an existing course.
     *
     * @param StoreUpdateCourseRequest $request The request object containing the course update data.
     * @param string $id The ID of the course to update.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the updated course data or an error message.
     *
     * @OA\Put(
     *     path="/api/course/{courseId}",
     *     summary="Update a course",
     *     description="Update an existing course by ID",
     *     operationId="updateCourse",
     *     tags={"Courses"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreUpdateCourseRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Course updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/CourseStoreResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Not Found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=409,
     *         description="Duplicate entry for the course URL",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Duplicate entry for the course URL")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="An error occurred while updating the course",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="An error occurred while updating the course"),
     *             @OA\Property(property="details", type="string", example="Error details here")
     *         )
     *     )
     * )
     *
     * @throws \Illuminate\Database\QueryException If there is a database query error.
     * @throws \Exception For any other type of error.
     */

    public function updateCourse(StoreUpdateCourseRequest $request, string $id)
    {
        try {
            $course = $this->courseService->update(
                UpdateCourseDTO::makeFromRequest($request, $id)
            );

            if (!$course) {
                return response()->json([
                    'error' => 'Not Found'
                ], Response::HTTP_NOT_FOUND);
            }

            return new CourseStoreResource($course);
        } catch (QueryException $exception) {
            if ($exception->errorInfo[1] == 1062) {
                // Erro de violação de chave única
                return response()->json([
                    'error' => 'Entrada duplicada para o URL do curso',
                ], Response::HTTP_CONFLICT);
            }

            // Outros erros de query
            return response()->json([
                'error' => 'Ocorreu um erro ao atualizar o curso',
                'details' => $exception->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $exception) {
            // Outros erros não relacionados ao banco de dados
            return response()->json([
                'error' => 'Ocorreu um erro ao atualizar o curso',
                'details' => $exception->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/course/{courseId}",
     *     tags={"Courses"},
     *     summary="Delete a course",
     *     description="Deletes an existing course based on the provided ID.",
     *     operationId="destroyCourse",
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

    public function destroyCourse(string $id)
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

}
