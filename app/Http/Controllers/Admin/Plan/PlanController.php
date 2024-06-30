<?php

namespace App\Http\Controllers\Admin\Plan;

use App\Adapters\ApiAdapter;
use App\DTO\Admin\Plan\CreatePlanDTO;
use App\DTO\Admin\Plan\UpdatePlanDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdatePlanRequest;
use App\Services\Admin\PlanService;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function __construct(
        protected PlanService $planService
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $plan = $this->planService->paginate(
            page: $request->get('page', 1),
            totalPerPage: $request->get('per_page', 15),
            filter: $request->get('filter'),
        );

        dd(['plan' => $plan]);
        //return ApiAdapter::paginateToJson($plan);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUpdatePlanRequest $request)
    {
        $this->planService->store(
            CreatePlanDTO::makeFromRequest($request)
        );

        return redirect()->route('plans.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $url)
    {
        $plan = $this->planService->show($url);
        $title = 'Forma-te Plataforma de ensino a distância';

        dd($plan);

        return view('', [
            'plan' => $plan, 'title' => $title,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $url)
    {
        $title = 'Forma-te Plataforma de ensino a distância';
        $plan = $this->planService->edit($url);

        dd($plan);
        return view('', [
            'plan' => $plan, 'title' => $title,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $url)
    {
        $this->planService->update(
            UpdatePlanDTO::makeFromRequest($request, $url)
        );

        return redirect()->route('plans.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $url)
    {
        if (!$this->planService->show($url)) {
            return redirect()->back();
        }

        $this->planService->delete($url);

        return redirect()->route('plans.index');
    }
}
