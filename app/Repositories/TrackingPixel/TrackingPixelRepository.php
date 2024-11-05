<?php

namespace App\Repositories\TrackingPixel;

use App\DTO\TrackingPixel\TrackingPixelDTO;
use App\DTO\TrackingPixel\UpdateTrackingPixelDTO;
use App\Models\TrackingPixel;

class TrackingPixelRepository implements TrackingPixelRepositoryInterface
{
    public function __construct(
        protected TrackingPixel $entity
    ) {
    }

    public function create(TrackingPixelDTO $dto): TrackingPixel
    {
        return $this->entity->create($dto->toArray());
    }

    public function update(UpdateTrackingPixelDTO $dto): ?TrackingPixel
    {
        $pixel = $this->findById($dto->id);

        if ($pixel) {
            $pixel->update($dto->toArray());
            return $pixel;
        }

        return null;
    }

    public function delete(int $id): bool
    {
        $pixel = $this->findById($id);

        return $pixel ? $pixel->delete() : false;
    }

    public function findById(int $id): ?TrackingPixel
    {
        return $this->entity->find($id);
    }

    public function findAllByProducer()
    {
        return $this->entity
                    ->with('producer')
                    ->producerByAuth()
                    ->get();
    }

    public function findAllByProducerId(int $producerId)
    {
        return $this->entity
                    ->where('producer_id', $producerId)
                    ->get();
    }

}
