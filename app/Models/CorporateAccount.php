<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorporateAccount extends Model
{
    use HasFactory;

    // Primary key is not auto-incrementing
    protected $primaryKey = 'corporate_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'corporate_id',
        'name',
        'email',
        'phone',
        'address',
        'account_type',
        'balance',
    ];

    /**
     * Relationship: CorporateAccount has many employees
     */
    public function employees()
    {
        return $this->hasMany(CorporateAccountEmployee::class, 'corporate_id', 'corporate_id');
    }
}
