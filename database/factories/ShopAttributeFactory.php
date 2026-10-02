<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Shop\App\Models\ShopAttribute;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class ShopAttributeFactory extends Factory
{
    protected $model = ShopAttribute::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dictionaries = [
            'color' => ['Красный', 'Синий', 'Желтый', 'Черный'],
            'sizes' => [100, 200, 300, 400, 500, 600],
            'shape' => ["Круглый", "Квадратный", "Треугольный"]
        ];

        $name = [
            'color' => ["Цвет"],
            'sizes' => ["Вес", "Объем", "Ширина", "Высота", "Длина"],
            'shape' => ["Форма"]
        ];

        $f = fake();

        $attr = $f->randomElement(['color', 'sizes', 'shape']);

        return [
            'name' => $f->randomElement($name[$attr]),
            'type' => $f->randomElement([]),
            'dictionary' => implode(',', $f->randomElements($dictionaries[$attr], $f->random_int(1, 4))),
        ];
    }
}
