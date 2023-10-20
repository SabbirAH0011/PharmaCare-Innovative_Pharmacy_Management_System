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
        Schema::create('medicine_lists', function (Blueprint $table) {
            $table->id();
            $table->string('serial')->nullable();
            $table->string('main_image')->nullable();
            $table->string('medicine_name')->nullable();
            $table->string('medicine_type')->nullable();
            $table->string('drug_category')->nullable();
            $table->double('total_stock')->nullable();
            $table->double('price')->nullable();
            $table->longText('description')->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('store_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicine_lists');
    }
};
