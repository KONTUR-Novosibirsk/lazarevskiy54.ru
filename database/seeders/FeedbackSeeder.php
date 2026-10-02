<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Feedback\App\Models\Feedback;

class FeedbackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Feedback::factory()->count(500)->createQuietly();
    }
}
