<?php

namespace App\Http\Controllers\Api\Producer;

use App\Adapters\ApiAdapter;
use App\DTO\Course\CreateCourseDTO;
use App\DTO\Course\UpdateCourseDTO;
use App\DTO\Course\UpdatePublishedDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateCourseRequest;
use App\Http\Requests\UpdatePublishedRequest;
use App\Http\Resources\CourseResource;
use App\Http\Resources\CourseStoreResource;
use App\Repositories\Course\CourseRepository;
use App\Services\CourseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
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
            totalPerPage: $request->get('per_page', 20),
            filter: $request->filter,
        );

        return ApiAdapter::paginateToJson($course);
    }

    public function getProducts(Request $request)
    {
        $course = $this->courseService->getProducts(
            page: $request->get('page', 1),
            totalPerPage: $request->get('per_page', 20),
            filter: $request->filter,
        );

        return ApiAdapter::paginateToJson($course);
    }


    public function fetchAllCoursesByProducers(Request $request)
    {
        // Obter os parâmetros da requisição
        $page = $request->get('page', 1);
        $totalPerPage = $request->get('per_page', 20);
        $filter = $request->get('filter');
        $producerName = $request->get('producer_name');
        $categoryName = $request->get('category_name');

        // Construir a chave de cache com base nos parâmetros
        $cacheKey = "products.page_{$page}.per_page_{$totalPerPage}.filter_{$filter}.producer_{$producerName}.category_{$categoryName}";

        // Verificar se os dados estão em cache
        $courses = Cache::remember($cacheKey, now()->addMinutes(0), function () use ($page, $totalPerPage, $filter, $producerName, $categoryName) {
            return $this->courseService->fetchAllCoursesByProducers(
                page: $page,
                totalPerPage: $totalPerPage,
                filter: $filter,
                producerName: $producerName,
                categoryName: $categoryName
            );
        });

        // Retornar a resposta no formato paginado usando o ApiAdapter
        return ApiAdapter::paginateToJson($courses);
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
        $course = $this->courseService->getCourseById($id);

        if (!$course) {
            return $this->errorResponse('Resource not found', Response::HTTP_NOT_FOUND);
        }

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

    public function publishedCourse(UpdatePublishedRequest $request, int $id)
    {
        $course = $this->courseService->publishedCourse(
            UpdatePublishedDTO::makeFromRequest($request, $id)
        );

        if (!$course) {
            return response()->json([
                'error' => 'Ocorreu um erro ao publicar o curso',
            ], Response::HTTP_NOT_FOUND);
        }

        return new CourseStoreResource($course);

    }

    public function destroyCourse(string $id)
    {
        if (!$this->courseService->findById($id)) {
            return response()->json([
                'error' => 'Curso não encontrado'
            ], Response::HTTP_NOT_FOUND);
        }

        try {
            $this->courseService->delete($id);
        } catch (FileNotFoundException $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_NOT_FOUND);

        } catch (Exception $e) {

            return response()->json([
                'error' => 'Erro ao eliminar o curso'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'success' => 'Curso eliminado com sucesso'
        ], Response::HTTP_OK);

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
