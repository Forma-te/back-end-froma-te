<?php

namespace App\Adapters;

use App\Http\Resources\MemberStatusResource;
use App\Repositories\PaginationInterface;

/**
 * Class ApiAdapter
 *
 * @package App\Adapters
 */


class MemberAdapters
{
    /**
     * Converte dados paginados para o formato JSON desejado.
     *
     * @param PaginationInterface $data
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */


    public static function paginateToJson(PaginationInterface $data, $statusOptions, $channelOptions, $productTypeEnum): array
    {
        return [
            'data' => MemberStatusResource::collection($data->items())->toArray(request()), // Convert collection to array
            'meta' => [
                'total' => $data->total(),
                'is_first_page' => $data->isFirstPage(),
                'is_last_page' => $data->isLastPage(),
                'current_page' => $data->currentPage(),
                'next_page' => $data->getNumberNextPage() ?? null, // Obtém o número da próxima página
                'previous_page' => $data->getNumberPreviousPage() ?? null, // Obtém o número da página anterior
            ],
            'status_options' => $statusOptions,
            'channel_options' => $channelOptions,
            'type_options' => $productTypeEnum,
        ];
    }
}