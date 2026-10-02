<?php

namespace Modules\Shop\App\Contracts;

interface CartableContract
{
    /**
     * Hash logic for cart item with different prices
     */
    public function hashToCart(): string|false;

    /**
     * Attributes whats need to put in cart session
     */
    public function cartAttributes(): array;
}
