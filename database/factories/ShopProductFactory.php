<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Shop\App\Models\ShopProduct;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Shop\App\Models\ShopProduct>
 */
class ShopProductFactory extends Factory
{
    protected $model = ShopProduct::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->realText(12);
        return [
            'title' => $title,
            'alias' => Str::slug($title) . rand(1,100000),
            'price' => fake()->numberBetween(100, 10000),
            'old_price' => fake()->numberBetween(0, 10000),
            'active' => fake()->randomElement([true, false]),
            'category_id' => null,
            'is_new' => fake()->randomElement([true, false]),
            'hit' => fake()->randomElement([true, false]),
            'show_on_index_page' => fake()->randomElement([true, false]),
            'show_on_shop_index_page' => fake()->randomElement([true, false]),
            'vendor_code' => uniqid(fake()->numberBetween(100, 10000)),
            'description' => fake()->text(255)
        ];
    }
}
