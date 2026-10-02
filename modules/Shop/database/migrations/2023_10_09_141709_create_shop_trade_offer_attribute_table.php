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
        Schema::create('shop_trade_offer_attribute', function (Blueprint $table) {
            $table->id();
            $table->integer('sort');
            $table->unsignedBigInteger('attribute_id');
            $table->unsignedBigInteger('trade_offer_id');
            $table->foreign('attribute_id')->on('shop_attributes')->references('id')->onDelete('Cascade');
            $table->foreign('trade_offer_id')->on('shop_trade_offers')->references('id')->onDelete('Cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_trade_offer_attribute');
    }
};
