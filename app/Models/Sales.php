<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    //
    protected $table = 'sales';
    protected $fillable = [
        'name',
        'kd_sales',
        'phone',
        'area_id',
    ];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
}
