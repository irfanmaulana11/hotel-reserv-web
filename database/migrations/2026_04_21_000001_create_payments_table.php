<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id')->constrained()->onDelete('cascade');
            $table->string('stripe_session_id')->unique()->nullable();
            $table->string('stripe_payment_intent_id')->unique()->nullable();
            $table->decimal('amount', 12, 2);
            $table->string('currency', 3)->default('idr');
            $table->string('status')->default('pending'); // pending, success, failed, cancelled
            $table->string('payment_method')->nullable();
            $table->text('last_error')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
