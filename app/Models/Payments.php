<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;

    protected $fillable = [
        'driver_phone',
        'amount',
        'transaction_id',
        'momo_provider_id',
        'payment_method',
        'status',
        'description',
        'paid_to',
        'paid_at',
    ];

    protected $dates = ['paid_at'];
}
