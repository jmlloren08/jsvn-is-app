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
        Schema::create('warehouse_withdrawals', function (Blueprint $table) {
            $table->bigIncrements('withdrawal_id');
            $table->date('withdrawal_date');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')
                ->references('product_id')->on('products')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('quantity_out');
            $table->integer('quantity_return')->nullable();
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
