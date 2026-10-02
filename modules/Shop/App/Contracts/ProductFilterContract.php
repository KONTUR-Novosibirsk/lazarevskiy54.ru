<?php

namespace Modules\Shop\App\Contracts;

interface ProductFilterContract
{
    public function price($price = null);

    public function filterData($filter = null);

    public function sort($sort = null);

    public static function getSortAttributes(): array;
}
