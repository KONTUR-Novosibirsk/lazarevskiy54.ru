<?php

namespace Modules\Questions\App\Providers;

use Kontur\Dashboard\App\Facades\Modules;
use Kontur\Dashboard\App\Modules\Menu\MenuItem;
use Kontur\Dashboard\App\Modules\Module;
use Kontur\Dashboard\App\Modules\ModuleProvider;
use Modules\Menu\App\Facades\MenuBuilder;

class QuestionModuleProvider extends ModuleProvider
{
    protected string $name = 'question';

    protected function init(): void
    {

    }

    protected function run(): void
    {
        if ($this->module->isActive()) {
            MenuBuilder::add([
                new \Modules\Menu\App\Models\MenuItem([
                    'name' => 'Вопрос-ответ',
                    'route_name' => 'question.index',
                ])
            ], 'Модули');
        }
    }

    protected function getModule(): Module
    {
        return new Module(
            id: 'questions',
            name: 'Вопрос-Ответ',
            sidebarItems: [
                new MenuItem(
                    name: 'Вопрос-ответ',
                    routeName: 'admin.question.index',
                    icon: '<i class="bi bi-question-octagon-fill"></i>',
                )
            ],
        );
    }

    protected function getDir(): string
    {
        return __DIR__;
    }
}
