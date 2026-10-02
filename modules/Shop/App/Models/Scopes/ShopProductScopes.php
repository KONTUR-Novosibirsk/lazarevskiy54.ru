<?php

namespace Modules\Shop\App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Modules\Shop\App\Filters\QueryFilter;

trait ShopProductScopes
{
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('title', 'like', '%' . $search . '%');
        })->when(isset($filters['active']) && in_array($filters['active'], [0, 1]), function ($query, $active) use ($filters) {
            $query->where('active', '=', $filters['active']);
        });
    }

    public function scopePublicFilter(Builder $builder, QueryFilter $filter): Builder
    {
        return $filter->apply($builder);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', '=', 1);
    }

    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        return $query->when($search, fn(Builder $query) => $query->whereFullText(['title', 'description'], $search));
    }
}
