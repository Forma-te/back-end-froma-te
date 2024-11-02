<?php

namespace App\Services;

use App\DTO\Sale\CreateNewSaleDTO;
use App\DTO\User\CreateCustomerDetailsDTO;
use App\Repositories\Cart\CartRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Product;

class CartService
{
    public function __construct(
        protected CartRepositoryInterface $repository,
        protected Product $product,
        protected CartItem $cartItem
    ) {
    }

    public function getOrCreateCart()
    {
        return $this->repository->getOrCreateCart();
    }

    public function validateOrCreateCustomer(CreateCustomerDetailsDTO $dto)
    {
        return $this->repository->validateOrCreateCustomer($dto);
    }

    public function addToCart(array $data)
    {
        $cart = $this->getOrCreateCart();

        // Verifica se o produto já está no carrinho
        $existingCartItem = $this->cartItem::where('cart_id', $cart->id)
                                ->where('product_id', $data['product_id'])
                                ->first();

        // Obtém o preço atual do produto
        $product = $this->product::find($data['product_id']);
        $currentPrice = $product->price - ($product->price * ($product->discount / 100));

        // Se o item já existe no carrinho
        if ($existingCartItem) {
            // Atualiza o preço caso tenha mudado
            if ($existingCartItem->price !== $currentPrice) {
                $existingCartItem->price = $currentPrice;
                $existingCartItem->save();
            }
            return $existingCartItem;
        }

        // Adiciona o item ao carrinho
        return $this->repository->addToCart([
            'product_id' => $product->id,
            'price' => $currentPrice
        ]);
    }

    public function viewCart()
    {
        return $this->repository->viewCart();
    }

    public function updateCart(Request $request)
    {
        return $this->repository->updateCart($request);
    }

    public function removeFromCart($product_id)
    {
        return $this->repository->removeFromCart($product_id);
    }

    public function syncSessionCart()
    {
        $cart = $this->repository->getOrCreateCart();
        $this->repository->syncSessionCart($cart);
    }

    public function checkout(CreateNewSaleDTO $dto)
    {
        // Chama o método checkout do repositório
        $result = $this->repository->checkout($dto);

        // Verifica se o resultado é um array ou um objeto
        if (is_array($result) && isset($result['sale']) && isset($result['order'])) {
            return [
                'sale' => $result['sale'],
                'order' => $result['order'],
                'message' => 'Compra finalizada com sucesso'
            ];
        }

        // Se não houver resultados válidos, lança uma exceção ou retorna um erro
        throw new \Exception('Erro ao processar a compra');
    }
}
