<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('info_block_elements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('sort')->nullable();
            $table->text('description')->nullable();
            $table->text('props')->nullable();
            $table->unsignedBigInteger('info_block_id')->index();
            $table->foreign('info_block_id')->on('info_blocks')->references('id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('info_block_elements');
    }
};
