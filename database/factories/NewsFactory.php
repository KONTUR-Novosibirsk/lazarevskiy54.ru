<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\News\App\Models\News;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<News>
 */
class NewsFactory extends Factory
{
    protected $model = News::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $title = $this->faker->realText(23),
            'alias' => Str::slug($title),
            'active' => random_int(0, 1),
            'publication_date' => Carbon::now(),
            'text' => $this->faker->text(1000),
        ];
    }

/*    public function configure(): static
    {
        return $this->afterCreating(function (News $news) {
            $image = new Image();
            $image->loadImage($this->faker->imageUrl(1024,768,'animals'), $news)->group('preview');
            $image->save();
        });
    }*/
}
