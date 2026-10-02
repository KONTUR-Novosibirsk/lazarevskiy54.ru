<?php

namespace Modules\Services\App\Http\Public\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Modules\Services\App\Models\Service;

final class HomepageServices extends Component
{
    public function __construct() {}

    public function render(): View
    {
        $perPage        = settings('component_per_page', 'services', 10);
        $sortColumn     = settings('component_order_by', 'services', 'created_at');
        $sortDirection  = settings('component_order_direction', 'services', 'desc');

        $services = Service::query()
            ->with(['images', 'ancestors'])
            ->childrenOf()
            ->active()
            ->featured()
            ->sortBy($sortColumn, $sortDirection)
            ->paginate($perPage)
            ->withQueryString();

        $template = 'services::components.homepage.' .
            settings('component_template', 'services', 'list');

        return view($template, [
            'services'  => $services,
            'title'     => settings('component_title', 'services', 'Услуги'),
            'content'   => settings('component_content', 'services', ''),
            'depth'     => settings('component_depth', 'services', '1')
        ]);
    }
}
