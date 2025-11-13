<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('corporate_wallets', function (Blueprint $table) {
            $table->id();
            $table->string('corporate_id'); // FK to corporate_accounts
            $table->decimal('balance', 15, 2)->default(0.00);
            $table->decimal('last_topup', 15, 2)->nullable();
            $table->string('added_by')->nullable(); // admin user id or name
            $table->timestamps();

            $table->foreign('corporate_id')
                  ->references('corporate_id')
                  ->on('corporate_accounts')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('corporate_wallets');
    }
};
