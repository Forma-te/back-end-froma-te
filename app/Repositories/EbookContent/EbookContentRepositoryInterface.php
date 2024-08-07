<?php

namespace App\Repositories\EbookContent;

use App\DTO\EbookContent\CreateEbookContentDTO;
use App\DTO\EbookContent\UpdateEbookContentDTO;
use App\Models\EbookContent;
use App\Repositories\PaginationInterface;
use stdClass;

interface EbookContentRepositoryInterface
{
    public function paginate(int $page = 1, int $totalPerPage = 15, string $filter = null): PaginationInterface;
    public function findById(string $id): object|null;
    public function getContentByEbookId(string $ebookId): ?array;
    public function new(CreateEbookContentDTO $dto): EbookContent;
    public function update(UpdateEbookContentDTO $dto): ?EbookContent;
    public function delete(string $id): void;
}
