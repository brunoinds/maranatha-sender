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
        Schema::table('inventory_warehouse_product_item_loans', function (Blueprint $table) {
            $table->string('job_code')->nullable(true);
            $table->string('expense_code')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventory_warehouse_product_item_loans', function (Blueprint $table) {
            $table->dropColumn('job_code');
            $table->dropColumn('expense_code');
        });
    }
};
