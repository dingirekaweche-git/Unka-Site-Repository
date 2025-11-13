<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('corporate_accounts', function (Blueprint $table) {
            $table->string('corporate_id')->primary(); // user-entered ID
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('account_type')->default('postpaid'); // or 'prepaid'
            $table->decimal('balance', 15, 2)->default(0.00);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('corporate_accounts');
    }
};
