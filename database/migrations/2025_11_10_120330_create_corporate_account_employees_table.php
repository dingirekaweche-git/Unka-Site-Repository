<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('corporate_account_employees', function (Blueprint $table) {
            $table->id();
            $table->string('corporate_id');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('department')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();

            // Foreign key relation
            $table->foreign('corporate_id')
                  ->references('corporate_id')
                  ->on('corporate_accounts')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('corporate_account_employees');
    }
};
