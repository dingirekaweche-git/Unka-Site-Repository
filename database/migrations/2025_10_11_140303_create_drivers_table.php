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
        Schema::create('drivers', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('phone_number')->unique();
        $table->enum('subscription_plan', ['commision','daily','weekly', 'monthly'])->default('commision');
        $table->string('email')->nullable();
        $table->string('license_number');
        $table->enum('service_type', ['classic','business','airport', 'moto'])->default('classic');
        $table->string('plate_number');
        $table->string('vehicle_model');
        $table->string('color');
        $table->string('board_number');
        $table->string('number_of_passenger_seats');
        $table->string('vehicle_image');
        $table->string('license_front_image');
        $table->string('license_back_image');
        $table->foreignId('association_id')->constrained('associations')->cascadeOnDelete();
        $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
        $table->enum('status', ['pending','approved','rejected'])->default('pending');
        $table->timestamps();
    
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
