<?php

namespace Modules\Shop\App\Services;

use Kontur\Dashboard\App\Modules\Header\HeaderItemInterface;
use Modules\Shop\App\Models\ShopOrder;

class ShopOrdersHeaderItem implements HeaderItemInterface
{

    public function getName(): string
    {
        return 'ShopOrders';
    }

    public function getData(): array
    {
        return [
            'count' => ShopOrder::query()->where('status', 0)->count(),
        ];
    }
}
