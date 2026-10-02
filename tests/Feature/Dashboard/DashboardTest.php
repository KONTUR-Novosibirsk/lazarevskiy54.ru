<?php

namespace Tests\Feature\Dashboard;

use App\Models\User;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    public function test_index_page(): void
    {
        $user = User::factory()->admin()->create();
        $response = $this->actingAs($user)->get(route('admin.index'));
        $response->assertStatus(200);
    }

    public function test_modules_page(): void
    {
        $user = User::factory()->admin()->create();
        $response = $this->actingAs($user)->get(route('admin.modules'));
        $response->assertStatus(200);
    }
}
