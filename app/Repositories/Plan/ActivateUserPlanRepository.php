<?php

namespace App\Repositories\Plan;

use App\Events\ActivateInstructor;
use App\Models\Sale;
use App\Models\SaleInstructor;
use App\Models\SaleSubscription;
use App\Repositories\PaginationInterface;
use App\Repositories\PaginationPresenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActivateUserPlanRepository implements ActivateUserPlanRepositoryInterface
{
    public function __construct(
        protected SaleInstructor $entity,
        protected SaleSubscription $saleSubscription,
        protected Sale $sale
    ) {
    }

    public function getAllUserRequests(int $page = 1, int $totalPerPage = 15, string $filter = null): PaginationInterface
    {
        $query = $this->entity->where('status', 'started');

        if ($filter) {
            $query->where(function ($query) use ($filter) {
                $query->where('email', $filter)
                      ->orWhere('email', 'like', "%{$filter}%");
            });
        }
        // Paginar os resultados
        $result = $query->paginate($totalPerPage, ['*'], 'page', $page);
        // Retornar os resultados paginados
        return new PaginationPresenter($result);
    }

    public function getUserRequestsById($id)
    {
        return $this->entity->with('plan')->find($id);
    }

    public function activatePlan(Request $request, $id)
    {
        $dataForm = $request->all();

        DB::beginTransaction();

        try {
            // Encontre a solicitação do usuário pelo ID
            $userRequest = $this->entity->find($id);

            if (!$userRequest) {
                return response()->json(['error' => 'Request not found'], 404);
            }

            // Atualize o status da solicitação do usuário
            $userRequest->status = 'approved';
            $userRequest->save();

            // Crie uma nova venda de plano
            $newProducerSale = $this->saleSubscription::create([
                'producer_id' => $userRequest->producer_id,
                'quantity' => $userRequest->quantity,
                'plan_id' => $userRequest->plan_id,
                'total' => $userRequest->total,
                'date_the_end' => $dataForm['date_the_end'],
                'date_start' => date('Y-m-d'),
                'status' => 'Aprovado',
            ]);

            // Atualize o status das vendas suspensas
            if ($newProducerSale->producer_id) {
                $this->sale::where('instrutor_id', $newProducerSale->producer_id)
                           ->where('status', '=', 'suspended')
                           ->update(['status' => 'approved']);
            }

            event(new ActivateInstructor($newProducerSale));

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function getActivePlans(int $page = 1, int $totalPerPage = 15, string $filter = null): PaginationInterface
    {
        $query = $this->saleSubscription
                      ->with('producer')
                      ->where('status', 'approved')
                      ->orderBy('updated_at', 'desc');

        if ($filter) {
            $query->where(function ($query) use ($filter) {
                $query->where('email', $filter)
                      ->orWhere('email', 'like', "%{$filter}%");
            });
        }
        // Paginar os resultados
        $result = $query->paginate($totalPerPage, ['*'], 'page', $page);
        // Retornar os resultados paginados
        return new PaginationPresenter($result);
    }

    public function getProducerWithApprovedStatus()
    {
        return $this->saleSubscription->userByAuth()
                                      ->orderBy('updated_at', 'desc')
                                      ->with('plan')
                                      ->first();

    }

    public function getProducerHistorical(int $page = 1, int $totalPerPage = 10): PaginationInterface
    {
        $query = $this->saleSubscription->userByAuth()
                                       ->orderBy('updated_at', 'desc')
                                       ->with('plan');

        $result = $query->paginate($totalPerPage, ['*'], 'page', $page);

        return new PaginationPresenter($result);
    }
}
