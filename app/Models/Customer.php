<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
    protected $table = 'customers';
    protected $fillable = [
        'nama_customer',
        'kd_customer',
        'alamat',
        'npwp',
        'no_telp',
        'sales_id',
        'area_id',
    ];

    public function sales()
    {
        return $this->belongsTo(Sales::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }
}
