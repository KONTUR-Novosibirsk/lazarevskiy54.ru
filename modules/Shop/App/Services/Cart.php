<?php

namespace Modules\Shop\App\Services;

use Exception;
use Modules\Shop\App\Contracts\CartableContract;
use Modules\Shop\App\Contracts\CartContract;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Modules\Shop\App\Models\ShopProduct;

class Cart implements CartContract
{
    protected Session $session;

    protected $content;

    public function __construct(
        Request $request
    )
    {
        $this->session = $request->session();
    }

    public function add(CartableContract $item, int $count = 1)
    {
        $hash = $item->hashToCart();


        if ($this->has($hash)) {
            $this->increaseRowCount($hash, $count);
        } else {
            $this->addRow($item, $count);
        }

        $this->save();

        return $this->getItem($hash);

    }

    public function remove(string $hash, $count = 1): bool|array
    {
        try {
            if ($this->has($hash)) {
                $cart = $this->getContent();

                if ($cart['items'][$hash]['count'] <= $count) {
                    $this->removeRow($hash);
                } else {
                    $this->decreaseRowCount($hash, $count);

                    // если нужно получить обьект после изменения количества
                    // $this->save();
                    // return $this->getItem($hash);
                }

                $this->save();
            }

            return true;
        } catch (\Throwable $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    protected function addRow(CartableContract $item, $count)
    {
        $cart = $this->getContent();

        $hash = $item->hashToCart();

        $cart['items'][$hash] = $item->cartAttributes();
        $cart['items'][$hash]['count'] = $count;

        $this->setContent($cart);
    }

    protected function removeRow($hash)
    {
        $cart = $this->getContent();

        unset($cart['items'][$hash]);

        $this->setContent($cart);
    }

    protected function updateRow($hash, $count)
    {
        $cart = $this->getContent();

        $cart['items'][$hash]['count'] += $count;

        $this->setContent($cart);
    }

    protected function increaseRowCount($hash, $count)
    {
        $this->updateRow($hash, $count);
    }

    protected function decreaseRowCount($hash, $count)
    {
        $this->updateRow($hash, -$count);
    }

    protected function getContent()
    {
        if (empty($this->content)) {
            $this->content = $this->session->get('cart');
        }

        return $this->content;
    }

    protected function setContent($cart)
    {
        $this->content = $cart;

        $this->updateTotalCount();
    }

    protected function updateTotalCount()
    {
        $this->content['totalCount'] = $this->totalCount();
    }

    protected function has($hash): bool|string
    {
        $cart = $this->getContent();

        if (array_key_exists($hash, $cart['items'])) {
            return $hash;
        }

        return false;
    }

    /**
     * Save new data in session cart
     */
    protected function save()
    {
        session()->put('cart', $this->content);
    }

    public function getItem($hash): array
    {
        $cart = $this->getContent();

        return $cart['items'][$hash];
    }

    public function flush(): bool
    {
        try {
            $this->content = [
                'totalCount' => 0,
                'items' => []
            ];

            $this->save();

            return true;
        } catch (\Throwable $e) {

            return false;
        }
    }

    protected function totalCount()
    {
        $cart = $this->getContent();

        $i = 0;
        foreach ($cart['items'] as $item) {
            $i += $item['count'];
        }

        return $i;
    }

    public static function count(): int
    {
        return session()->get('cart')['totalCount'];
    }

    public static function amount(): float
    {
        $amount = 0.00;

        foreach (session()->get('cart')['items'] as $item) {
            $amount += ($item['price'] * $item['count']);
        }

        return $amount;
    }

    public function getItemsFromDb()
    {
        $cart = $this->getContent();

        $products = ShopProduct::query()->whereIn('id', collect($cart['items'])->pluck('id'))->where([
            ['price', '>', 0],
            ['active', 1],
        ])->orderBy('sort')->get();

        foreach ($cart['items'] as $key => $item) {
            if ($product = $products->where('id', $item['id'])->first()) {
                $product->count = $item['count'];
                $product->hash = $key;
            }
        }

        $totalPrice = 0;
        $totalOldPrice = 0;
        $products->map(function ($item) use (&$totalOldPrice, &$totalPrice) {
            $totalOldPrice += max($item->price, $item->old_price) * $item->count;
            $totalPrice += $item->price * $item->count;
        });

        return [
            'products' => $products,
            'totalPrice' => $totalPrice,
            'totalOldPrice' => $totalOldPrice,
            'sale' => $totalOldPrice - $totalPrice
        ];
    }
}
