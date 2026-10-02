<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Modules\Feedback\App\Models\Feedback;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<Feedback>
 */
class FeedbackFactory extends Factory
{
    protected $model = Feedback::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'callback',
            'status' => 0,
            'data' => [
                'name' => $this->faker->name,
                'phone' => $this->faker->phoneNumber,
                'policy' => 1,
            ],
            'created_at' => Carbon::today()->subDays(rand(0, 30))
        ];
    }
}
