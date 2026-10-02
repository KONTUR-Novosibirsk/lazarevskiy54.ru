<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Gallery\App\Models\GalleryImage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<GalleryImage>
 */
class GalleryImageFactory extends Factory
{
    protected $model = GalleryImage::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(2, true),
            'text' => fake()->text(1000),
        ];
    }

}
