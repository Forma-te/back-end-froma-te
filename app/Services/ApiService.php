<?php

namespace App\Services;

use App\Adapters\ApiAdapter;
use App\Http\Resources\CourseResource;
use App\Repositories\PaginationInterface;

class ApiService
{
    protected string $resourceClass;

    public function __construct(string $resourceClass = null)
    {
        $this->resourceClass = $resourceClass ?? CourseResource::class; // Default to CourseResource if not provided
    }

    public function paginateToJson(PaginationInterface $data)
    {
        return ApiAdapter::paginateToJson($data, $this->resourceClass);
    }

    public function setResourceClass(string $resourceClass): void
    {
        $this->resourceClass = $resourceClass;
    }
}
