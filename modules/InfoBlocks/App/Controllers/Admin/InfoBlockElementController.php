<?php

namespace Modules\InfoBlocks\App\Controllers\Admin;

use App\Http\Controllers\Controller;
use Galtsevt\LaravelSeo\App\Facades\Seo;
use Modules\InfoBlocks\App\Models\{InfoBlock, InfoBlockElement};
use Modules\InfoBlocks\App\Requests\Element\{SortRequest, StoreRequest, UpdateRequest};
use Modules\InfoBlocks\App\Resources\{InfoBlockElementResource, InfoBlockResource};
use Modules\InfoBlocks\App\Services\InfoBlockElementService;

class InfoBlockElementController extends Controller
{
    public function __construct()
    {
        Seo::breadcrumbs()->add('Инфо-блоки', route('admin.iblock.index'));
    }

    public function index(InfoBlock $infoBlock): \Inertia\Response
    {
        Seo::metaData()->setTitle($infoBlock->title);
        if ($infoBlock->category) {
            Seo::breadcrumbs()->add($infoBlock->category->name, route('admin.iblock.category.show', $infoBlock->category->id));
        }
        Seo::breadcrumbs()->add($infoBlock->title, route('admin.iblock.element.index', $infoBlock->id));
        return inertia('Modules/IBlock/Element/Index', [
            'elements' => InfoBlockElementResource::collection($infoBlock->elements()->get()),
            'infoBlock' => new InfoBlockResource($infoBlock),
        ]);
    }

    public function create(InfoBlock $infoBlock): \Inertia\Response
    {
        Seo::breadcrumbs()->addList([
            route('admin.iblock.element.index', $infoBlock->id) => $infoBlock->title,
            route('admin.iblock.element.create', $infoBlock->id) => 'Создать',
        ]);
        Seo::metaData()->setTitle('Инфо-Блоки');
        return inertia('Modules/IBlock/Element/Edit', [
            'infoBlock' => new InfoBlockResource($infoBlock),
            'model' => InfoBlockElement::class,
        ]);
    }

    public function store(
        StoreRequest            $request,
        InfoBlock               $infoBlock,
        InfoBlockElementService $service
    ): InfoBlockElementResource
    {
        return new InfoBlockElementResource($service->store($request, $infoBlock));
    }

    public function edit(InfoBlockElement $infoBlockElement): \Inertia\Response
    {
        Seo::breadcrumbs()->addList([
            route('admin.iblock.element.index', $infoBlockElement->parent->id) => $infoBlockElement->parent->title,
            route('admin.iblock.element.edit', $infoBlockElement->id) => 'Изменить',
        ]);

        Seo::metaData()->setTitle('Изменение - ' . $infoBlockElement->title);
        return inertia('Modules/IBlock/Element/Edit', [
            'infoBlockElement' => new InfoBlockElementResource($infoBlockElement),
            'infoBlock' => new InfoBlockResource($infoBlockElement->parent),
            'model' => InfoBlockElement::class,
        ]);
    }

    public function update(
        InfoBlockElement        $infoBlockElement,
        UpdateRequest           $request,
        InfoBlockElementService $service
    ): InfoBlockElementResource
    {
        return new InfoBlockElementResource($service->update($request, $infoBlockElement));
    }

    public function sort(SortRequest $request, InfoBlockElementService $infoBlockElementService,): bool
    {
        return $infoBlockElementService->sort($request);
    }

    public function destroy(InfoBlockElement $infoBlockElement): \Illuminate\Http\RedirectResponse
    {
        $infoBlockElement->delete();
        return redirect()->back()->with('success', 'Запись успешно удалена');
    }
}
