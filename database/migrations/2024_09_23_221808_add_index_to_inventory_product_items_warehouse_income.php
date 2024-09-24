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
        Schema::table('inventory_product_items', function (Blueprint $table) {
            $table->index(['inventory_warehouse_income_id'], 'inventory_warehouse_income_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventory_product_items', function (Blueprint $table) {
            $table->dropIndex('inventory_warehouse_income_index');
        });
    }
};