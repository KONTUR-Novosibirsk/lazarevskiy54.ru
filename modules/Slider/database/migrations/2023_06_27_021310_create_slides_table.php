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
        Schema::create('slides', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('sort')->nullable();
            $table->text('description')->nullable();
            $table->string('link')->nullable();
            $table->text('props')->nullable();
            $table->unsignedBigInteger('slider_id');
            $table->foreign('slider_id')->on('sliders')->references('id')->onDelete('Cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slides');
    }
};
