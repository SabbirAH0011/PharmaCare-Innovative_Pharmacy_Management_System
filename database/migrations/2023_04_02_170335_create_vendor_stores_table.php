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
        Schema::create('vendor_stores', function (Blueprint $table) {
            $table->id();
            $table->string('serial')->nullable();
            $table->string('store_name')->nullable();
            $table->longText('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('zone')->nullable();
            $table->string('owner')->nullable();
            $table->string('status')->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_stores');
    }
};
