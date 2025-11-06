<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Association extends Model
{
    use HasFactory;

    protected $fillable = ['name','description','boardNumber'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

 public function drivers()
{
    return $this->hasMany(DriverOnde::class, 'boardNumber', 'boardNumber');
}
}
