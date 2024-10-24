<?php

namespace App\Http\Controllers\Api\Producer;

use App\DTO\ProductFile\CreateDocFileDTO;
use App\DTO\ProductFile\CreateFileCourseDTO;
use App\DTO\ProductFile\CreateFileEbookDTO;
use App\DTO\ProductFile\CreateImageEbookDTO;
use App\DTO\ProductFile\CreateImageFileDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateProductCourseImageRequest;
use App\Http\Requests\StoreUpdateProductDocFileRequest;
use App\Http\Requests\StoreUpdateProductFileRequest;
use App\Http\Resources\FileCourseResource;
use App\Http\Resources\ProductFileResource;
use App\Services\ProductFileService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductFileController extends Controller
{
    public function __construct(
        protected ProductFileService $productFileService
    ) {
    }

    public function store(StoreUpdateProductCourseImageRequest $request)
    {
        $productFile = $this->productFileService->createFileCourse(
            CreateFileCourseDTO::makeFromRequest($request)
        );

        // Verifica se o ficheiro foi criado com sucesso
        if (!$productFile) {
            return response()->json([
                'error' => 'O ficheiro não pôde ser criado.'
            ], Response::HTTP_NOT_FOUND);
        }

        // Retorna a resposta com o recurso criado
        return response()->json(new FileCourseResource($productFile), Response::HTTP_CREATED);
    }

    public function createImageEbook(StoreUpdateProductFileRequest $request)
    {
        $productImage = $this->productFileService->createImageEbook(
            CreateImageEbookDTO::makeFromRequest($request)
        );

        // Verifica se o ficheiro foi criado com sucesso
        if (!$productImage) {
            return response()->json([
                'error' => 'O ficheiro não pôde ser criado.'
            ], Response::HTTP_NOT_FOUND);
        }

        // Retorna a resposta com o recurso criado
        return response()->json(new ProductFileResource($productImage), Response::HTTP_CREATED);
    }

    public function createFileEbook(StoreUpdateProductFileRequest $request)
    {
        $productFile = $this->productFileService->createFileEbook(
            CreateFileEbookDTO::makeFromRequest($request)
        );

        // Verifica se o ficheiro foi criado com sucesso
        if (!$productFile) {
            return response()->json([
                'error' => 'O ficheiro não pôde ser criado.'
            ], Response::HTTP_NOT_FOUND);
        }

        // Retorna a resposta com o recurso criado
        return response()->json(new ProductFileResource($productFile), Response::HTTP_CREATED);
    }

    public function createImageFile(StoreUpdateProductFileRequest $request)
    {
        $productImage = $this->productFileService->createImageFile(
            CreateImageFileDTO::makeFromRequest($request)
        );

        // Verifica se o ficheiro foi criado com sucesso
        if (!$productImage) {
            return response()->json([
                'error' => 'O ficheiro não pôde ser criado.'
            ], Response::HTTP_NOT_FOUND);
        }

        // Retorna a resposta com o recurso criado
        return response()->json(new ProductFileResource($productImage), Response::HTTP_CREATED);
    }


    public function createDocFile(StoreUpdateProductDocFileRequest $request)
    {
        $productFile = $this->productFileService->createDocFile(
            CreateDocFileDTO::makeFromRequest($request)
        );

        // Verifica se o ficheiro foi criado com sucesso
        if (!$productFile) {
            return response()->json([
                'error' => 'O ficheiro não pôde ser criado.'
            ], Response::HTTP_NOT_FOUND);
        }

        // Retorna a resposta com o recurso criado
        return response()->json(new ProductFileResource($productFile), Response::HTTP_CREATED);
    }

}
