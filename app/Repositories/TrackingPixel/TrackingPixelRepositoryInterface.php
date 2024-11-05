<?php

namespace App\Repositories\TrackingPixel;

use App\DTO\TrackingPixel\TrackingPixelDTO;
use App\DTO\TrackingPixel\UpdateTrackingPixelDTO;
use App\Models\TrackingPixel;

interface TrackingPixelRepositoryInterface
{
    public function create(TrackingPixelDTO $dto): TrackingPixel;
    public function update(UpdateTrackingPixelDTO $dto): ?TrackingPixel;
    public function delete(int $id): bool;
    public function findById(int $id): ?TrackingPixel;
    public function findAllByProducer();
    public function findAllByProducerId(int $producerId);
}
