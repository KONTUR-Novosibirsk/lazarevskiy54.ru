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
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('route_name')->nullable();
            $table->text('route_attributes')->nullable();
            $table->string('url')->nullable();
            $table->integer('sort')->nullable();
            $table->boolean('is_branched')->default(false);
            $table->string('branch_class')->nullable();
            $table->nullableMorphs('model');
            $table->nestedSet();
            $table->boolean('visible')->default(true);
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('menu_id')->nullable();
            $table->foreign('category_id')->on('menu_categories')->references('id')->onDelete('cascade');
            $table->foreign('menu_id')->on('menu_items')->references('id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
