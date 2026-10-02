<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Reviews\App\Models\Review;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Review::factory()->count(500)->create();
    }
}
