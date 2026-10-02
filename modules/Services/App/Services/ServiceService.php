<?php

namespace Modules\Services\App\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Kontur\Dashboard\App\DTO\Filter;
use Modules\Services\App\Models\Service;

final readonly class ServiceService
{
    public function getChildren(?Service $service = null, ?Filter $filter = null): LengthAwarePaginator
    {
        $filter = $filter ?? Filter::make([
            'perPage'    => settings('per_page', 'services', 10),
            'sortColumn' => settings('order_by', 'services', 'created_at'),
            'sortOrder'  => settings('order_direction', 'services', 'desc'),
        ]);

        return Service::query()
            ->with(['images', 'ancestors'])
            ->childrenOf($service)
            ->whenActive($filter->isActive)
            ->searchByName($filter->searchTerm)
            ->sortBy($filter->sortColumn, $filter->sortOrder)
            ->paginate($filter->perPage)
            ->withQueryString();
    }

    public function getByAlias(string $alias): Service
    {
        /** @var Service $service */
        $service = Service::query()
            ->with(['images', 'seo', 'ancestors'])
            ->active()
            ->where('alias', $alias)
            ->firstOrFail();

        return $service;
    }

    public function getById(int $id): Service
    {
        /** @var Service $service */
        $service = Service::query()
            ->with(['images', 'seo', 'ancestors'])
            ->findOrFail($id);

        return $service;
    }

    public function getAvailableParentsFor(?Service $service = null): Collection
    {
        $query = Service::query()->select('id', 'name');

        if ($service) {
            $query->whereNotDescendantOf($service)->where('id', '!=', $service->id);
        }

        return $query->get();
    }
}
