<?php

namespace App\Http\Controllers\Api\Member;

use App\Adapters\ApiAdapter;
use App\DTO\Category\CreateCategoryDTO;
use App\DTO\Category\UpdateCategoryDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(
        protected CategoryService $categoryService
    ) {
    }


    public function index(Request $request)
    {
        $Category = $this->categoryService->paginate(
            page: $request->get('page', 1),
            totalPerPage: $request->get('per_page', 15),
            filter: $request->filter,
        );

        return ApiAdapter::paginateToJson($Category);
    }

    public function show(string $id)
    {
        if (!$Category = $this->categoryService->findOne($id)) {
            return response()->json([
                'error' => 'Not Found'
            ], Response::HTTP_NOT_FOUND);
        }
        return new CategoryResource($Category);
    }

    public function edit(string $id)
    {
        $Category = $this->categoryService->findOne($id);

        if (!$Category) {
            return response()->json(['error' => 'Resource not found'], Response::HTTP_NOT_FOUND);
        }

        return new CategoryResource($Category);
    }

    public function store(StoreUpdateCategoryRequest $request)
    {
        $Category = $this->categoryService->new(
            CreateCategoryDTO::makeFromRequest($request)
        );

        return new CategoryResource($Category);
    }

    public function update(StoreUpdateCategoryRequest $request, string $id)
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

    public function destroy(string $id)
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
