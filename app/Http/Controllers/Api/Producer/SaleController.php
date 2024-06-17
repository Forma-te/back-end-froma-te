<?php

namespace App\Http\Controllers\Api\Producer;

use App\Adapters\ApiAdapter;
use App\DTO\Sale\CreateNewSaleDTO;
use App\DTO\Sale\UpdateNewSaleDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateSaleRequest;
use App\Http\Resources\SaleResource;
use App\Services\SaleService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class SaleController extends Controller
{
    public function __construct(
        protected SaleService $saleService
    ) {
    }

    /**
     * @OA\Get(
     *     path="/api/sales",
     *     summary="Get a paginated list of sales",
     *     description="Returns a paginated list of sales based on the provided query parameters.",
     *     operationId="getAllSales",
     *     tags={"Sales"},
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
     *         description="Additional filter for searching sales",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Paginated list of sales",
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
     *         response=400,
     *         description="Invalid request"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */

    public function getAllSales(Request $request)
    {
        $sale = $this->saleService->paginate(
            page: $request->get('page', 1),
            totalPerPage: $request->get('per_page', 15),
            filter: $request->filter,
        );

        return ApiAdapter::paginateToJson($sale);
    }

    /**
     * @OA\Get(
     *     path="/api/members",
     *     summary="Get my students",
     *     description="Returns a paginated list of students related to the authenticated user.",
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
     *         description="Additional filter for searching students",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Paginated list of students",
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
        $sales = $this->saleService->getMyStudents(
            page: $request->get('page', 1),
            totalPerPage: $request->get('per_page', 15),
            filter: $request->filter,
        );

        return ApiAdapter::paginateToJson($sales, '');
    }

    /**
     * @OA\Get(
     *     path="/api/member/expired",
     *     summary="Get my students with expired status",
     *     description="Returns a paginated list of students with expired status related to the authenticated user.",
     *     operationId="getMyMembersStatusExpired",
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
     *         description="Additional filter for searching students",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Paginated list of students with expired status",
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

    public function getMyMemberStatusExpired(Request $request)
    {
        $sales = $this->saleService->getMyStudentsStatusExpired(
            page: $request->get('page', 1),
            totalPerPage: $request->get('per_page', 15),
            filter: $request->filter,
        );

        return ApiAdapter::paginateToJson($sales);
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

    public function newSale(StoreUpdateSaleRequest $request)
    {
        $bank = $this->saleService->createNewSale(
            CreateNewSaleDTO::makeFromRequest($request)
        );

        return new SaleResource($bank);
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

        if(!$sale) {
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
        if(!$this->saleService->findById($id)) {
            return response()->json([
                'error' => 'Not Found'
            ], Response::HTTP_FOUND);
        }

        $this->saleService->delete($id);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
