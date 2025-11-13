<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorporateAccountEmployee extends Model
{
    use HasFactory;

    protected $fillable = [
        'corporate_id',
        'user_id',
        'name',
        'email',
        'phone',
        'department',
        'active',
    ];

    /**
     * Relationship: Employee belongs to a corporate account
     */
    public function corporateAccount()
    {
        return $this->belongsTo(CorporateAccount::class, 'corporate_id', 'corporate_id');
    }
}
