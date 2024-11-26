<?php

namespace App\Http\Controllers\Api\Producer;

use App\Adapters\ApiAdapter;
use App\Adapters\SaleAdapters;
use App\DTO\Sale\ImportCsvDTO;
use App\DTO\Sale\UpdateNewSaleDTO;
use App\Enum\ProductTypeEnum;
use App\Enum\SaleEnum;
use App\Enum\SalesChannelEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\CsvImportRequest;
use App\Http\Requests\StoreUpdateSaleRequest;
use App\Http\Resources\SaleResource;
use App\Services\SaleService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use League\Csv\Reader;

class SaleController extends Controller
{
    public function __construct(
        protected SaleService $saleService
    ) {
    }

    /**
     * @OA\Get(
     *     path="/api/members-status",
     *     summary="Get all members",
     *     description="Fetches a list of all members with the given status and pagination details.",
     *     operationId="getMembersByStatus",
     *     tags={"My Members"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         required=false,
     *         description="Status of the members to filter",
     *         @OA\Schema(
     *             type="string",
     *             default="",
     *             enum={"Iniciado, Aguardar Validação", "Aprovado", "Expirado", "Pendente"}
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         required=false,
     *         description="Page number for pagination",
     *         @OA\Schema(
     *             type="integer",
     *             default=1
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         required=false,
     *         description="Number of items per page",
     *         @OA\Schema(
     *             type="integer",
     *             default=15
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfully retrieved the list of members",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(
     *                     property="items",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="course_id", type="integer", example=1),
     *                         @OA\Property(property="user_id", type="integer", example=2),
     *                         @OA\Property(property="instrutor_id", type="integer", example=1),
     *                         @OA\Property(property="transaction", type="string", example="234B21C"),
     *                         @OA\Property(property="email_student", type="string", example="example@gmail.com"),
     *                         @OA\Property(property="payment_mode", type="string", example="banco"),
     *                         @OA\Property(property="blocked", type="integer", example=0),
     *                         @OA\Property(property="status", type="string", example="Aprovado"),
     *                         @OA\Property(property="date_created", type="string", format="date", example="2024-06-15"),
     *                         @OA\Property(property="date_expired", type="string", example="16/05/2024"),
     *                         @OA\Property(property="student", type="object", ref="#/components/schemas/Sale"),
     *                         @OA\Property(property="instrutor", type="object", ref="#/components/schemas/User"),
     *                         @OA\Property(property="course", type="object", ref="#/components/schemas/Course")
     *                     )
     *                 ),
     *                 @OA\Property(
     *                     property="meta",
     *                     type="object",
     *                     @OA\Property(property="total", type="integer", example=100),
     *                     @OA\Property(property="is_first_page", type="boolean", example=true),
     *                     @OA\Property(property="is_last_page", type="boolean", example=false),
     *                     @OA\Property(property="current_page", type="integer", example=1),
     *                     @OA\Property(property="next_page", type="integer", example=2),
     *                     @OA\Property(property="previous_page", type="integer", example=null)
     *                 ),
     *                 @OA\Property(
     *                     property="status_options",
     *                     type="array",
     *                     @OA\Items(type="string", example="Aprovado")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to retrieve the members",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="success",
     *                 type="boolean",
     *                 example=false
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Failed to retrieve sales: Database connection error"
     *             )
     *         )
     *     )
     * )
     */

    // public function getMembersByStatus(Request $request)
    // {
    //     try {

    //         $sales = $this->saleService->getMembersByStatus(
    //             page: $request->get('page', 1),
    //             totalPerPage: $request->get('per_page', 10),
    //             status: (string) $request->get('status', ''),
    //             filter: $request->get('filter', '')
    //         );

    //         $statusOptions = array_map(fn ($enum) => $enum->value, SaleEnum::cases());

    //         return response()->json(
    //             SaleAdapters::paginateToJson($sales, $statusOptions),
    //             Response::HTTP_OK
    //         );
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Failed to retrieve sales:' . $e->getMessage(),
    //         ], Response::HTTP_INTERNAL_SERVER_ERROR);
    //     }
    // }

    /**
     * @OA\Get(
     *     path="/api/members",
     *     summary="Get my members",
     *     description="Returns a paginated list of members related to the authenticated user.",
     *     operationId="getMyMembers",
     *     tags={"My Members"},
     *     security={{"bearerAuth":{}}},
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
     *         description="Additional filter for searching members",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Paginated list of members",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Sale")
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
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */

