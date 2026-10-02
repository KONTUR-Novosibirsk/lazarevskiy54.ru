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
        Schema::create('shop_filter_attributes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('sort');
            $table->string('type');
            $table->unsignedBigInteger('attribute_id');
            $table->unsignedBigInteger('filter_id');
            $table->foreign('attribute_id')->on('shop_attributes')->references('id')->onDelete('cascade');
            $table->foreign('filter_id')->on('shop_filters')->references('id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_filter_attributes');
    }
};
