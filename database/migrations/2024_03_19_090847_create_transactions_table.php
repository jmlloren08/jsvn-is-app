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
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('transaction_id');
            $table->unsignedBigInteger('transaction_no');
            $table->date('transaction_date');
            $table->unsignedBigInteger('outlet_id');
            $table->foreign('outlet_id')
                ->references('id')->on('outlets')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('term')->nullable();
            $table->date('date_delivered')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('quantity');
            $table->integer('on_hand')->nullable();
            $table->integer('sold')->nullable();
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
