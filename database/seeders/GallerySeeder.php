<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Gallery\App\Models\Gallery;
use Modules\Gallery\App\Models\GalleryImage;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Gallery::factory()->has(GalleryImage::factory()->count(4), 'images')->count(5)->create();
        Gallery::factory()->count(5)->create();
    }
}
