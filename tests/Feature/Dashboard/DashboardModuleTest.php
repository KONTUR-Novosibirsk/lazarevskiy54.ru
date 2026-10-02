<?php

namespace Tests\Feature\Dashboard;

use Kontur\Dashboard\App\Modules\Module;
use Tests\TestCase;

class DashboardModuleTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_is_active_module(): void
    {
        $module = new Module(
            id: 'test',
            name: 'test',
        );

        $this->assertSame(false, $module->isActive());
    }

    public function test_get_name(): void
    {
        $module = new Module(
            id: 'test',
            name: 'test',
        );

        $this->assertSame('test', $module->getName());
    }

    public function test_get_id(): void
    {
        $module = new Module(
            id: 'test',
            name: 'test',
        );

        $this->assertSame('test', $module->getId());
    }
}
