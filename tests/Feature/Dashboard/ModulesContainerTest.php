<?php

namespace Tests\Feature\Dashboard;

use Kontur\Dashboard\App\Modules\Module;
use Kontur\Dashboard\App\Modules\ModulesContainer;
use Tests\TestCase;

class ModulesContainerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_create_module(): Module
    {
        $module = new Module(
            id: 'test',
            name: 'Test',
        );
        $this->assertSame('test', $module->getId());
        return $module;
    }

    public function test_register_module(): void
    {
        $module = new Module(
            id: 'test',
            name: 'Test',
        );
        $modulesContainer = new ModulesContainer();
        $modulesContainer->register($module);
        $this->assertSame([
            'test' => $module
        ], $modulesContainer->getAllModules());
    }

    public function test_active_modules(): void
    {
        $module = new Module(
            id: 'test',
            name: 'Test',
        );
        $modulesContainer = new ModulesContainer();
        $modulesContainer->register($module);
        $this->assertSame([], $modulesContainer->getActiveModules());
    }

    public function test_get_header_items()
    {
        $module = new Module(
            id: 'test',
            name: 'Test',
        );
        $modulesContainer = new ModulesContainer();
        $modulesContainer->register($module);
        $this->assertSame([], $modulesContainer->getHeaderItems());
    }

    public function test_get_sidebar_items()
    {
        $module = new Module(
            id: 'test',
            name: 'Test',
        );
        $modulesContainer = new ModulesContainer();
        $modulesContainer->register($module);
        $this->assertSame([], $modulesContainer->getSidebarItems());
    }
}
