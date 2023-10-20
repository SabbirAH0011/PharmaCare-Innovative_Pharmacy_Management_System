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
        Schema::create('booked_ambulances', function (Blueprint $table) {
            $table->id();
            $table->string('serial')->nullable();
            $table->string('location')->nullable();
            $table->string('address')->nullable();
            $table->string('destination')->nullable();
            $table->double('total')->nullable();
            $table->string('total_payment_status')->nullable();
            $table->double('partial')->nullable();
            $table->string('partial_payment_status')->nullable();
            $table->string('ambulance_no')->nullable();
            $table->string('booked_by')->nullable();
            $table->string('status')->default('Booked');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booked_ambulances');
    }
};
