<?php

namespace App\Http\Controllers\Api\Producer;

use App\Adapters\ApiAdapter;
use App\DTO\Category\CreateCategoryDTO;
use App\DTO\Category\UpdateCategoryDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="StoreUpdateCategoryRequest",
 *     type="object",
 *     required={"name", "description", "elegant_font"},
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Name of the category",
 *         example="Science"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Description of the category",
 *         example="Courses related to scientific subjects"
 *     ),
 *     @OA\Property(
 *         property="elegant_font",
 *         type="string",
 *         description="Elegant font associated with the category",
 *         example="Serif"
 *     )
 * )
 */

class CategoryController extends Controller
{
    public function __construct(
        protected CategoryService $categoryService
    ) {
    }

    /**
     * @OA\Get(
     *     path="/api/categories",
     *     summary="Get a paginated list of categories",
     *     description="Returns a paginated list of categories based on the provided query parameters.",
     *     operationId="getAllCategories",
     *     tags={"Categories"},
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
     *         description="Additional filter for searching categories",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Paginated list of categories",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Category")
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

    public function getAllCategories(Request $request)
    {
        $Category = $this->categoryService->paginate(
            page: $request->get('page', 1),
            totalPerPage: $request->get('per_page', 15),
            filter: $request->filter,
        );

        return ApiAdapter::paginateToJson($Category);
    }

    /**
     * @OA\Get(
     *     path="/api/categories/{categoryId}",
     *     summary="Get category by ID",
     *     description="Returns a category based on the provided ID.",
     *     operationId="getCategoryById",
     *     tags={"Categories"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the category",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Category found",
     *         @OA\JsonContent(ref="#/components/schemas/Category")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Category not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Not Found"
     *             )
     *         )
     *     )
     * )
     */


    public function getCategoryById(string $id)
    {
        if (!$Category = $this->categoryService->findOne($id)) {
            return response()->json([
                'error' => 'Not Found'
            ], Response::HTTP_NOT_FOUND);
        }
        return new CategoryResource($Category);
    }

    /**
     * @OA\Post(
     *     path="/api/categories",
     *     summary="Create a new category",
     *     description="Creates a new category based on the provided data.",
     *     operationId="storeCategory",
     *     tags={"Categories"},
     *     @OA\RequestBody(
     *         description="Category data",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreUpdateCategoryRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Category created",
     *         @OA\JsonContent(ref="#/components/schemas/Category")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Invalid input data"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */

    public function storeCategory(StoreUpdateCategoryRequest $request)
    {
        $Category = $this->categoryService->new(
            CreateCategoryDTO::makeFromRequest($request)
        );

        return new CategoryResource($Category);
    }

    /**
     * @OA\Put(
     *     path="/api/categories/{Id}",
     *     summary="Update a category",
     *     description="Updates a category based on the provided data.",
     *     operationId="updateCategory",
     *     tags={"Categories"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the category",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         description="Category data",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreUpdateCategoryRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Category updated",
     *         @OA\JsonContent(ref="#/components/schemas/Category")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Category not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Not Found"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Invalid input data"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */

    public function updateCategory(StoreUpdateCategoryRequest $request, string $id)
    {
        $Category = $this->categoryService->update(
            UpdateCategoryDTO::makeFromRequest($request, $id)
        );

        if (!$Category) {
            return response()->json([
                'error' => 'Not Found'
            ], Response::HTTP_NOT_FOUND);
        }

        return new CategoryResource($Category);
    }

    /**
     * @OA\Delete(
     *     path="/api/categories/{Id}",
     *     summary="Delete a category",
     *     description="Deletes a category based on the provided ID.",
     *     operationId="destroyCategory",
     *     tags={"Categories"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the category",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Category deleted"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Category not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Not Found"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */

    public function destroyCategory(string $id)
    {
        if (!$this->categoryService->findOne($id)) {
            return response()->json([
                'error' => 'Not Found'
            ], Response::HTTP_NOT_FOUND);
        }
        $this->categoryService->delete($id);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
