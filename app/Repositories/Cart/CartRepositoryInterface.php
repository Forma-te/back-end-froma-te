<?php

namespace App\Repositories\Cart;

use App\DTO\Sale\CreateNewSaleDTO;
use App\DTO\User\CreateCustomerDetailsDTO;
use App\Models\Cart;
use Illuminate\Http\Request;

interface CartRepositoryInterface
{
    public function getOrCreateCart(): Cart;
    public function validateOrCreateCustomer(CreateCustomerDetailsDTO $dto);
    public function addToCart(array $data);
    public function getCartById(int $cartId): ?Cart;
    public function updateCart(Request $request): bool;
    public function removeFromCart($product_id);
    public function clearCart(): bool;
    public function syncSessionCart(Cart $cart): void;
    public function viewCart();
    public function checkout(CreateNewSaleDTO $dto);
}
