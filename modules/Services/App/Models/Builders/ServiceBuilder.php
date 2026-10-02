<?php

namespace Modules\Services\App\Models\Builders;

use Kalnoy\Nestedset\QueryBuilder;
use Modules\Services\App\Models\Service;

final class ServiceBuilder extends QueryBuilder
{
    public function active(): self
    {
        return $this->where('is_active', true);
    }

    public function featured(): self
    {
        return $this->where('is_featured', true);
    }

    public function whenActive(?bool $active = null): self
    {
        return $this->when($active !== null, fn($q) => $q->active());
    }

    public function searchByName(?string $term): self
    {
        return $this->when($term, fn($q) => $q->where('name', 'like', "%{$term}%"));
    }

    public function childrenOf(?Service $service = null): self
    {
        return $service ? $this->where('parent_id', $service->id) : $this->whereNull('parent_id');
    }

    public function sortBy(string $column, string $order = 'asc'): self
    {
        return $this->orderBy('sort_order', $order)->orderBy($column, $order);
    }
}
