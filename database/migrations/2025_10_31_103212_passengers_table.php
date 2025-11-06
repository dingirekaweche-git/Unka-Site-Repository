<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('passengers', function (Blueprint $table) {
          $table->string('passenger_id')->nullable();
            $table->string('passenger_source')->nullable();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('company')->nullable();
            $table->text('note')->nullable();
            $table->string('profile_state')->nullable();
            $table->integer('client_documents')->default(0);

            // Order stats
            $table->integer('total_orders')->default(0);
            $table->integer('paid_orders_total')->default(0);
            $table->decimal('paid_orders_total_amount', 10, 2)->default(0);
            $table->integer('unpaid_orders_total')->default(0);
            $table->decimal('unpaid_orders_total_amount', 10, 2)->default(0);

            // Cancellation stats
            $table->integer('cancelled_by_dispatcher')->default(0);
            $table->integer('cancelled_by_driver')->default(0);
            $table->integer('cancelled_no_passenger')->default(0);
            $table->integer('cancelled_decided_not_to_go')->default(0);
            $table->integer('cancelled_no_taxi')->default(0);
            $table->integer('cancelled_driver_offline')->default(0);
            $table->integer('cancelled_search_exceeded')->default(0);
            $table->integer('cancelled_expired')->default(0);

            // Completed trip stats
            $table->integer('finished_paid')->default(0);
            $table->integer('finished_unpaid')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('passengers');
    }
};
