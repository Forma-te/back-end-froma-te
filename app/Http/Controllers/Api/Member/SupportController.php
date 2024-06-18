<?php

namespace App\Http\Controllers\Api\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSupport;
use App\Http\Resources\SupportResource;
use App\Repositories\Member\SupportRepository;

class SupportController extends Controller
{
    protected $repository;

    public function __construct(SupportRepository $supportRepository)
    {
        $this->repository = $supportRepository;
    }

    /**
     * @OA\Post(
     *     path="/api/supports",
     *     summary="Create a new support request",
     *     description="Creates a new support request and returns the created support details.",
     *     operationId="createSupport",
     *     tags={"Support"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="string", enum={"P", "A", "C"}, example="P"),
     *             @OA\Property(property="description", type="string", example="The lesson field is required. (and 2 more errors)"),
     *             @OA\Property(property="lesson_id", type="integer", example=2)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Support request created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=2),
     *             @OA\Property(property="status", type="string", example="P"),
     *             @OA\Property(property="status_label", type="string", example="Pendente, Aguardar Professor"),
     *             @OA\Property(property="description", type="string", example="The lesson field is required. (and 2 more errors)"),
     *             @OA\Property(
     *                 property="user",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=2),
     *                 @OA\Property(property="name", type="string", example="Siara Bumba"),
     *                 @OA\Property(property="email", type="string", example="moises.alberto.king.bumba@gmail.com"),
     *                 @OA\Property(property="bibliography", type="string", nullable=true, example=null),
     *                 @OA\Property(property="phone_number", type="string", nullable=true, example=null),
     *                 @OA\Property(property="bi", type="string", nullable=true, example=null),
     *                 @OA\Property(property="image", type="string", nullable=true, example=null)
     *             ),
     *             @OA\Property(
     *                 property="lesson",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=2),
     *                 @OA\Property(property="name", type="string", example="Lesson 2"),
     *                 @OA\Property(property="description", type="string", example="CNN PRIME TIME"),
     *                 @OA\Property(property="video", type="string", example="https://www.youtube.com/watch?v=a1HjPcJbB3c"),
     *                 @OA\Property(property="file", type="string", example="https://forma-te-ebooks-bucket.s3.amazonaws.com/lessonPdf/lesson-2.pdf")
     *             ),
     *             @OA\Property(property="dt_updated", type="string", example="17/06/2024 22:50:36")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error"
     *     )
     * )
     */
    public function createSupport(StoreSupport $request)
    {
        $supports = $this->repository->createNewSupport($request->validated());

        return new SupportResource($supports);
    }

}
