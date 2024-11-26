<?php

namespace App\Adapters;

use App\Http\Resources\DefaultResource;
use App\Repositories\PaginationInterface;

/**
 * Class ApiAdapter
 *
 * @package App\Adapters
 */


class ApiAdapter
{
    /**
     * Converte dados paginados para o formato JSON desejado.
     *
     * @param PaginationInterface $data
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */

    public static function paginateToJson(
        PaginationInterface  $data,
        array $categories = null
    ) {
        return DefaultResource::collection($data->items())
            ->additional([
                'meta' => [
                    'total' => $data->total(),
                    'is_first_page' => $data->isFirstPage(),
                    'is_last_page' => $data->isLastPage(),
                    'current_page' => $data->currentPage(),
                    'next_page' => $data->getNumberNextPage() ?? null, // Obtém o número da próxima página
                    'previous_page' => $data->getNumberPreviousPage() ?? null, // Obtém o número da página anterior
                ]
            ]);

        // Adicionar categorias à resposta, se disponíveis
        if (!empty($categories)) {
            $response->additional(['categories' => $categories]);
        }

        return $response;
    }
}
