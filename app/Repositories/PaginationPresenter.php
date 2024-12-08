<?php

namespace App\Repositories;

use App\Repositories\PaginationInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use stdClass;

class PaginationPresenter implements PaginationInterface
{
    /**
     * @var stdClass[]
     */
    private array $items;

    public function __construct(
        protected LengthAwarePaginator $paginator,
    ) {
        $this->items = $this->resolveItems($this->paginator->items());
    }

    /**
     * @return stdClass[]
     */
    public function items(): array
    {
        return $this->items;
    }

    public function total(): int
    {
        return $this->paginator->total() ?? 0;
    }

    public function isFirstPage(): bool
    {
        return $this->paginator->onFirstPage();
    }

    public function isLastPage(): bool
    {
        return $this->paginator->currentPage() === $this->paginator->lastPage();
    }

    public function currentPage(): int
    {
        return $this->paginator->currentPage() ?? 1;
    }

    public function getNumberNextPage(): int
    {
        return $this->paginator->currentPage() + 1;
    }

    public function getNumberPreviousPage(): int
    {
        return $this->paginator->currentPage() - 1;
    }

    public function count(): int
    {
        return $this->paginator->count();
    }

    public function onFirstPage(): bool
    {
        return $this->paginator->onFirstPage();
    }

    public function hasMorePages(): bool
    {
        return $this->paginator->hasMorePages();
    }

    public function previousPageUrl(): ?string
    {
        return $this->paginator->previousPageUrl();
    }

    public function nextPageUrl(): ?string
    {
        return $this->paginator->nextPageUrl();
    }

    public function url($page): string
    {
        return $this->paginator->url($page);
    }

    /**
     * Resolve os itens da página, transformando-os em objetos stdClass
     *
     * @param array $items
     * @return stdClass[]
     */
    private function resolveItems(array $items): array
    {
        $response = [];
        foreach ($items as $item) {
            $response[] = is_object($item) ? (object) $item : (object) $item;
        }
        return $response;
    }
}
