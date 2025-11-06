<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverOnde extends Model
{
    use HasFactory;

    protected $table = 'driver_onde';

    protected $fillable = [
        'driverId',
        'companyId',
        'fullName',
        'phone',
        'state',
        'boardNumber',
        'invited_message_sent',
        'active_message_sent',
    ];
   public function association()
    {
        return $this->belongsTo(Association::class, 'boardNumber', 'boardNumber');
    }
    public $timestamps = true;
}
