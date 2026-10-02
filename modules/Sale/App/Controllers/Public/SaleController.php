<?php

namespace Modules\Sale\App\Controllers\Public;

use Galtsevt\LaravelSeo\App\Facades\Seo;
use Modules\Sale\App\Models\Sale;

class SaleController extends \App\Http\Controllers\Controller
{
    public function __construct()
    {
        Seo::breadcrumbs()->add(settings('name', 'sale', 'Акции'), route('sale.index'));
    }

    public function index(): \Illuminate\Http\Response
    {
        Seo::metaData()->setTitle(settings('name', 'sale', 'Акции'));

        return response()->view('sale::index', [
            'items' => Sale::query()->orderBy('sort')->paginate(settings('per_page', default: 10)),
        ]);
    }

    public function show(string $alias): \Illuminate\Http\Response
    {
        $sale = Sale::query()->active()->where('alias', $alias)->firstOrFail();

        Seo::breadcrumbs()->add($sale->title);
        Seo::metaData()->prepare($sale)->setTitle($sale->title);

        return response()->view('sale::show', [
            'sale' => $sale,
        ]);
    }
}
