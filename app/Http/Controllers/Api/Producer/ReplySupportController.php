<?php

namespace App\Http\Controllers\Api\Producer;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReplySupport;
use App\Http\Resources\ReplySupportResource;
use App\Repositories\Support\ReplySupportRepository;
use App\Services\SupportService;
use App\Enum\SupportEnum;
use App\Http\Resources\SupportResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReplySupportController extends Controller
{
    protected $repository;
    protected $supportService;

    public function __construct(ReplySupportRepository $replySupportRepository, SupportService $supportService)
    {
        $this->repository = $replySupportRepository;
        $this->supportService = $supportService;
    }

    /**
     * @OA\Get(
     *     path="/api/supports",
     *     summary="Get all supports",
     *     description="Fetches a list of all supports with the given status.",
     *     operationId="getAllSupports",
     *     tags={"Supports Producer"},
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         required=false,
     *         description="Status of the supports to filter",
     *         @OA\Schema(
     *             type="string",
     *             default="P",
     *             enum={"P", "A", "C"}
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfully retrieved the list of supports",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(
     *                     property="supports",
     *                     type="array",
     *                     @OA\Items(
     *                         @OA\Property(property="id", type="integer", example=2),
     *                         @OA\Property(property="user_id", type="integer", example=2),
     *                         @OA\Property(property="lesson_id", type="integer", example=1),
     *                         @OA\Property(property="producer_id", type="integer", example=1),
     *                         @OA\Property(property="status", type="string", example="P"),
     *                         @OA\Property(property="description", type="string", example="The lesson field is required. (and 2 more errors)"),
     *                         @OA\Property(property="created_at", type="string", format="date-time", example="2024-06-18T14:17:09.000000Z"),
     *                         @OA\Property(property="updated_at", type="string", format="date-time", example="2024-06-18T14:17:09.000000Z"),
     *                         @OA\Property(
     *                             property="user",
     *                             type="object",
     *                             @OA\Property(property="id", type="integer", example=2),
     *                             @OA\Property(property="name", type="string", example="Siara Bumba"),
     *                             @OA\Property(property="url", type="string", nullable=true, example=null),
     *                             @OA\Property(property="email", type="string", example="moises.alberto.king.bumba@gmail.com"),
     *                             @OA\Property(property="bibliography", type="string", nullable=true, example=null),
     *                             @OA\Property(property="phone_number", type="string", nullable=true, example=null),
     *                             @OA\Property(property="bi", type="string", nullable=true, example=null),
     *                             @OA\Property(property="image", type="string", nullable=true, example=null),
     *                             @OA\Property(property="type", type="string", nullable=true, example=null),
     *                             @OA\Property(property="email_verified_at", type="string", format="date-time", nullable=true, example=null),
     *                             @OA\Property(property="current_team_id", type="integer", nullable=true, example=null),
     *                             @OA\Property(property="profile_photo_path", type="string", nullable=true, example=null),
     *                             @OA\Property(property="created_at", type="string", format="date-time", example="2024-06-15T22:14:15.000000Z"),
     *                             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-06-15T22:14:15.000000Z")
     *                         ),
     *                         @OA\Property(
     *                             property="lesson",
     *                             type="object",
     *                             @OA\Property(property="id", type="integer", example=1),
     *                             @OA\Property(property="module_id", type="integer", example=1),
     *                             @OA\Property(property="name", type="string", example="Lesson 1"),
     *                             @OA\Property(property="url", type="string", example="05874CE2"),
     *                             @OA\Property(property="description", type="string", example="CNN PRIME TIME"),
     *                             @OA\Property(property="file", type="string", example="https://forma-te-ebooks-bucket.s3.amazonaws.com/lessonPdf/lesson-1.pdf"),
     *                             @OA\Property(property="free", type="boolean", example=true),
     *                             @OA\Property(property="video", type="string", example="https://www.youtube.com/watch?v=a1HjPcJbB3c"),
     *                             @OA\Property(property="created_at", type="string", format="date-time", example="2024-06-15T22:10:38.000000Z"),
     *                             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-06-15T22:10:38.000000Z")
     *                         )
     *                     )
     *                 ),
     *                 @OA\Property(
     *                     property="status_options",
     *                     type="array",
     *                     @OA\Items(
     *                         @OA\Property(property="Pendente", type="string", example="Pendente"),
     *                         @OA\Property(property="Aguardado_Aluno", type="string", example="Aguardado Aluno"),
     *                         @OA\Property(property="Finalizado", type="string", example="Finalizado")
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to retrieve the supports",
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
     *                 example="Failed to retrieve supports: Database connection error"
     *             )
     *         )
     *     )
     * )
     */

    public function getAllSupports(Request $request)
    {
        try {
            $supports = $this->supportService->getSupports(
                status: $request->get('status', 'P')
            );

            $statusOptions = SupportEnum::cases();

            return response()->json([
                'success' => true,
                'data' => [
                    'supports' => $supports,
                    'status_options' => $statusOptions,
                ],
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve supports: ' . $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/support/{Id}",
     *     summary="Get a support message by ID",
     *     description="Fetches a support message based on the provided ID.",
     *     operationId="getSupportMessage",
     *     tags={"Supports Producer"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the support message",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfully retrieved the support message",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="status", type="string", example="P"),
     *                 @OA\Property(property="description", type="string", example="The lesson field is required. (and 2 more errors)"),
     *                 @OA\Property(property="lesson_id", type="integer", example=1),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-06-18T14:17:09.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-06-18T14:17:09.000000Z"),
     *                 @OA\Property(
     *                     property="user",
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=2),
     *                     @OA\Property(property="name", type="string", example="Siara Bumba"),
     *                     @OA\Property(property="email", type="string", example="moises.alberto.king.bumba@gmail.com")
     *                 ),
     *                 @OA\Property(
     *                     property="lesson",
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Lesson 1"),
     *                     @OA\Property(property="url", type="string", example="05874CE2"),
     *                     @OA\Property(property="description", type="string", example="CNN PRIME TIME")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Support message not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Support message not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to retrieve the support message",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Failed to retrieve support message: Internal Server Error")
     *         )
     *     )
     * )
     */

    public function message(string $id)
    {
        try {
            $message = $this->supportService->getSupport($id);

            if (!$message) {
                return response()->json([
                    'success' => false,
                    'message' => 'Support message not found',
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json([
                'success' => true,
                'data' => new SupportResource($message),
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve support message: ' . $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
    * @OA\Post(
    *     path="/api/supports/reply",
    *     summary="Create a reply to a support message",
    *     description="Creates a new reply to a specified support message.",
    *     operationId="createReply",
    *     tags={"Supports Producer"},
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="description", type="string", example="This is a reply to the support message."),
    *             @OA\Property(property="support_id", type="integer", example=1)
    *         )
    *     ),
    *     @OA\Response(
    *         response=201,
    *         description="Reply created successfully",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="success", type="boolean", example=true),
    *             @OA\Property(property="data", type="object",
    *                 @OA\Property(property="id", type="integer", example=1),
    *                 @OA\Property(property="description", type="string", example="This is a reply to the support message."),
    *                 @OA\Property(property="support_id", type="integer", example=1),
    *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-06-18T14:17:09.000000Z"),
    *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-06-18T14:17:09.000000Z")
    *             )
    *         )
    *     ),
    *     @OA\Response(
    *         response=400,
    *         description="Invalid input",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="success", type="boolean", example=false),
    *             @OA\Property(property="message", type="string", example="Invalid input")
    *         )
    *     ),
    *     @OA\Response(
    *         response=500,
    *         description="Failed to create the reply",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="success", type="boolean", example=false),
    *             @OA\Property(property="message", type="string", example="Failed to create reply: Internal Server Error")
    *         )
    *     )
    * )
    */

    public function createReply(StoreReplySupport $request)
    {
        $data = $request->only('description', 'support_id');
        $reply = $this->repository->createReplyToSupport($data);

        return new ReplySupportResource($reply);
    }
}
