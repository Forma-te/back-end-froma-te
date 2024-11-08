<?php

namespace App\Repositories\Cart;

use App\DTO\Sale\CreateNewSaleDTO;
use App\DTO\User\CreateCustomerDetailsDTO;
use App\Events\SaleToNewAndOldMembers;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PlatformBalances;
use App\Models\Sale;
use App\Models\UserBalance;
use App\Repositories\Affiliate\AffiliateLinkRepository;
use App\Repositories\Commission\CommissionRepository;
use App\Repositories\Course\CourseRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CartRepository implements CartRepositoryInterface
{
    public function __construct(
        protected Cart $entity,
        protected CartItem $cartItem,
        protected Product $product,
        protected Sale $sale,
        protected Order $order,
        protected OrderItem $orderItem,
        protected UserBalance $userBalance,
        protected PlatformBalances $platformBalances,
        protected UserRepository $userRepository,
        protected CourseRepository $courseRepository,
        protected AffiliateLinkRepository $affiliateLinkRepository,
        protected CommissionRepository $commissionRepository
    ) {
    }

    public function getOrCreateCart(): Cart
    {
        if (Auth::check()) {
            $cart = $this->entity::firstOrCreate(['user_id' => Auth::user()->id]);

        } else {
            $sessionId = session()->getId();
            $cart = $this->entity::firstOrCreate(['session_id' => $sessionId]);
        }

        return $cart;
    }

    public function validateOrCreateCustomer(CreateCustomerDetailsDTO $dto)
    {
        $existingUser  = $this->userRepository->findByEmail($dto->email);

        // Se o utilizador já existir, apenas retorna o utilizador
        if ($existingUser !== null) {
            return $existingUser;
        }

        // Caso o utilizador não exista, cria um novo
        $userDto = new CreateCustomerDetailsDTO(
            $dto->name,
            $dto->email,
            $dto->phone_number,
            Hash::make($dto->password),  // Encripta a password
        );

        // Cria o novo utilizador no repositório
        $newUser  = $this->userRepository->createCustomerDetails($userDto);

        // Retorna o novo utilizador criado
        return $newUser;
    }

    public function addToCart(array $data)
    {
        $cart = $this->getOrCreateCart();

        // Verifica se o produto já está no carrinho
        $existingCartItem = $this->cartItem::where('cart_id', $cart->id)
                                ->where('product_id', $data['product_id'])
                                ->first();

        // Se o produto já existe, não faz nada e retorna o item existente
        if ($existingCartItem) {
            return $existingCartItem;
        }

        return $this->cartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $data['product_id'],
            'price' => $data['price']
        ]);
    }

    public function checkout(CreateNewSaleDTO $dto)
    {
        // Valida o carrinho
        $cart = $this->viewCart();
        if (empty($cart)) {
            return response()->json(['message' => 'Carrinho está vazio'], 400);
        }

        $member = $this->userRepository->findByEmail($dto->email_member);
        $sales = [];
        $totalAmount = $totalPlatformFee = $totalNetAmount = 0;

        DB::beginTransaction();
        try {
            foreach ($cart as $item) {
                if (!isset($item['product_id'])) {
                    continue;
                }

                $product = $this->courseRepository->findById($item['product_id']);
                if (!$product) {
                    continue; // Produto não encontrado, pule para o próximo
                }

                $currentPrice = $this->calculateCurrentPrice($product);
                [$platformFee, $netAmount] = $this->calculateFees($currentPrice);

                $newSale = $this->createSale($dto, $member, $product, $currentPrice);
                $sales[] = $newSale;

                $totalAmount += $currentPrice;
                $totalPlatformFee += $platformFee;
                $totalNetAmount += $netAmount;

                $this->createPlatformBalance($item, $platformFee);
                event(new SaleToNewAndOldMembers($member, $product));
            }

            $order = $this->createOrder($totalAmount, $totalPlatformFee, $totalNetAmount);
            foreach ($cart as $item) {
                $this->createOrderItem($order->id, $item);
                $this->updateSellerBalance($item);
            }

            session()->forget('cart');
            $this->clearCart();

            DB::commit();
            return response()->json([
                'order' => $order,
                'sale' => $sales,
                'message' => 'Compra finalizada com sucesso'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Erro ao finalizar a compra: ' . $e->getMessage()], 500);
        }
    }

    private function calculateFees(float $currentPrice): array
    {
        $platformFeePercentage = config('platform.fee_percentage', 10) / 100;
        $platformFee = $currentPrice * $platformFeePercentage;
        $netAmount = $currentPrice - $platformFee;

        return [$platformFee, $netAmount];
    }

    private function createSale(CreateNewSaleDTO $dto, $member, $product, $currentPrice)
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

    private function createOrder($totalAmount, $platformFee, $netAmount)
    {
        return $this->order::create([
            'user_id' => Auth::user()->id,
            'total_amount' => $totalAmount,
            'platform_fee' => $platformFee,
            'net_amount' => $netAmount,
            'status' => 'completed'
        ]);
    }

    private function createOrderItem($orderId, $item)
    {
        return $this->orderItem::create([
            'order_id' => $orderId,
            'product_id' => $item['product_id'],
            'price' => $item['price']
        ]);
    }

    private function updateSellerBalance($item)
    {
        $product = $this->product::findOrFail($item['product_id']);
        $seller = $product->user;
        $balance = $this->userBalance::firstOrCreate(['user_id' => $seller->id]);
        $balance->total_balance += $item['price'] * 0.90; // 90% para o vendedor
        $balance->save();
    }

    private function createPlatformBalance($item, $itemPlatformFee)
    {
        $productPercentage = 10;  // 10% de taxa por produto

        return $this->platformBalances::create([
            'product_id' => $item['product_id'],
            'product_value' => $item['price'],
            'product_percentage' => $productPercentage,
            'total_balance' => $itemPlatformFee,
            'available_balance' => $itemPlatformFee,
            'pending_balance' => 0, // Ajustar conforme necessário
        ]);
    }

    public function clearCart(): bool
    {
        $cart = $this->getOrCreateCart();

        return $this->cartItem::where('cart_id', $cart->id)->delete() > 0;
    }

    public function removeFromCart($product_id)
    {
        // Obter ou criar o carrinho
        $cart = $this->getOrCreateCart();

        // Verificar se o carrinho foi criado corretamente
        if (!$cart) {
            return response()->json(['message' => 'Carrinho não encontrado'], 404);
        }

        // Remover o item do carrinho
        $deleted = $this->cartItem::where('cart_id', $cart->id)
            ->where('product_id', $product_id)
            ->delete();

        // Verificar se o item foi removido
        if ($deleted > 0) {
            return response()->json(['message' => 'Item removido com sucesso'], 200);
        }

        return response()->json(['message' => 'Item não encontrado no carrinho'], 404);
    }


    public function getCartById(int $cartId): ?Cart
    {
        return $this->entity::find($cartId);
    }

    public function updateCart(Request $request): bool
    {
        $cartItem = $this->cartItem::where('cart_id', $this->getOrCreateCart()->id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) {
            $cartItem->quantity = $request->quantity;
            $cartItem->save();

            return true; // Indica que a atualização foi bem-sucedida
        }

        return false; // Indica que o item não foi encontrado
    }

    public function syncSessionCart(Cart $cart): void
    {
        if (Auth::check()) {
            $sessionId = session()->getId();
            $sessionCart = $this->entity::where('session_id', $sessionId)->first();

            if ($sessionCart) {
                foreach ($sessionCart->items as $sessionItem) {
                    $existingItem = $cart->items()->where('product_id', $sessionItem->product_id)->first();

                    if ($existingItem) {
                        $existingItem->quantity += $sessionItem->quantity;
                        $existingItem->save();
                    } else {
                        $cart->items()->create([
                            'product_id' => $sessionItem->product_id,
                            'quantity' => $sessionItem->quantity,
                        ]);
                    }
                }

                // Apagar o carrinho da sessão após sincronizar
                $sessionCart->delete();
            }
        }
    }

    public function viewCart()
    {
        $cart = $this->getOrCreateCart();
        $cartItems = $cart->items()->with([
            'product' => function ($query) {

                $query->select('id', 'name', 'price', 'discount', 'product_type');
            },
            'product.files' => function ($query) {

                $query->select('id', 'product_id', 'image', 'type');
            },
            'product.orderBumps' => function ($query) {

                $query->select('id', 'product_id', 'offer_product_id', 'call_to_action', 'title', 'description', 'show_image');
            },
            'product.orderBumps.offerProduct' => function ($query) {

                $query->select('id', 'name', 'price');

            },'product.orderBumps.offerProduct.files' => function ($query) {

                $query->select('id', 'product_id', 'image', 'type');
            },
        ])->get();

        foreach ($cartItems as $item) {
            // Verifica o preço atual do produto
            $product = $item->product;

            if ($product) {
                // Se o preço do produto mudou, atualiza no carrinho
                if ($item->price !== $product->price) {
                    $item->price = $product->price - ($product->price * ($product->discount / 100));
                    $item->save();
                }
            }
        }

        return $cartItems->toArray();
    }

}
