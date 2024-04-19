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
        Schema::create('warehouses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('withdrawal_date');
            $table->unsignedBigInteger('product_id');
            $table->foreignId('user_id')->nullable()->index();
            $table->integer('quantity_out')->nullable();
            $table->integer('quantity_return')->nullable();
            $table->integer('sold')->nullable();
            $table->integer('stock');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouse_withdrawals');
    }
};
