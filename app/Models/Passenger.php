<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passenger extends Model
{
    use HasFactory;

    protected $table = 'passengers';
 protected $primaryKey = 'passenger_id';
    public $incrementing = false;
    protected $fillable = [
        'passenger_id',
        'passenger_source',
        'name',
        'email',
        'phone',
        'company',
        'note',
        'profile_state',
        'client_documents',
        'total_orders',
        'paid_orders_total',
        'paid_orders_total_amount',
        'unpaid_orders_total',
        'unpaid_orders_total_amount',
        'cancelled_by_dispatcher',
        'cancelled_by_driver',
        'cancelled_no_passenger',
        'cancelled_decided_not_to_go',
        'cancelled_no_taxi',
        'cancelled_driver_offline',
        'cancelled_search_exceeded',
        'cancelled_expired',
        'finished_paid',
        'finished_unpaid',
    ];

    protected $casts = [
        'paid_orders_total_amount' => 'decimal:2',
        'unpaid_orders_total_amount' => 'decimal:2',
    ];

    /**
     * Accessor: Full cancellation count
     */

}
