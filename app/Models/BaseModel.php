<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use function PHPUnit\Framework\exactly;

class BaseModel extends Model
{
    public function scopeSort(Builder $query, $data)
    {
        return $query->when(
            isset($data['order_by']) && isset($data['order_direction']),
            function (Builder $query) use ($data) {
                $orderBy = explode('.', $data['order_by']);
                if (count($orderBy) > 1) {
                    $query->withAggregate($orderBy[0], $orderBy[1]);
                    $data['order_by'] = implode('_', $orderBy);
                }
                return $query->orderBy($data['order_by'], $data['order_direction']);
            }
        );
    }
}
