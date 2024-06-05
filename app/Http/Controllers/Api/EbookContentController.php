<?php

namespace App\Http\Controllers\Api;

use App\Adapters\ApiAdapter;
use App\DTO\EbookContent\CreateEbookContentDTO;
use App\DTO\EbookContent\UpdateEbookContentDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateEbookContentRequest;
use App\Http\Resources\EbookContentResource;
use App\Services\EbookContentService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;

class EbookContentController extends Controller
{
    public function __construct(
        protected EbookContentService $ebookContentService
    ) {
    }

    public function index(Request $request)
    {
        $ebookContent = $this->ebookContentService->paginate(
            totalPerPage: $request->get('per_page', 15),
            filter: $request->filter,
        );

        return ApiAdapter::paginateToJson($ebookContent);

    }

    private function errorResponse($message, $statusCode)
    {
        return response()->json(['error' => $message], $statusCode);
    }

    /**
     * @OA\Post(
     *     path="/api/ebook-content",
     *     operationId="createEbookContent",
     *     tags={"Ebook Contents"},
     *     summary="Create a new EbookContent",
     *     description="Creates a new EbookContent using the provided data",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreUpdateEbookContentRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="EbookContent created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/EbookContentResource")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Invalid input"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Unauthenticated"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Forbidden"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Internal server error"
     *             )
     *         )
     *     )
     * )
     */

    public function createEbookContent(StoreUpdateEbookContentRequest $request)
    {
        $module = $this->ebookContentService->new(
            CreateEbookContentDTO::makeFromRequest($request)
        );

        return new EbookContentResource($module);
    }


    /**
     * @OA\Get(
     *     path="/api/ebook/{ebookId}/ebook-content",
     *     operationId="getContentByEbookId",
     *     tags={"Ebook Contents"},
     *     summary="Get modules by EbookContent ID",
     *     description="Returns the EbookContent associated with a given course ID",
     *     @OA\Parameter(
     *         name="ebookId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         description="The ID of the ebook"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Modules retrieved successfully",
     *         @OA\JsonContent(ref="#/components/schemas/EbookContentResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Resource not found",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Resource not found"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Internal server error"
     *             )
     *         )
     *     )
     * )
     */

    public function getContentByEbookId(string $ebookId)
    {
        $contentService = $this->ebookContentService->getContentByEbookId($ebookId);

        if ($contentService instanceof Collection && $contentService->isEmpty()) {
            return response()->json([
                'error' => 'Resource not found'
            ], Response::HTTP_NOT_FOUND);
        }

        return EbookContentResource::collection($contentService);
    }

    /**
     * Updates an existing ebook content.
     *
     * @param StoreUpdateEbookContentRequest $request The request object containing the ebook content update data.
     * @param string $id The ID of the ebook content to update.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the updated ebook content data or an error message.
     *
     * @OA\Put(
     *     path="/api/ebook-content/{id}",
     *     summary="Update an ebook content",
     *     description="Update an existing ebook content by ID",
     *     operationId="updateEbookContent",
     *     tags={"Ebook Contents"},
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
     *         @OA\JsonContent(ref="#/components/schemas/StoreUpdateEbookContentRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Ebook content updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/EbookContentResource")
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
     *         description="Duplicate entry for the ebook content",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Duplicate entry for the ebook content")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="An error occurred while updating the ebook content",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="An error occurred while updating the ebook content"),
     *             @OA\Property(property="details", type="string", example="Error details here")
     *         )
     *     )
     * )
     *
     * @throws \Illuminate\Database\QueryException If there is a database query error.
     * @throws \Exception For any other type of error.
     */
    public function updateEbookContent(StoreUpdateEbookContentRequest $request, string $id)
    {
        try {
            $ebookContent = $this->ebookContentService->update(
                UpdateEbookContentDTO::makeFromRequest($request, $id)
            );

            if (!$ebookContent) {
                return response()->json([
                    'error' => 'Not Found'
                ], Response::HTTP_NOT_FOUND);
            }

            return new EbookContentResource($ebookContent);
        } catch (QueryException $exception) {
            if ($exception->errorInfo[1] == 1062) {
                // Erro de violação de chave única
                return response()->json([
                    'error' => 'Duplicate entry for the ebook content',
                ], Response::HTTP_CONFLICT);
            }

            // Outros erros de query
            return response()->json([
                'error' => 'An error occurred while updating the ebook content',
                'details' => $exception->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (\Exception $exception) {
            // Outros erros não relacionados ao banco de dados
            return response()->json([
                'error' => 'An unexpected error occurred',
                'details' => $exception->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/ebook-content/{id}",
     *     operationId="destroyEbookContent",
     *     tags={"Ebook Contents"},
     *     summary="Delete a EbookContent",
     *     description="Deletes an existing EbookContent by its ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         description="The ID of the EbookContent to be deleted"
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="EbookContent deleted successfully",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Resource not found",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Not Found"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="Internal server error"
     *             )
     *         )
     *     )
     * )
     */

    public function destroyEbookContent(string $id)
    {
        if(!$this->ebookContentService->findById($id)) {
            return response()->json([
                'error' => 'Not Found'
            ], Response::HTTP_FOUND);
        }

        $this->ebookContentService->delete($id);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

}
