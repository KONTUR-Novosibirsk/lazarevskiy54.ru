<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('shop_orders', function (Blueprint $table) {
            $table->dropColumn('address');
            $table->foreignId('account_id')->after('id')->nullable()->constrained('accounts')->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::table('shop_orders', function (Blueprint $table) {
            $table->dropConstrainedForeignId('account_id');
            $table->text('address')->nullable();
        });
    }
};
