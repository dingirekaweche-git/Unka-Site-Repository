<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorporateWallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'corporate_id',
        'balance',
        'last_topup',
        'added_by',
    ];

    public function corporateAccount()
    {
        return $this->belongsTo(CorporateAccount::class, 'corporate_id', 'corporate_id');
    }
}
