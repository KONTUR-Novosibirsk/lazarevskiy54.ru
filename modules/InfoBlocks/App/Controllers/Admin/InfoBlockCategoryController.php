<?php

namespace Modules\InfoBlocks\App\Controllers\Admin;

use Galtsevt\LaravelSeo\App\Facades\Seo;
use Modules\InfoBlocks\App\Models\InfoBlockCategory;
use Modules\InfoBlocks\App\Requests\Category\{StoreRequest, UpdateRequest};
use Modules\InfoBlocks\App\Resources\{InfoBlockCategoryResource, InfoBlockResource};

class InfoBlockCategoryController extends \App\Http\Controllers\Controller
{
    public function __construct()
    {
        Seo::breadcrumbs()->add('Инфо-Блоки', route('admin.iblock.index'));
    }

    public function show(InfoBlockCategory $infoBlockCategory): \Inertia\Response
    {
        Seo::metaData()->setTitle($infoBlockCategory->name);
        Seo::breadcrumbs()->add($infoBlockCategory->name, route('admin.iblock.category.show', $infoBlockCategory->id));

        return inertia('Modules/IBlock/Category/Show', [
            'category' => new InfoBlockCategoryResource($infoBlockCategory),
            'categories' => InfoBlockCategoryResource::collection(InfoBlockCategory::all()),
            'infoBlocks' => InfoBlockResource::collection($infoBlockCategory->infoBlocks),
        ]);
    }

    public function store(StoreRequest $request): InfoBlockCategoryResource
    {
        $data = $request->validated();
        $category = new InfoBlockCategory($data);
        $category->save();
        return new InfoBlockCategoryResource($category);
    }

    public function update(UpdateRequest $request, InfoBlockCategory $category): InfoBlockCategoryResource
    {
        $data = $request->validated();
        $category->update($data);
        return new InfoBlockCategoryResource($category);
    }

    public function destroy(InfoBlockCategory $category): \Illuminate\Http\JsonResponse
    {
        foreach ($category->infoBlocks as $infoBlock) {
            if ($infoBlock->elements) {
                foreach ($infoBlock->elements as $element) {
                    $element->delete();
                }
            }
            $infoBlock->delete();
        }
        $category->delete();
        return response()->json(true);
    }
}
