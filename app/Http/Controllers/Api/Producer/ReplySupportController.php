<?php

namespace App\Http\Controllers\Api\Producer;

use App\Adapters\ReplySupportAdapters;
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
     *     description="Fetches a list of all supports Producer with the given status.",
     *     operationId="getSupportProducerByStatus",
     *     tags={"Supports Producer"},
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         required=false,
     *         description="Status of the supports Producer to filter",
     *         @OA\Schema(
     *             type="string",
     *             default="P",
     *             enum={"P", "A", "C"}
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfully retrieved the list of supports Producer",
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
     *         description="Failed to retrieve the supports Producer",
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

    public function getSupportProducerByStatus(Request $request)
    {
        try {
            $supports = $this->supportService->getSupportProducerByStatus(
                page: $request->get('page', 1),
                totalPerPage: $request->get('per_page', 15),
                status: $request->get('status', '')
            );

            $statusOptions = array_map(fn ($enum) => $enum->value, SupportEnum::cases());

            return response()->json([
                'success' => true,
                'data' => [
                    'supports' => ReplySupportAdapters::paginateToJson($supports, $statusOptions),
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
     *     path="/api/support/reply",
     *     summary="Create a reply to a support message",
     *     description="Creates a reply to an existing support message using the provided description and support ID.",
     *     operationId="createReply",
     *     tags={"Supports Producer"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"description", "support_id"},
     *             @OA\Property(property="description", type="string", example="The lesson Aguardar Professor"),
     *             @OA\Property(property="support_id", type="integer", example=3)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful reply creation",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="description", type="string", example="The lesson Aguardar Professor"),
     *                 @OA\Property(property="support", type="object",
     *                     @OA\Property(property="id", type="integer", example=3),
     *                     @OA\Property(property="status", type="string", example="P"),
     *                     @OA\Property(property="status_label", type="string", example="Pendente, Aguardar Professor"),
     *                     @OA\Property(property="description", type="string", example="The lesson field"),
     *                     @OA\Property(property="user", type="object",
     *                         @OA\Property(property="id", type="integer", example=2),
     *                         @OA\Property(property="name", type="string", example="Siara Bumba"),
     *                         @OA\Property(property="email", type="string", example="moises.alberto.king.bumba@gmail.com"),
     *                         @OA\Property(property="bibliography", type="string", nullable=true),
     *                         @OA\Property(property="phone_number", type="string", nullable=true),
     *                         @OA\Property(property="bi", type="string", nullable=true),
     *                         @OA\Property(property="image", type="string", nullable=true)
     *                     ),
     *                     @OA\Property(property="lesson", type="object",
     *                         @OA\Property(property="id", type="integer", example=3),
     *                         @OA\Property(property="name", type="string", example="Lesson 1"),
     *                         @OA\Property(property="description", type="string", example="CNN PRIME TIME"),
     *                         @OA\Property(property="video", type="string", example="https://www.youtube.com/watch?v=a1HjPcJbB3c"),
     *                         @OA\Property(property="file", type="string", example="https://forma-te-ebooks-bucket.s3.amazonaws.com/lessonPdf/lesson-1.pdf")
     *                     ),
     *                     @OA\Property(property="dt_updated", type="string", example="23/06/2024 11:23:07")
     *                 ),
     *                 @OA\Property(property="producer", type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Moises Bumba"),
     *                     @OA\Property(property="email", type="string", example="moises-alberto@hotmail.com"),
     *                     @OA\Property(property="bibliography", type="string", nullable=true),
     *                     @OA\Property(property="phone_number", type="string", nullable=true),
     *                     @OA\Property(property="bi", type="string", nullable=true),
     *                     @OA\Property(property="image", type="string", nullable=true)
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error"
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
