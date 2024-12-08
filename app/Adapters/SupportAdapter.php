<?php

namespace App\Adapters;

use App\Http\Resources\SupportResource;
use App\Repositories\PaginationInterface;

/**
 * Class ApiAdapter
 *
 * @package App\Adapters
 */


class SupportAdapter
{
    /**
     * Converte dados paginados para o formato JSON desejado.
     *
     * @param PaginationInterface $data
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */

    public static function paginateToJson(PaginationInterface $data, array $statusOptions): array
    {
        return [
            'data' => SupportResource::collection($data->items()),
            'meta' => [
                'total' => $data->total(),
                'is_first_page' => $data->isFirstPage(),
                'is_last_page' => $data->isLastPage(),
                'current_page' => $data->currentPage(),
                'next_page' => $data->getNumberNextPage(),
                'previous_page' => $data->getNumberPreviousPage(),
            ],
            'status_options' => $statusOptions,
        ];
    }
}
