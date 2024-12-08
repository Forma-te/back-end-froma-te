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

    public function getSupportProducerByStatus(Request $request)
    {
        try {

            $defaultPerPage = 10;
            $maxPerPage = 100;

            $totalPerPage = (int) $request->get('per_page', $defaultPerPage);

            if ($totalPerPage <= 0 || $totalPerPage > $maxPerPage) {
                $totalPerPage = $defaultPerPage;
            }

            $supports = $this->supportService->getSupportProducerByStatus(
                page: $request->get('page', 1),
                totalPerPage: $request->get('per_page', 15),
                status: $request->get('status', '')
            );

            $statusOptions = array_map(fn ($enum) => $enum->value, SupportEnum::cases());

            return response()->json(
                ReplySupportAdapters::paginateToJson($supports, $statusOptions),
            );
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve supports: ' . $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

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

    public function createReply(StoreReplySupport $request)
    {
        $data = $request->only('description', 'support_id');
        $reply = $this->repository->createReplyToSupport($data);

        return new ReplySupportResource($reply);
    }
}
