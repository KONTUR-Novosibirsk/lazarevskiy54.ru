<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Reviews\App\Models\Review;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<Review>
 */
class ReviewFactory extends Factory
{
    protected $model = Review::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'status' => 1,
            'job_title' => $this->faker->jobTitle,
            'text' => $this->faker->realText(250),
        ];
    }
}
