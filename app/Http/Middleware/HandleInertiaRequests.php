<?php

namespace App\Http\Middleware;

use Galtsevt\AppConf\app\Models\Setting;
use Galtsevt\LaravelSeo\App\Facades\Seo;
use Galtsevt\LaravelSeo\App\Resources\BreadcrumbItemResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Inertia\Middleware;
use Kontur\Dashboard\App\Facades\Modules;
use Kontur\Dashboard\App\Resources\HeaderItemResource;
use Kontur\Dashboard\App\Resources\SidebarItemResource;
use Modules\Notification\App\Services\NotificationHeaderItem;
use Modules\Shop\App\Services\ShopOrdersHeaderItem;
use Tighten\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'admin.app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param Request $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param Request $request
     * @return array
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'laravel_version' => \Illuminate\Foundation\Application::VERSION,
            'php_version' => PHP_VERSION,
            'auth' => [
                'user' => $request->user(),
                'isDevAdmin' => auth()->check() ? auth()->user()->isDevAdmin() : false,
            ],
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
            'settings' => fn() => Setting::getAll(),
            'seo' => [
                'title' => fn() => Seo::metaData()->getTitle(),
                'breadcrumbs' => fn() => BreadcrumbItemResource::collection(Seo::breadcrumbs()->getAll()),
            ],
            'sidebar_items' => fn() => SidebarItemResource::collection(Modules::getSidebarItems()),
            'session_messages' => [
                'success' => fn() => Session::get('success', null),
                'error' => fn() => Session::get('error', null),
            ],
            'header_items' => function () {
                Modules::get('notification')->setHeaderItems([new NotificationHeaderItem()]);
                Modules::get('shop')->setHeaderItems([new ShopOrdersHeaderItem()]);
                return HeaderItemResource::collection(Modules::getHeaderItems());
            },
        ]);
    }
}
