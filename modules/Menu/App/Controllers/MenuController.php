<?php

namespace Modules\Menu\App\Controllers;

use App\Http\Controllers\Controller;
use Galtsevt\LaravelSeo\App\Facades\Seo;
use Modules\Menu\App\Resources\MenuItemResource;
use Modules\Menu\App\Services\MenuService;
use Modules\Menu\App\Models\MenuCategory;
use Modules\Menu\App\Models\MenuItem;
use Modules\Menu\App\Requests\StoreLinkMenuRequest;
use Modules\Menu\App\Requests\UpdateLinkMenuRequest;
use Modules\Menu\App\Requests\UpdateMenuItemsRequest;

class MenuController extends Controller
{
    public function __construct()
    {
        Seo::breadcrumbs()->add('Меню', route('admin.menuBuilder.index'));
    }

    public function storeLink(StoreLinkMenuRequest $request): MenuItemResource
    {
        $menuItem = new MenuItem($request->validated());
        $menuItem->makeRoot();
        $menuItem->save();
        return new MenuItemResource($menuItem);
    }

    public function updateLink(UpdateLinkMenuRequest $request, MenuItem $menuItem): MenuItemResource
    {
        $data = $request->validated();
        $menuItem->update($data);
        return new MenuItemResource($menuItem);
    }

    public function updateMenuItems(
        UpdateMenuItemsRequest $request,
        MenuCategory           $menuCategory,
        MenuService            $menuService
    ): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return $menuService->updateMenuItemsInCategory($request, $menuCategory);
    }

    public function destroy(MenuItem $menuItem): ?bool
    {
        return $menuItem->delete();
    }
}
