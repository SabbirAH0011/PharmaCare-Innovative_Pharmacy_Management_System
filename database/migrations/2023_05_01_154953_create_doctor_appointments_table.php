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
        Schema::create('doctor_appointments', function (Blueprint $table) {
            $table->id();
            $table->string('serial')->nullable();
            $table->string('patient_name')->nullable();
            $table->double('patient_age')->nullable();
            $table->string('visiting_day')->nullable();
            $table->string('doctor')->nullable();
            $table->string('client_id')->nullable();
            $table->string('status')->default('Unapproved');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_appointments');
    }
};
