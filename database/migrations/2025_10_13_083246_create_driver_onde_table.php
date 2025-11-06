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
           Schema::create('driver_onde', function (Blueprint $table) {
        $table->id();
        $table->uuid('driverId')->unique();
        $table->uuid('companyId');
        $table->string('fullName');
        $table->string('phone');
        $table->string('state');
         $table->string('boardNumber');
        $table->boolean('invited_message_sent')->default(false);
        $table->boolean('active_message_sent')->default(false);
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('driver_onde');
    }
};
