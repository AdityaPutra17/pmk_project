<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Customer;
use App\Models\Sales;
use App\Models\Sales_order_details;


class Sales_orders extends Model
{
    //
    protected $table = 'sales_orders';
    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function sales()
    {
        return $this->belongsTo(Sales::class);
    }

    public function details()
    {
        // return $this->hasMany(Sales_order_details::class);
        return $this->hasMany( \App\Models\Sales_order_details::class, 'sales_order_id' );
    }
}