    public function getMyMembers(Request $request)
    {
        try {

            $defaultPerPage = 10; // Número de registos por página padrão
            $maxPerPage = 100;    // Limite máximo permitido

            // Obter o valor do parâmetro per_page da requisição
            $totalPerPage = (int) $request->get('per_page', $defaultPerPage);

            // Validar o valor recebido
            if ($totalPerPage <= 0 || $totalPerPage > $maxPerPage) {
                $totalPerPage = $defaultPerPage;
            }


            $sales = $this->saleService->getMyStudents(
                page: $request->get('page', 1),
                totalPerPage: $totalPerPage,
                status: (string) $request->get('status', ''),
                channel: (string) $request->get('channel', ''),
                type: (string) $request->get('type', ''),
                startDate : (string) $request->get('startDate', ''),
                endDate : (string) $request->get('endDate ', ''),
                filter: $request->get('filter', '')
            );

            $statusOptions = array_map(fn ($enum) => $enum->value, SaleEnum::cases());

            $channelOptions = array_map(fn ($enum) => $enum->value, SalesChannelEnum::cases());

            $productTypeEnum = array_map(fn ($enum) => $enum->value, ProductTypeEnum::cases());

            return response()->json(
                SaleAdapters::paginateToJson($sales, $statusOptions, $channelOptions, $productTypeEnum),
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve sales:' . $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    private function errorResponse($message, $statusCode)
    {
        return response()->json(['error' => $message], $statusCode);
    }

    /**
     * @OA\Get(
     *     path="/api/sales/{id}",
     *     summary="Get sale by ID",
     *     description="Returns the sale details by its ID.",
     *     operationId="getSaleById",
     *     tags={"Sales"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the sale",
     *         required=true,
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sale details",
     *         @OA\JsonContent(ref="#/components/schemas/Sale")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Resource not found"
     *     )
     * )
     */

    public function getSaleById(string $id)
    {
        $sale = $this->saleService->findById($id);
        if (Gate::denies('owner-sale', $sale)) {
            return response()->json([
                'error' => 'Forbidden'
            ], Response::HTTP_FORBIDDEN);
        }

        if (!$sale) {
            return $this->errorResponse('Resource not found', Response::HTTP_NOT_FOUND);
        }

        return new SaleResource($sale);
    }

    /**
     * @OA\Post(
     *     path="/api/sales",
     *     summary="Create a new sale",
     *     description="Create a new sale record.",
     *     operationId="newSale",
     *     tags={"Sales"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Sale data",
     *         @OA\JsonContent(ref="#/components/schemas/StoreUpdateSaleRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Sale created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/Sale"
     *             )
     *         )
     *     ),
     *      @OA\Response(
     *         response=400,
     *         description="Bad request. The request body is invalid or missing required fields."
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized. Authentication credentials are missing or invalid."
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error. The request body failed validation rules."
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error. An unexpected error occurred on the server."
     *     )
     * )
     */

    // public function newSale(StoreUpdateSaleRequest $request)
    // {
    //     $sale = $this->saleService->createNewSale(
    //         CreateNewSaleDTO::makeFromRequest($request)
    //     );

    //     return new SaleResource($sale);
    // }

    public function csvImportMember(CsvImportRequest $request)
    {
        // Definir os campos que serão mapeados
        $dataFile = ['course_id', 'name', 'email_student', 'date_expired', 'product_type'];

        // Obter o arquivo CSV do request
        $file = $request->file('file');
        $csv = Reader::createFromPath($file->getPathname(), 'r');
        $csv->setDelimiter(';');
        $csv->setHeaderOffset(0);

        $mappedValues = [];

        foreach ($csv->getRecords() as $record) {
            // Mapear os valores do CSV para os campos correspondentes
            $values = array_combine($dataFile, $record);

            if ($values === false) {
                return response()->json(['error' => 'Erro ao mapear valores do CSV. Verifique o arquivo e tente novamente.'], 400);
            }

            // Adicionar os valores validados ao array de mapeamento
            $mappedValues[] = $values;
        }

        $sales = [];
        foreach ($mappedValues as $values) {
            // Criar o DTO a partir dos valores validados
            $dto = ImportCsvDTO::makeFromArray($values);

            // Processar a criação da nova venda
            $sales[] = $this->saleService->csvImportMember($dto);
        }

        return response()->json([
            'message' => 'Vendas importadas com sucesso!',
            'sales' => SaleResource::collection($sales)
        ]);
    }

    /**
     * @OA\Patch(
     *     path="/api/sales/{id}",
     *     summary="Update a sale",
     *     description="Update an existing sale record.",
     *     operationId="updateSale",
     *     tags={"Sales"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the sale to be updated",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Updated sale data",
     *         @OA\JsonContent(ref="#/components/schemas/StoreUpdateSaleRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sale updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/Sale"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request. The request body is invalid or missing required fields."
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized. Authentication credentials are missing or invalid."
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found. The specified sale was not found."
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error. An unexpected error occurred on the server."
     *     )
     * )
     */

    public function updateSale(StoreUpdateSaleRequest $request, string $id)
    {
        $sale = $this->saleService->updateSale(
            UpdateNewSaleDTO::makeFromRequest($request, $id)
        );

        if (!$sale) {
            return response()->json([
                'error' => 'Not Found'
            ], Response::HTTP_FOUND);
        }

        return new SaleResource($sale);
    }

    /**
     * @OA\Delete(
     *     path="/api/sales/{id}",
     *     summary="Delete a sale",
     *     description="Delete an existing sale record.",
     *     operationId="destroySale",
     *     tags={"Sales"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the sale to be deleted",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Sale deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found. The specified sale was not found."
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error. An unexpected error occurred on the server."
     *     )
     * )
     */

    public function destroySele(string $id)
    {
        if (!$this->saleService->findById($id)) {
            return response()->json([
                'error' => 'Not Found'
            ], Response::HTTP_FOUND);
        }

        $this->saleService->delete($id);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
