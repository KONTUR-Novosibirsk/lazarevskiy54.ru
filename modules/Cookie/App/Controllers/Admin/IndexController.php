<?php

namespace Modules\Cookie\App\Controllers\Admin;

use Galtsevt\LaravelSeo\App\Facades\Seo;
use Modules\Cookie\App\Models\CookieConsent;

class IndexController extends \App\Http\Controllers\Controller
{
    public function __construct()
    {
        Seo::breadcrumbs()->add(settings('name', 'cookie', 'Куки'), route('admin.cookie.index'));
    }

    public function index(): \Inertia\Response
    {
        Seo::metaData()->setTitle(settings('name', 'cookie', 'Куки'));

        $accountCookie = CookieConsent::query()->orderBy('id', 'desc')
            ->with('account')->get();

        return inertia('Modules/Cookie/Index', [
            'accountCookie' => $accountCookie
        ]);
    }

}
