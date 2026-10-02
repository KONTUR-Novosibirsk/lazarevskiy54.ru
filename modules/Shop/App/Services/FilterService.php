<?php

namespace Modules\Shop\App\Services;

use Modules\Shop\App\Models\ShopFilter;
use Modules\Shop\App\Models\ShopFilterAttribute;

class FilterService
{
    public function store(array $data): ShopFilter
    {
        $shopFilter = new ShopFilter($data);
        $shopFilter->save();
        $this->syncAttributes($data, $shopFilter);
        return $shopFilter;
    }

    public function update(array $data, ShopFilter $shopFilter): ShopFilter
    {
        $shopFilter->update($data);
        $this->syncAttributes($data, $shopFilter);
        $shopFilter->load('shopAttributes');
        return $shopFilter;
    }

    public function syncAttributes(array $data, ShopFilter $shopFilter): void
    {
        $shopFilter->shopAttributes()->delete();
        if (isset($data['attributes'])) {
            $sort = 1;
            foreach ($data['attributes'] as $attribute) {
                $attribute['sort'] = $sort;
                $models[] = new ShopFilterAttribute($attribute);
                $sort++;
            }
            $shopFilter->shopAttributes()->saveMany($models ?? []);
        }
    }
}
