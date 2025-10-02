<?php

namespace App\Listeners;

use App\Models\CartItem;
use App\Services\CartService;
use Illuminate\Auth\Events\Login;


class MergeGuestCartListener
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {

        $this->cartService->mergeGuestCart();

    }
}
