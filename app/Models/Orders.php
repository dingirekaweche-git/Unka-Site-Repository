<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'order_id',
        'created_at_api',
        'author_id',
        'order_source',
        'bundle',
        'requested_vehicle_type',
        'requested_pickup_time',
        'origin_type',
        'origin_location',
        'origin_address',
        'destination_type',
        'destination_location',
        'destination_address',
        'dropoff_type',
        'dropoff_location',
        'dropoff_address',
        'dropoffs_count',
        'order_notes',
        'passengers_number',
        'client_documents',
        'driver_payment_documents',
        'passenger_id',
        'passenger_name',
        'passenger_email',
        'passenger_phone',
        'passenger_operator_id',
        'passenger_operator_name',
        'passenger_operator_email',
        'driver_operator_id',
        'driver_operator_name',
        'driver_operator_email',
        'driver_id',
        'driver_custom_key',
        'driver_name',
        'driver_email',
        'driver_phone',
        'vehicle_type',
        'vehicle_plate_number',
        'vehicle_board_number',
        'driver_reputation',
        'driver_reputation_correction',
        'estimation_time',
        'estimation_distance',
        'driver_rate_plan',
        'offer_count',
        'reject_count',
        'total_bid_count',
        'driver_bid_count',
        'dispatcher_bid_count',
        'order_status',
        'unpaid_reason',
        'unpaid_message',
        'cancellation_reason',
        'cancellation_comment',
        'trip_distance',
        'trip_time',
        'intermediate_driver_ids',
        'passenger_cancellation_fee',
        'driver_cancellation_fee',
        'trip_cost',
        'extra_cost',
        'total_cost',
        'coupon_discount',
        'tips',
        'bonus_amount',
        'including_tax',
        'tax',
        'transactional_fee',
        'final_cost',
        'unpaid_cost',
        'rounding_correction_value',
        'excess_payment',
        'payment_method',
        'payment_card',
        'corporate_account',
        'payment_errors',
        'rating_by_driver',
        'rating_by_passenger',
        'started_at',
        'started_location',
        'arrived_at',
        'arrived_location',
        'loaded_at',
        'loaded_location',
        'finished_at',
        'finished_location',
        'closed_at',
        'closed_location',
        'service_space',
        'active',
        'linked_order',
        'price_multiplier',
        'coupon_code',
        'promo_campaign_name',
        'customer_reward_data',
        'driver_reward_data',
    ];

    protected $casts = [
        // JSON fields
        'origin_location' => 'array',
        'destination_location' => 'array',
        'dropoff_location' => 'array',
        'client_documents' => 'array',
        'driver_payment_documents' => 'array',
        'intermediate_driver_ids' => 'array',
        'started_location' => 'array',
        'arrived_location' => 'array',
        'loaded_location' => 'array',
        'finished_location' => 'array',
        'closed_location' => 'array',
      

        // Numbers and decimals
        'driver_reputation' => 'decimal:2',
        'driver_reputation_correction' => 'decimal:2',
        'estimation_distance' => 'decimal:2',
        'trip_distance' => 'decimal:2',
        'trip_cost' => 'decimal:2',
        'extra_cost' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'coupon_discount' => 'decimal:2',
        'tips' => 'decimal:2',
        'bonus_amount' => 'decimal:2',
        'including_tax' => 'decimal:2',
        'tax' => 'decimal:2',
        'transactional_fee' => 'decimal:2',
        'final_cost' => 'decimal:2',
        'unpaid_cost' => 'decimal:2',
        'rounding_correction_value' => 'decimal:2',
        'excess_payment' => 'decimal:2',
        'passenger_cancellation_fee' => 'decimal:2',
        'driver_cancellation_fee' => 'decimal:2',
        'price_multiplier' => 'decimal:2',

        // Integers
        'dropoffs_count' => 'integer',
        'passengers_number' => 'integer',
        'offer_count' => 'integer',
        'reject_count' => 'integer',
        'total_bid_count' => 'integer',
        'driver_bid_count' => 'integer',
        'dispatcher_bid_count' => 'integer',
        'trip_time' => 'integer',
        'rating_by_driver' => 'integer',
        'rating_by_passenger' => 'integer',

        // Timestamps
        'requested_pickup_time' => 'datetime',
        'started_at' => 'datetime',
        'arrived_at' => 'datetime',
        'loaded_at' => 'datetime',
        'finished_at' => 'datetime',
        'closed_at' => 'datetime',
        'created_at_api' => 'datetime',

        // Booleans
        'active' => 'boolean',
    ];

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'order_id';
    }

    /**
     * Scope a query to only include active orders.
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    /**
     * Scope a query to filter by order status.
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('order_status', $status);
    }

    /**
     * Scope a query to filter by passenger ID.
     */
    public function scopeByPassenger($query, $passengerId)
    {
        return $query->where('passenger_id', $passengerId);
    }

    /**
     * Scope a query to filter by driver ID.
     */
    public function scopeByDriver($query, $driverId)
    {
        return $query->where('driver_id', $driverId);
    }
}