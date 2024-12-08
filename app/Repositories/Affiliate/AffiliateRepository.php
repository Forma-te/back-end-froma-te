<?php

namespace App\Repositories\Affiliate;

use App\DTO\Affiliate\CreateAffiliateDTO;
use App\DTO\Affiliate\SaleAffiliateDTO;
use App\Enum\ProductTypeEnum;
use App\Enum\SaleEnum;
use App\Enum\SalesChannelEnum;
use App\Events\SaleToNewAndOldMembers;
use App\Models\Affiliate;
use App\Models\Commission;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PlatformBalances;
use App\Models\Sale;
use App\Models\UserBalance;
use App\Repositories\Cart\CartRepository;
use App\Repositories\Course\CourseRepository;
use App\Repositories\PaginationInterface;
use App\Repositories\PaginationPresenter;
use App\Repositories\User\UserRepository;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AffiliateRepository implements AffiliateRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected Affiliate $entity,
        protected Sale $sale,
        protected CourseRepository $courseRepository,
        protected UserRepository $userRepository,
        protected CartRepository $cartRepository,
        protected PlatformBalances $platformBalances,
        protected Order $order,
        protected OrderItem $orderItem,
        protected UserBalance $userBalance,
        protected Commission $commission,
        protected AffiliateLinkRepository $affiliateLinkRepository
    ) {
    }

    public function createAffiliate(CreateAffiliateDTO $dto)
    {
        // Primeiro, verifica se a afiliação já existe
        $existingAffiliateItem = $this->entity::where('user_id', $dto->user_id)
                                    ->where('product_url', $dto->product_url)
                                    ->first();

        // Se a afiliação já existir, retorna o item existente
        if ($existingAffiliateItem) {
            return $existingAffiliateItem;
        }

        $product = $this->courseRepository->getProductsByUrl($dto->product_url);

        // Cria o link de afiliação
        $affiliateLink = $this->affiliateLinkRepository->createAffiliateLink($dto, $dto->user_id);

        $affiliate = $this->entity->create(array_merge($dto->toArray(), [
                    'affiliate_link_id' => $affiliateLink->id,
                    'product_id' => $product->id,
                    'producer_id' => $product->user_id
        ]));

        return $affiliate;
    }

    public function findByUserAndProduct($userId, $productId)
    {
        return $this->entity::where('user_id', $userId)
                            ->where('product_id', $productId)
                            ->first();
    }


    public function findById(string $id): object|null
    {
        return $this->entity->find($id);
    }

    public function myAffiliations(
        int $page = 1,
        int $totalPerPage  = 10,
        string $filter = null
    ): PaginationInterface {

        $query = $this->entity
                    ->userByAuth()
                    ->with('producer', 'product.files', 'affiliateLink');

        // Filtro pelo nome do usuário
        if ($filter) {
            $query->whereHas('producer', function ($query) use ($filter) {
                $query->where('producer.name', 'like', "%{$filter}%");
            });
        }

        // Paginar os resultados
        $result = $query->paginate($totalPerPage, ['*'], 'page', $page);

        // Retornar os resultados paginados usando o PaginationPresenter
        return new PaginationPresenter($result);

    }

    public function myAffiliates(
        int $page = 1,
        int $totalPerPage  = 10,
        string $filter = null
    ): PaginationInterface {

        $query = $this->entity
                    ->producerByAuth()
                    ->with('user', 'product.files', 'affiliateLink');

        // Filtro pelo nome do usuário
        if ($filter) {
            $query->whereHas('user', function ($query) use ($filter) {
                $query->where('users.name', 'like', "%{$filter}%");
            });
        }

        // Paginar os resultados
        $result = $query->paginate($totalPerPage, ['*'], 'page', $page);
        // Retornar os resultados paginados usando o PaginationPresenter
        return new PaginationPresenter($result);
    }

    public function saleAffiliate(SaleAffiliateDTO $dto)
    {
        //$member = $this->userRepository->findById($dto->user_id);
        $member = $this->userRepository->findByEmail($dto->email_member);
        $totalAmount = $totalPlatformFee = $totalNetAmount = 0;

        DB::beginTransaction();
        try {
            // Recupera o produto pela URL
            $product = $this->courseRepository->getProductsByUrl($dto->product_url);
            if (!$product) {
                return response()->json(['message' => 'Produto não encontrado.'], 404);
            }

            $linkAffiliate = $dto->ref;
            $affiliateLink  = $this->affiliateLinkRepository->findByReference($linkAffiliate);

            if (!$affiliateLink) {
                return response()->json(['message' => 'Afiliado não encontrado para a referência fornecida'], 404);
            }

            $affiliateLinkId  = $affiliateLink->id;

            // Calcula o preço atual do produto com desconto, se aplicável
            $currentPrice = $this->calculateCurrentPrice($product);
            [$platformFee, $netAmount] = $this->calculateFees($currentPrice);

            // Cria a venda e armazena na variável $newSale
            $newSale = $this->createSale($dto, $member, $product, $currentPrice);

            // Acumula os valores totais
            $totalAmount += $currentPrice;
            $totalPlatformFee += $platformFee;
            $totalNetAmount += $netAmount;

            // Calcular a comissão usando a percentagem de afiliação do produto
            $affiliationPercentage = $product->affiliationPercentage ?? 0; // Exemplo: 10% de comissão
            $commissionAmount = $currentPrice * ($affiliationPercentage / 100);

            // Registrar a comissão apenas se o affiliateLinkId for válido
            if ($affiliateLinkId) {
                $this->createCommission($affiliateLinkId, $commissionAmount);
            }

            // Cria o saldo da plataforma com base na comissão do produto
            $this->createPlatformBalance($product, $platformFee);

            // Dispara um evento de venda para membros novos e antigos
            event(new SaleToNewAndOldMembers($member, $product));

            // Cria uma ordem associada à venda
            $order = $this->createOrder($totalAmount, $totalPlatformFee, $totalNetAmount, $member);

            // Cria o item da ordem e atualiza o saldo do vendedor diretamente com o produto atual
            $this->createOrderItem($order->id, [
                'product_id' => $product->id,
                'price' => $currentPrice
            ]);

            $this->updateSellerBalance($product, $currentPrice);

            DB::commit();

            return response()->json([
                'order' => $order,
                'sale' => $newSale,
                'commission' => $commissionAmount,
                'message' => 'Compra finalizada com sucesso'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Erro ao finalizar a compra: ' . $e->getMessage()], 500);
        }
    }


    private function createCommission($affiliateLinkId, $commissionAmount)
    {
        if (!$affiliateLinkId || !$commissionAmount) {
            return;
        }

        $this->commission::create([
            'affiliate_link_id' => $affiliateLinkId,
            'amount' => $commissionAmount,
            'status' => 'pending',
        ]);
    }

    private function calculateFees(float $currentPrice): array
    {
        $platformFeePercentage = config('platform.fee_percentage', 10) / 100;
        $platformFee = $currentPrice * $platformFeePercentage;
        $netAmount = $currentPrice - $platformFee;

        return [$platformFee, $netAmount];
    }

    private function createSale(SaleAffiliateDTO $dto, $member, $product, $currentPrice)
    {
        return $this->sale::create([
            'product_id' => $product->id,
            'user_id' => $member->id,
            'producer_id' => $product->user_id,
            'email_member' => $dto->email_member,
            'transaction' => $dto->transaction,
            'status' => $dto->status,
            'discount' => $product->discount,
            'sale_price' => $currentPrice,
            'sales_channel' => $dto->sales_channel,
            'payment_mode' => 'Banco',
            'date_created' => $dto->date_created,
            'product_type' => $product->product_type,
        ]);
    }

    private function calculateCurrentPrice($product)
    {
        return $product->price - ($product->price * ($product->discount / 100));
    }

    private function createOrder($totalAmount, $platformFee, $netAmount, $member)
    {
        return $this->order::create([
            'user_id' => $member->id,
            'total_amount' => $totalAmount,
            'platform_fee' => $platformFee,
            'net_amount' => $netAmount,
            'status' => 'completed'
        ]);
    }

    private function createOrderItem($orderId, array $item)
    {
        return $this->orderItem::create([
            'order_id' => $orderId,
            'product_id' => $item['product_id'],
            'price' => $item['price']
        ]);
    }

    private function createPlatformBalance($product, $itemPlatformFee)
    {
        $productPercentage = 10;  // 10% de taxa por produto

        return $this->platformBalances::create([
            'product_id' => $product->id,
            'product_value' => $product->price,
            'product_percentage' => $productPercentage,
            'total_balance' => $itemPlatformFee,
            'available_balance' => $itemPlatformFee,
            'pending_balance' => 0, // Ajustar conforme necessário
        ]);
    }

    private function updateSellerBalance($product, $price)
    {
        $seller = $product->user;
        $balance = $this->userBalance::firstOrCreate(['user_id' => $seller->id]);

        // Atualiza o saldo do vendedor com 90% do valor da venda
        $balance->total_balance += $price * 0.90;
        $balance->save();
    }

    public function delete(string $id): void
    {
        $this->entity->findOrFail($id)->delete();
    }

}
