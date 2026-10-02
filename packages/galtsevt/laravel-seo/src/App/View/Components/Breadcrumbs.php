<?php

namespace Galtsevt\LaravelSeo\App\View\Components;

use Closure;
use Galtsevt\LaravelSeo\App\Facades\Seo;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Breadcrumbs extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('laravel-seo::components.breadcrumbs', [
            'breadcrumbs' => Seo::breadcrumbs()->getAll(),
        ]);
    }
}
