<?php

namespace Tests\Feature\Shop;

use App\Models\User;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    public function test_index_page(): void
    {
        $user = User::factory()->admin()->create();
        $response = $this->withoutMiddleware('module')->actingAs($user)->get(route('admin.shop.index'));
        $response->assertStatus(200);
    }

    public function test_attribute_page(): void
    {
        $user = User::factory()->admin()->create();
        $response = $this->withoutMiddleware('module')->actingAs($user)->get(route('admin.shop.attribute.index'));
        $response->assertStatus(200);
    }

    public function test_create(): void
    {
        $user = User::factory()->admin()->create();
        $response = $this->withoutMiddleware('module')->actingAs($user)->get(route('admin.shop.category.create'));
        $response->assertStatus(200);
    }
}
