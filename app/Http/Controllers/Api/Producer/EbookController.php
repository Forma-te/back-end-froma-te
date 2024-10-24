<?php

namespace App\Http\Controllers\Api\Producer;

use App\Adapters\ApiAdapter;
use App\DTO\Course\GetCourseByUrlDTO;
use App\DTO\Ebook\CreateEbookDTO;
use App\DTO\Ebook\UpdateEbookDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateEbookRequest;
use App\Http\Resources\EbookResource;
use App\Services\EbookService;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class EbookController extends Controller
{
    public function __construct(
        protected EbookService $ebookService
    ) {
    }

    /**
     * @OA\Get(
     *     path="/api/ebooks",
     *     summary="Get a paginated list of ebooks",
     *     description="Returns a paginated list of ebooks based on the provided query parameters.",
     *     operationId="getAllEbook",
     *     tags={"Ebooks"},
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
     *         description="Additional filter for searching ebooks",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Paginated list of ebooks",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Ebook")
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

    public function getAllEbook(Request $request)
    {
        $ebook = $this->ebookService->paginate(
            page: $request->get('page', 1),
            totalPerPage: $request->get('per_page', 15),
            filter: $request->filter,
        );

        return ApiAdapter::paginateToJson($ebook);
    }

    public function fetchAllEbooksByProducers(Request $request)
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
        $ebooks = Cache::remember($cacheKey, now()->addMinutes(0), function () use ($page, $totalPerPage, $filter, $producerName, $categoryName) {
            return $this->ebookService->fetchAllEbooksByProducers(
                page: $page,
                totalPerPage: $totalPerPage,
                filter: $filter,
                producerName: $producerName,
                categoryName: $categoryName
            );
        });

        // Retornar a resposta no formato paginado usando o ApiAdapter
        return ApiAdapter::paginateToJson($ebooks);
    }


    private function errorResponse($message, $statusCode)
    {
        return response()->json(['error' => $message], $statusCode);
    }

    /**
    * @OA\Get(
    *     path="/api/ebook/{ebookId}",
    *     tags={"Ebooks"},
    *     summary="Get ebook by ID",
    *     description="Returns details of a single ebook based on the provided ebook ID",
    *     operationId="getEbookById",
    *     @OA\Parameter(
    *         name="ebookId",
    *         in="path",
    *         description="ID of ebook to return",
    *         required=true,
    *         @OA\Schema(
    *             type="integer",
    *             format="int64"
    *         )
    *     ),
    *      @OA\Response(
    *         response=200,
    *         description="successful operation",
    *         @OA\JsonContent(ref="#/components/schemas/Ebook"),
    *         @OA\XmlContent(ref="#/components/schemas/Ebook"),
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

    public function getEbookById(string $id)
    {
        $ebook = $this->ebookService->getEbookById($id);

        if (!$ebook) {
            return $this->errorResponse('Resource not found', Response::HTTP_NOT_FOUND);
        }

        return new EbookResource($ebook);
    }

    public function getEbookByUrl(string $url)
    {
        $dto = new GetCourseByUrlDTO($url);

        $course = $this->ebookService->getEbookByUrl($dto);

        if (!$course) {
            return $this->errorResponse('E-book não encontrado.', Response::HTTP_NOT_FOUND);
        }

        return new EbookResource($course);
    }

    /**
     * @OA\Post(
     *     path="/api/ebook",
     *     tags={"Ebooks"},
     *     summary="Create a new ebook",
     *     description="Creates a new ebook based on the data provided in the request.",
     *     operationId="createEbook",
     *     @OA\RequestBody(
     *         required=true,
     *         description="ebook data",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="category_id", type="integer", example=1),
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="ebook Name"),
     *             @OA\Property(property="url", type="string", example="ABC123"),
     *             @OA\Property(property="image", type="string", example="https://example.com/images/ebook.jpg"),
     *             @OA\Property(property="code", type="string", example="ABC123"),
     *             @OA\Property(property="price", type="number", format="float", example=99.99),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="ebook created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="category_id", type="integer"),
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="url", type="string"),
     *             @OA\Property(property="image", type="string"),
     *             @OA\Property(property="code", type="string"),
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

    public function createEbook(StoreUpdateEbookRequest $request)
    {
        // Cria um novo curso a partir dos dados do request
        $ebook = $this->ebookService->new(
            CreateEbookDTO::makeFromRequest($request)
        );

        return new EbookResource($ebook);
    }

    /**
     * @OA\Put(
     *     path="/api/ebook/{ebookId}",
     *     tags={"Ebooks"},
     *     summary="Update a ebook",
     *     description="Updates an existing ebook based on the data provided in the request.",
     *     operationId="updateEbook",
     *     @OA\Parameter(
     *         name="ebookId",
     *         in="path",
     *         required=true,
     *         description="ID of the ebook to update",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Ebook data",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="category_id", type="integer", example=1),
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="ebook Name"),
     *             @OA\Property(property="url", type="string", example="ABC123"),
     *             @OA\Property(property="image", type="string", example="https://example.com/images/ebook.jpg"),
     *             @OA\Property(property="code", type="string", example="ABC123"),
     *             @OA\Property(property="price", type="number", format="float", example=99.99),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="ebook updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Updated ebook Name"),
     *             @OA\Property(property="image", type="string", example="Updated https://example.com/images/ebook.jpg"),
     *             @OA\Property(property="code", type="string", example="Updated ABC123"),
     *             @OA\Property(property="price", type="number", format="float", example=99.99),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="ebook not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Not Found")
     *         ),
     *     ),
     * )
     */

    public function updateEbook(StoreUpdateEbookRequest $request, $id)
    {
        $ebook = $this->ebookService->update(
            UpdateEbookDTO::makeFromRequest($request),
            $id
        );

        if (!$ebook) {
            return response()->json([
                'error' => 'Not Found'
            ], Response::HTTP_NOT_FOUND);
        }

        return new EbookResource($ebook);
    }

    /**
     * @OA\Delete(
     *     path="/api/ebook/{ebookId}",
     *     tags={"Ebooks"},
     *     summary="Delete a ebook",
     *     description="Deletes an existing ebook based on the provided ID.",
     *     operationId="destroyEbook",
     *     @OA\Parameter(
     *         name="ebookId",
     *         in="path",
     *         required=true,
     *         description="ID of the ebook to delete",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="ebook deleted successfully",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="ebook not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Not Found")
     *         ),
     *     ),
     * )
     */

    public function destroyEbook(string $id)
    {
        if (!$this->ebookService->findById($id)) {
            return response()->json([
                'error' => 'Ebook não encontrado'
            ], Response::HTTP_NOT_FOUND);
        }

        try {
            $this->ebookService->delete($id);
        } catch (FileNotFoundException $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_NOT_FOUND);

        } catch (Exception $e) {

            return response()->json([
                'error' => 'Erro ao eliminar o ebook'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'success' => 'Ebook eliminado com sucesso'
        ], Response::HTTP_OK);

    }

}
