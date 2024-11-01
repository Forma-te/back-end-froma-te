<?php

namespace App\Http\Controllers\Api\Producer;

use App\Http\Requests\TrackingPixelRequest;
use App\DTO\TrackingPixel\TrackingPixelDTO;
use App\Http\Controllers\Controller;
use App\DTO\TrackingPixel\UpdateTrackingPixelDTO;
use App\Http\Resources\TrackingPixelResource;
use App\Services\TrackingPixelService;
use Illuminate\Http\Response;

class TrackingPixelController extends Controller
{
    public function __construct(
        protected TrackingPixelService $trackingPixelService
    ) {
    }

    public function store(TrackingPixelRequest $request)
    {
        $pixel = $this->trackingPixelService->createPixel(
            TrackingPixelDTO::makeFromRequest($request)
        );

        return new TrackingPixelResource($pixel);
    }

    public function update(TrackingPixelRequest $request, int $id)
    {
        $pixel = $this->trackingPixelService->updatePixel(
            UpdateTrackingPixelDTO::makeFromRequest($request, $id)
        );

        if (!$pixel) {
            return response()->json([
                'error' => 'Not Found'
            ], Response::HTTP_NOT_FOUND);
        }

        return new TrackingPixelResource($pixel);
    }

    public function destroy(int $id)
    {
        $deleted = $this->trackingPixelService->deletePixel($id);

        if (!$deleted) {
            return response()->json(['error' => 'Pixel not found'], 404);
        }

        return response()->json(['message' => 'Pixel deleted successfully']);
    }

    public function show(int $id)
    {
        $pixel = $this->trackingPixelService->getPixelById($id);

        if (!$pixel) {
            return response()->json(['error' => 'Pixel not found'], 404);
        }

        return new TrackingPixelResource($pixel);
    }

    public function index()
    {
        $pixels = $this->trackingPixelService->getAllPixelsByProducerId();

        return TrackingPixelResource::collection($pixels);
    }
}
