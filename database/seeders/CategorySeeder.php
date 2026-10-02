<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Shop\App\Models\ShopCategory;

class CategorySeeder extends Seeder
{
    public int $currentCategoryLevel = 0;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ShopCategory::factory(6)->afterCreating(
            function (ShopCategory $category) {
                if ($category->saveAsRoot()) {
                    $this->currentCategoryLevel = 0;

/*                    $this->createTreeCategories(
                        nodeParent: $category,
                    );*/
                }
            }
        )->create();
    }

    public function createTreeCategories(
        ShopCategory $nodeParent,
        int $count = 6,
        int $maxLevel = 2
    ): void
    {
        $factory = ShopCategory::factory()
            ->state(['parent_id' => $nodeParent?->id]);

        if ($maxLevel > $this->currentCategoryLevel) {
            $count = $count / 2;

            $this->currentCategoryLevel++;

            $appendClosure = function(ShopCategory $category) use ($nodeParent) {
                $nodeParent->appendNode($category);

                $this->createTreeCategories($category);
            };
        } else {
            $appendClosure = function(ShopCategory $category) use ($nodeParent) {
                $category->appendToNode($nodeParent);
            };
        }

        $factory->count($count)->afterCreating($appendClosure)->create();
    }
}
