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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->unsignedBigInteger('courier_id')->nullable();
            $table->string('invoice_number')->nullable();
            $table->text('shipping_address')->nullable();
            $table->bigInteger('shipping_cost')->nullable();
            $table->bigInteger('total_price');
            $table->enum('status', ['PROCESS', 'CANCEL', 'SUCCESS'])->default('PROCESS');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
