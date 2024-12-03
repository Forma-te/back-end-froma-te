<?php

namespace App\Http\Controllers\Api\Cart;

use App\DTO\Sale\CreateNewSaleDTO;
use App\DTO\User\CreateCustomerDetailsDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerDetailsRequest;
use App\Http\Requests\StoreUpdateCartRequest;
use App\Http\Resources\UserResource;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */

    public function addToCart(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $cartItem = $this->cartService->addToCart($validated);

        return response()->json([
            'message' => 'Produto adicionado ao carrinho com sucesso.',
            'cartItem' => $cartItem,
        ]);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function viewCart()
    {
        $cart = $this->cartService->viewCart();

        return response()->json([
            'cart' => $cart,
        ]);
    }

    /**
     * Undocumented function
     *
     * @param StoreCustomerDetailsRequest $request
     * @return void
     */
    public function validateOrCreateCustomer(StoreCustomerDetailsRequest $request)
    {
        $result  = $this->cartService->validateOrCreateCustomer(
            CreateCustomerDetailsDTO::makeFromRequest($request)
        );

        return response()->json([
            'data' => new UserResource($result['user']),
            'exists' => $result['exists'],
        ]);
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function updateCart(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $cartItem = $this->cartService->updateCart($request);
        return response()->json(['message' => 'Carrinho atualizado', 'cartItem' => $cartItem]);
    }

    /**
     * Undocumented function
     *
     * @param [type] $product_id
     * @return void
     */
    public function removeFromCart($product_id)
    {
        // Verifica se o produto existe antes de tentar removê-lo
        if (!Product::where('id', $product_id)->exists()) {
            return response()->json(['message' => 'Produto não encontrado'], 404);
        }

        // Chama o serviço para remover o produto do carrinho
        $this->cartService->removeFromCart($product_id);

        return response()->json(['message' => 'Produto removido do carrinho']);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function syncSessionCart()
    {
        $cart = $this->cartService->getOrCreateCart();
        $this->cartService->syncSessionCart($cart);
        return response()->json(['message' => 'Carrinho sincronizado']);
    }

    /**
     * Undocumented function
     *
     * @param StoreUpdateCartRequest $request
     * @return void
     */
    public function checkout(StoreUpdateCartRequest $request)
    {
        // Recebe a resposta do serviço
        $result = $this->cartService->checkout(CreateNewSaleDTO::makeFromRequest($request));

        // Retorna a resposta em JSON
        return response()->json($result);

    }
}
