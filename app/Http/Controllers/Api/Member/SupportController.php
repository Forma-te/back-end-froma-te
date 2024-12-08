<?php

namespace App\Http\Controllers\Api\Member;

use App\Adapters\SupportAdapter;
use App\Enum\SupportEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSupport;
use App\Http\Resources\SupportResource;
use App\Repositories\Member\SupportRepository;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    protected $repository;

    public function __construct(SupportRepository $supportRepository)
    {
        $this->repository = $supportRepository;
    }

    public function createSupport(StoreSupport $request)
    {
        $supports = $this->repository->createNewSupport($request->validated());

        return new SupportResource($supports);
    }

    public function getSupportsMember(Request $request)
    {
        $defaultPerPage = 10;
        $maxPerPage = 100;

        $totalPerPage = (int) $request->get('per_page', $defaultPerPage);

        if ($totalPerPage <= 0 || $totalPerPage > $maxPerPage) {
            $totalPerPage = $defaultPerPage;
        }

        $supports = $this->repository->getSupportsMember(
            page: $request->get('page', 1),
            totalPerPage: $request->get('per_page', 10),
            status: $request->get('status', ''),
            filter: $request->get('filter', '')
        );

        $statusOptions = array_map(fn ($enum) => $enum->value, SupportEnum::cases());

        return response()->json(
            SupportAdapter::paginateToJson($supports, $statusOptions),
        );
    }

}
