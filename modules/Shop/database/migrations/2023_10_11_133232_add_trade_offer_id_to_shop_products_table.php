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
        Schema::table('shop_products', function (Blueprint $table) {
            $table->unsignedBigInteger('trade_offer_id')->nullable();
            $table->foreign('trade_offer_id')->on('shop_trade_offers')->references('id')->onDelete('Set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shop_products', function (Blueprint $table) {
            $table->dropForeign(['trade_offer_id']);
            $table->dropColumn('trade_offer_id');
        });
    }
};
