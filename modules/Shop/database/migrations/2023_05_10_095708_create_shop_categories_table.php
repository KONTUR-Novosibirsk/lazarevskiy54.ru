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
        Schema::create('shop_categories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('alias');
            $table->boolean('show_on_index_page')->nullable();
            $table->longText('description')->nullable();
            $table->unsignedBigInteger('filter_id')->nullable();
            $table->foreign('filter_id')->on('shop_filters')->references('id')->onDelete('set null');
            $table->nestedSet();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_categories');
    }
};
