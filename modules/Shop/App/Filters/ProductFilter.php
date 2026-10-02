<?php

namespace Modules\Shop\App\Filters;

use Modules\Shop\App\Contracts\ProductFilterContract;

class ProductFilter extends QueryFilter implements ProductFilterContract
{
    public function price($price = null)
    {
        return $this->builder->when(isset($price['min']) && is_numeric($price['min']), function ($query) use ($price) {
            return $query->where('price', '>=', $price['min']);
        })->when(isset($price['max']) && is_numeric($price['max']), function ($query) use ($price) {
            return $query->where('price', '<=', $price['max']);
        });
    }

    public function filterData($filter = null)
    {
        foreach ($filter as $attributeID => $values) {
            $this->builder->whereRelation('attributesValue', function ($query) use ($attributeID, $values) {
                return $query->whereIn('value', $values)->where('attribute_id', $attributeID);
            });
        }
    }

    public function sort($sort = null)
    {
        return $this->builder->orderBy($sort['column'], $sort['direction'] == 'desc' ? 'DESC' : 'ASC');
    }

    public static function getSortAttributes(): array
    {
        return [
            'price' => 'Цене',
            'title' => 'Названию',
        ];
    }
}
