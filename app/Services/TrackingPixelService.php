<?php

namespace App\Services;

use App\DTO\TrackingPixel\TrackingPixelDTO;
use App\DTO\TrackingPixel\UpdateTrackingPixelDTO;
use App\Repositories\TrackingPixel\TrackingPixelRepositoryInterface;

class TrackingPixelService
{
    public function __construct(
        protected TrackingPixelRepositoryInterface $repository
    ) {
    }

    public function createPixel(TrackingPixelDTO $dto)
    {
        return $this->repository->create($dto);
    }

    public function updatePixel(UpdateTrackingPixelDTO $dto)
    {
        return $this->repository->update($dto);
    }

    public function deletePixel(int $id)
    {
        return $this->repository->delete($id);
    }

    public function getPixelById(int $id)
    {
        return $this->repository->findById($id);
    }

    public function getAllPixelsByProducerId()
    {
        return $this->repository->findAllByProducerId();
    }
}
