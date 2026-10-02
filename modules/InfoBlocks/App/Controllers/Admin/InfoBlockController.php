<?php

namespace Modules\InfoBlocks\App\Controllers\Admin;

use App\Http\Controllers\Controller;
use Kontur\Dashboard\App\Facades\Template;
use Modules\InfoBlocks\App\Models\InfoBlockCategory;
use Modules\InfoBlocks\App\Requests\StoreRequest;
use Modules\InfoBlocks\App\Requests\UpdateBlockUserRequest;
use Modules\InfoBlocks\App\Requests\UpdateRequest;
use Galtsevt\LaravelSeo\App\Facades\Seo;
use Illuminate\Http\Request;
use Modules\InfoBlocks\App\Models\InfoBlock;
use Modules\InfoBlocks\App\Resources\InfoBlockCategoryResource;
use Modules\InfoBlocks\App\Resources\InfoBlockResource;

class InfoBlockController extends Controller
{
    public function __construct()
    {
        Seo::breadcrumbs()->add('Инфо-блоки', route('admin.iblock.index'));
    }

    public function index(): \Inertia\Response
    {
        Seo::metaData()->setTitle('Инфо-Блоки');
        return inertia('Modules/IBlock/Index', [
            'infoBlocks' => InfoBlockResource::collection(
                InfoBlock::query()->whereNull('category_id')->orderBy('id', 'DESC')->get()
            ),
            'categories' => InfoBlockCategoryResource::collection(
                InfoBlockCategory::query()->orderBy('id', 'DESC')->get()
            )
        ]);
    }

    public function store(StoreRequest $request): InfoBlockResource
    {
        $data = $request->validated();
        $infoBlock = InfoBlock::query()->create($data);
        return new InfoBlockResource($infoBlock);
    }

    public function update(InfoBlock $infoBlock, UpdateRequest $request): InfoBlockResource
    {
        $data = $request->validated();
        $data['props'] = $data['props'] ?? null;
        $data['category_id'] = $data['category_id'] ?? null;
        $infoBlock->update($data);
        return new InfoBlockResource($infoBlock);
    }

    public function updateForUser(InfoBlock $infoBlock, UpdateBlockUserRequest $request): InfoBlockResource
    {
        $data = $request->validated();
        $infoBlock->update($data);
        return new InfoBlockResource($infoBlock);
    }

    public function destroy(InfoBlock $infoBlock): ?bool
    {
        foreach ($infoBlock->elements as $element) {
            $element->delete();
        }

        return $infoBlock->delete();
    }
}
