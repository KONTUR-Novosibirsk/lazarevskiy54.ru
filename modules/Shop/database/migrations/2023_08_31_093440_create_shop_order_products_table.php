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
        Schema::create('shop_order_products', function (Blueprint $table) {
            $table->id();
            $table->float('price')->default(0.00);
            $table->integer('count')->default(1);
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id')->on('shop_products')->references('id')->onDelete('Set null');
            $table->foreign('order_id')->on('shop_orders')->references('id')->onDelete('Cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_order_products');
    }
};
