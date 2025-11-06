<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique();
            $table->timestamp('created_at_api')->nullable(); // API created_at
            $table->string('author_id')->nullable();
            $table->string('order_source')->nullable();
            $table->string('bundle')->nullable();
            $table->string('requested_vehicle_type')->nullable();
            $table->timestamp('requested_pickup_time')->nullable();
            $table->string('origin_type')->nullable();
            $table->json('origin_location')->nullable();
            $table->string('origin_address')->nullable();
            $table->string('destination_type')->nullable();
            $table->json('destination_location')->nullable();
            $table->string('destination_address')->nullable();
            $table->string('dropoff_type')->nullable();
            $table->json('dropoff_location')->nullable();
            $table->string('dropoff_address')->nullable();
            $table->integer('dropoffs_count')->nullable();
            $table->text('order_notes')->nullable();
            $table->integer('passengers_number')->nullable();
            $table->json('client_documents')->nullable();
            $table->json('driver_payment_documents')->nullable();

            // Passenger info
            $table->string('passenger_id')->nullable();
            $table->string('passenger_name')->nullable();
            $table->string('passenger_email')->nullable();
            $table->string('passenger_phone')->nullable();
            $table->string('passenger_operator_id')->nullable();
            $table->string('passenger_operator_name')->nullable();
            $table->string('passenger_operator_email')->nullable();

            // Driver info
            $table->string('driver_operator_id')->nullable();
            $table->string('driver_operator_name')->nullable();
            $table->string('driver_operator_email')->nullable();
            $table->string('driver_id')->nullable();
            $table->string('driver_custom_key')->nullable();
            $table->string('driver_name')->nullable();
            $table->string('driver_email')->nullable();
            $table->string('driver_phone')->nullable();

            // Vehicle info
            $table->string('vehicle_type')->nullable();
            $table->string('vehicle_plate_number')->nullable();
            $table->string('vehicle_board_number')->nullable();

            // Ratings and reputation
            $table->decimal('driver_reputation', 5, 2)->nullable();
            $table->decimal('driver_reputation_correction', 5, 2)->nullable();

            // Estimations
            $table->integer('estimation_time')->nullable();
            $table->decimal('estimation_distance', 10, 2)->nullable();

            // Bidding and rate plans
            $table->string('driver_rate_plan')->nullable();
            $table->integer('offer_count')->nullable();
            $table->integer('reject_count')->nullable();
            $table->integer('total_bid_count')->nullable();
            $table->integer('driver_bid_count')->nullable();
            $table->integer('dispatcher_bid_count')->nullable();

            // Status and reason info
            $table->string('order_status')->nullable();
            $table->string('unpaid_reason')->nullable();
            $table->text('unpaid_message')->nullable();
            $table->string('cancellation_reason')->nullable();
            $table->text('cancellation_comment')->nullable();

            // Trip metrics
            $table->decimal('trip_distance', 10, 2)->nullable();
            $table->integer('trip_time')->nullable();
            $table->json('intermediate_driver_ids')->nullable();

            // Costs
            $table->decimal('passenger_cancellation_fee', 10, 2)->nullable();
            $table->decimal('driver_cancellation_fee', 10, 2)->nullable();
            $table->decimal('trip_cost', 10, 2)->nullable();
            $table->decimal('extra_cost', 10, 2)->nullable();
            $table->decimal('total_cost', 10, 2)->nullable();
            $table->decimal('coupon_discount', 10, 2)->nullable();
            $table->decimal('tips', 10, 2)->nullable();
            $table->decimal('bonus_amount', 10, 2)->nullable();
            $table->decimal('including_tax', 10, 2)->nullable();
            $table->decimal('tax', 10, 2)->nullable();
            $table->decimal('transactional_fee', 10, 2)->nullable();
            $table->decimal('final_cost', 10, 2)->nullable();
            $table->decimal('unpaid_cost', 10, 2)->nullable();
            $table->decimal('rounding_correction_value', 10, 2)->nullable();
            $table->decimal('excess_payment', 10, 2)->nullable();

            // Payment
            $table->string('payment_method')->nullable();
            $table->string('payment_card')->nullable();
            $table->string('corporate_account')->nullable();
            $table->text('payment_errors')->nullable();

            // Ratings
            $table->integer('rating_by_driver')->nullable();
            $table->integer('rating_by_passenger')->nullable();

            // Timestamps and locations
            $table->timestamp('started_at')->nullable();
            $table->json('started_location')->nullable();
            $table->timestamp('arrived_at')->nullable();
            $table->json('arrived_location')->nullable();
            $table->timestamp('loaded_at')->nullable();
            $table->json('loaded_location')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->json('finished_location')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->json('closed_location')->nullable();

            // Misc
            $table->string('service_space')->nullable();
            $table->boolean('active')->default(true);
            $table->string('linked_order')->nullable();
            $table->decimal('price_multiplier', 5, 2)->nullable();
            $table->string('coupon_code')->nullable();
            $table->string('promo_campaign_name')->nullable();
            
            // Reward data fields
            $table->json('customer_reward_data')->nullable();
            $table->json('driver_reward_data')->nullable();

            $table->timestamps();
            
            // Indexes for better performance
            $table->index('order_id');
            $table->index('created_at_api');
            $table->index('order_status');
            $table->index('passenger_id');
            $table->index('driver_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};