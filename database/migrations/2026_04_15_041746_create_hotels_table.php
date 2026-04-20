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
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('address');
            $table->string('city', 100);
            $table->string('country', 100);
            $table->string('phone', 20)->nullable();
            $table->string('email')->nullable();
            $table->integer('star_rating')->default(3);
            $table->text('description')->nullable();
            $table->decimal('price_per_night', 10, 2);
            $table->integer('total_rooms')->default(0);
            $table->integer('available_rooms')->default(0);
            $table->string('image_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};
