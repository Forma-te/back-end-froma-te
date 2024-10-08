<?php

namespace App\Repositories\Cart;

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
    public function removeFromCart(Request $request);
    public function clearCart(): bool;
    public function syncSessionCart(Cart $cart): void;
    public function viewCart(): array;
    public function checkout();
}
