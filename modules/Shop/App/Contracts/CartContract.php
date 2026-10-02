<?php

namespace Modules\Shop\App\Contracts;

interface CartContract
{
    /**
     * Add object to cart
     *
     * @param CartableContract $item object to be added to the cart
     * @return bool
     */
    public function add(CartableContract $item, int $count = 1);

    /**
     * Get item from cart
     *
     * @param $hash object hash
     * @return array
     */
    public function getItem($hash): array;

    /**
     * Remove item from cart
     *
     * @param $hash object hash
     * @return bool|array
     */
    public function remove(string $hash, $count = 1): bool|array;

    /**
     * Clear cart
     *
     * @return bool
     */
    public function flush(): bool;

    /**
     * Sum of prices in cart
     *
     * @return int
     */
    public static function amount(): float;

    /**
     * Sum of items in cart
     *
     * @return int
     */
    public static function count(): int;
}
