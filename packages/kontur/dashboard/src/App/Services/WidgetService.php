<?php

namespace Kontur\Dashboard\App\Services;

use Kontur\Dashboard\App\Facades\Modules;
use Kontur\Dashboard\App\Requests\UpdateWidgets;
use Kontur\Dashboard\App\Resources\WidgetResource;

class WidgetService
{
    public function getSortedWidget(bool $active = false): array
    {
        $widgets = Modules::getWidgets($active);
        uasort($widgets, function ($a, $b) {
            return $a->getSort() <=> $b->getSort();
        });
        return $widgets;
    }

    public function update(UpdateWidgets $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $data = $request->validated();
        $sort = 1;
        $resultConfig = [];
        foreach ($data['widgets'] as $widget) {
            $resultConfig[$widget['id']] = [
                'active' => $widget['active'],
                'size' => $widget['size'],
                'sort' => $sort,
            ];
            $sort++;
        }
        $configManager = new ConfigManager();
        $configManager->store('widgets', $resultConfig);
        return WidgetResource::collection($this->getSortedWidget());
    }
}
