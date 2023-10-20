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
            $table->string('serial')->nullable();
            $table->string('client_serial')->nullable();
            $table->longText('product_detail_group')->nullable();
            $table->string('shipping_address')->nullable();
            $table->double('total_price')->nullable();
            $table->double('deilvery_charge')->nullable();
            $table->double('total_amount')->nullable();
            $table->string('payment_method')->nullable();
            $table->longText('payment_token')->nullable();
            $table->string('payment_status')->default('Unpaid');
            $table->string('location')->nullable();
            $table->string('delivery_status')->nullable();
            $table->string('rider_serial')->nullable();
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
