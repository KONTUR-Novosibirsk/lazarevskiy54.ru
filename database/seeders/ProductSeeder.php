<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Shop\App\Models\ShopCategory;
use Modules\Shop\App\Models\ShopProduct;

class ProductSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ids = ShopCategory::all()->pluck('id');

        ShopProduct::factory(200)
            ->state([
                'category_id' => fn() => fake()->randomElement($ids),
            ])->create();
    }
}
