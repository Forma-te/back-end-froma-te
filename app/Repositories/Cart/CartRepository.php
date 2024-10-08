<?php

namespace App\Repositories\Cart;

use App\DTO\User\CreateCustomerDetailsDTO;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Course;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PlatformBalances;
use App\Models\UserBalance;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CartRepository implements CartRepositoryInterface
{
    public function __construct(
        protected Cart $entity,
        protected CartItem $cartItem,
        protected Course $product,
        protected Order $order,
        protected OrderItem $orderItem,
        protected UserBalance $userBalance,
        protected PlatformBalances $platformBalances,
        protected UserRepository $userRepository,
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
        $member = $this->userRepository->findByEmail($dto->email);
 
        $password = null;

        if ($member === null) {
            $password = generatePassword();

            $userDto = new CreateCustomerDetailsDTO(
                $dto->name,
                $dto->email,
                Hash::make($password),
                $dto->phone_number,
                'default_device' // ou alguma lógica para definir o device_name
            );

            $member = $this->userRepository->createCustomerDetails($userDto);
        }

        return $member;
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
            'quantity' => $data['quantity'],
            'price' => $data['price']
        ]);
    }

    public function checkout()
    {
        // Obtém o carrinho com os itens
        $cart = $this->viewCart();

        if (empty($cart)) {
            return response()->json(['message' => 'Carrinho está vazio'], 400);
        }

        $totalAmount = 0;

        foreach ($cart as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }

        $platformFee = $totalAmount * 0.10; // 10% de taxa
        $netAmount = $totalAmount - $platformFee; // Valor líquido para o vendedor

        // Criar o pedido
        $order = $this->order::create([
            'user_id' => Auth::user()->id,
            'total_amount' => $totalAmount,
            'platform_fee' => $platformFee,
            'net_amount' => $netAmount,
            'status' => 'completed',
        ]);

        // Criar os itens do pedido
        foreach ($cart as $item) {
            $this->orderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);

            // Atualizar saldo do vendedor
            $product = $this->product::findOrFail($item['product_id']);
            $seller = $product->user;
            $balance = $this->userBalance::firstOrCreate(['user_id' => $seller->id]);
            $balance->total_balance += ($item['price'] * $item['quantity']) * 0.90; // 90% para o vendedor
            $balance->save();

            // Calcular a percentagem da plataforma para o produto
            $platformFeePerProduct = $item['price'] * 0.10; // 10% de taxa por produto

            // Criar registo em PlatformBalances para cada item no carrinho
            $this->platformBalances::create([
                'product_id' => $item['product_id'],
                'product_value' => $item['price'],
                'product_percentage' => $platformFeePerProduct,
                'total_balance' => $platformFee,
                'available_balance' => $platformFee,
                'pending_balance' => 0, // Ajustar conforme necessário
            ]);
        }

        // Esvaziar o carrinho após a compra
        session()->forget('cart');

        $this->clearCart();

        return response()->json(['order' => $order, 'message' => 'Compra finalizada com sucesso']);
    }

    public function clearCart(): bool
    {
        $cart = $this->getOrCreateCart();

        return $this->cartItem::where('cart_id', $cart->id)->delete() > 0;
    }

    public function removeFromCart(Request $request)
    {
        // Obter ou criar o carrinho
        $cart = $this->getOrCreateCart();

        // Verificar se o carrinho foi criado corretamente
        if (!$cart) {
            return response()->json(['message' => 'Carrinho não encontrado'], 404);
        }

        // Remover o item do carrinho
        $deleted = $this->cartItem::where('cart_id', $cart->id)
            ->where('product_id', $request->product_id)
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

    public function viewCart(): array
    {
        $cart = $this->getOrCreateCart();
        $cartItems = $cart->items;

        foreach ($cartItems as $item) {
            // Verifica o preço atual do produto
            $product = $this->product::find($item->product_id);

            if ($product) {
                // Se o preço do produto mudou, atualiza no carrinho
                if ($item->price !== $product->price) {
                    $item->price = $product->price - ($product->price * ($product->discount / 100));
                    $item->save();
                }
            }
        }

        return $cartItems->toArray();
        ;
    }

}
