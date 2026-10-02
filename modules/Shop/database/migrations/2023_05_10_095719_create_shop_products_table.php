<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shop_products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('alias');
            $table->float('price')->default(0.00);
            $table->float('old_price')->default(0.00)->nullable();
            $table->boolean('active')->default(true);
            $table->boolean('not_available')->default(false);
            $table->boolean('is_new')->default(false);
            $table->boolean('hit')->default(false);
            $table->boolean('show_on_index_page')->default(false);
            $table->boolean('show_on_shop_index_page')->default(false);
            $table->string('vendor_code')->nullable();
            $table->longText('description')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->on('shop_categories')->references('id');
            $table->fullText(['title', 'description']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_products');
    }
};
