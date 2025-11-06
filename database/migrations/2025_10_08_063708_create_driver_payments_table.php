<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('driver_payments', function (Blueprint $table) {
            $table->id();
          $table->string('driver_phone')->nullable();
            $table->decimal('amount', 10, 2);
            $table->string('transaction_id')->unique(); // Our internal ID
            $table->string('momo_provider_id')->nullable(); // From inquiry API
            $table->string('payment_method')->nullable();
            $table->string('status')->default('pending'); // pending | successful | failed
            $table->text('description')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('driver_payments');
    }
};
