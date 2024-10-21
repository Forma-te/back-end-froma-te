<?php

namespace App\Http\Controllers\Api\Producer;

use App\Adapters\ApiAdapter;
use App\DTO\File\CreateFileDTO;
use App\DTO\File\UpdateFileDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateFileRequest;
use App\Http\Resources\EbookResource;
use App\Services\FileService;
use Symfony\Component\HttpFoundation\Response;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class FileController extends Controller
{
    public function __construct(
        protected FileService $fileService
    ) {
    }

    public function getAllFiles(Request $request)
    {
        $files = $this->fileService->paginate(
            page: $request->get('page', 1),
            totalPerPage: $request->get('per_page', 15),
            filter: $request->filter,
        );

        return ApiAdapter::paginateToJson($files);
    }

    public function fetchAllFilesByProducers(Request $request)
    {
        // Obter os parâmetros da requisição
        $page = $request->get('page', 1);
        $totalPerPage = $request->get('per_page', 15);
        $filter = $request->get('filter');
        $producerName = $request->get('producer_name');
        $categoryName = $request->get('category_name');

        // Construir a chave de cache com base nos parâmetros
        $cacheKey = "products.page_{$page}.per_page_{$totalPerPage}.filter_{$filter}.producer_{$producerName}.category_{$categoryName}";

        // Verificar se os dados estão em cache
        $files = Cache::remember($cacheKey, now()->addMinutes(0), function () use ($page, $totalPerPage, $filter, $producerName, $categoryName) {
            return $this->fileService->fetchAllFilesByProducers(
                page: $page,
                totalPerPage: $totalPerPage,
                filter: $filter,
                producerName: $producerName,
                categoryName: $categoryName
            );
        });

        // Retornar a resposta no formato paginado usando o ApiAdapter
        return ApiAdapter::paginateToJson($files);
    }

    private function errorResponse($message, $statusCode)
    {
        return response()->json(['error' => $message], $statusCode);
    }

    public function getFileById(string $id)
    {
        $ebook = $this->fileService->findById($id);

        if (!$ebook) {
            return $this->errorResponse('Resource not found', Response::HTTP_NOT_FOUND);
        }

        return new EbookResource($ebook);
    }

    public function createFile(StoreUpdateFileRequest $request)
    {
        // Cria um novo curso a partir dos dados do request
        $ebook = $this->fileService->new(
            CreateFileDTO::makeFromRequest($request)
        );

        return new EbookResource($ebook);
    }

    public function updateFile(StoreUpdateFileRequest $request, int $id)
    {
        $ebook = $this->fileService->update(
            UpdateFileDTO::makeFromRequest($request, $id)
        );

        if (!$ebook) {
            return response()->json([
                'error' => 'Not Found'
            ], Response::HTTP_NOT_FOUND);
        }

        return new EbookResource($ebook);
    }

    public function destroyFile(string $id)
    {
        if (!$this->fileService->findById($id)) {
            return response()->json([
                'error' => 'Ebook não encontrado'
            ], Response::HTTP_NOT_FOUND);
        }

        try {
            $this->fileService->delete($id);
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
