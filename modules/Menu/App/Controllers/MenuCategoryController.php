<?php

namespace Modules\Menu\App\Controllers;

use Galtsevt\LaravelSeo\App\Facades\Seo;
use Modules\Menu\App\Facades\MenuBuilder;
use Modules\Menu\App\Models\MenuCategory;
use Modules\Menu\App\Requests\StoreMenuCategoryRequest;
use Modules\Menu\App\Resources\MenuCategoryResource;
use Modules\Menu\App\Resources\MenuContainerResource;
use Modules\Menu\App\Resources\MenuItemResource;

class MenuCategoryController
{
    public function __construct()
    {
        Seo::breadcrumbs()->add('Меню', route('admin.menuBuilder.index'));
    }

    public function index(): \Inertia\Response
    {
        Seo::metaData()->setTitle('Конструктор меню');

        return inertia('Modules/Menu/Index', [
            'categories' => MenuCategory::query()->get(),
        ]);
    }

    public function show(MenuCategory $menuCategory): \Inertia\Response
    {
        Seo::metaData()->setTitle('Меню ' . $menuCategory->name);
        Seo::breadcrumbs()->add($menuCategory->name, route('admin.menu.show', $menuCategory->id));
        return inertia('Modules/Menu/EditMenu', [
            'templateItems' => MenuContainerResource::collection(
                MenuBuilder::deleteExistItems($menuCategory->menuItems)->getContainers()
            ),
            'nestedItems' => MenuItemResource::collection($menuCategory->menuItems->sortBy('sort')->toTree()),
            'category' => $menuCategory,
        ]);
    }

    public function store(StoreMenuCategoryRequest $request): MenuCategoryResource
    {
        $data = $request->validated();
        $menuCategory = new MenuCategory($data);
        $menuCategory->save();
        return new MenuCategoryResource($menuCategory);
    }

    public function update(StoreMenuCategoryRequest $request, MenuCategory $menuCategory): MenuCategoryResource
    {
        $data = $request->validated();
        $menuCategory->update($data);
        return new MenuCategoryResource($menuCategory);
    }

    public function destroy(MenuCategory $menuCategory): bool
    {
        $menuCategory->delete();
        return true;
    }
}
