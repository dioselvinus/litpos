<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('order', ['dine-in', 'take-away']);
            $table->foreignUuid('user_id')->references('id')->on('users');
            $table->integer('subtotal');
            $table->integer('ppn');
            $table->integer('total');
            $table->enum('payment_method', ['cash', 'qris'])->default('qris');
            $table->integer('cash_amount')->nullable();
            $table->integer('cash_change')->nullable();
            $table->enum('status', ['pending', 'success', 'failed']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
