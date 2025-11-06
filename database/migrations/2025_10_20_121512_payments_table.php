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
            Schema::create('payments', function (Blueprint $table) {
            $table->id();
          $table->string('driver_phone')->nullable();
            $table->decimal('amount', 10, 2);
            $table->string('transaction_id')->unique(); // Our internal ID
            $table->string('momo_provider_id')->nullable(); // From inquiry API
            $table->string('payment_method')->nullable();
            $table->string('status')->default('pending'); // pending | successful | failed
            $table->string('paid_to')->nullable();
            $table->text('description')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
