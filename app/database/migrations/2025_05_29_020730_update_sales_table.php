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
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn(['products', 'quantity']); // Elimina campos obsoletos
            $table->decimal('total_price', 10, 2)->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->json('products')->nullable();
            $table->integer('quantity')->default(1);
            $table->dropColumn('total_price');
        });
    }

};
