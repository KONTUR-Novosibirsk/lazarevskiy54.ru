<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Shop\App\Models\ShopCategory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Shop\App\Models\ShopCategory>
 */
class ShopCategoryFactory extends Factory
{
    protected $model = ShopCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->words(3, true);

        return [
            'title' => $title,
            'alias' => Str::slug($title),
            'description' => fake()->text(255),
        ];
    }
}
