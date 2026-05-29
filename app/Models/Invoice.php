<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    //
    protected $table = 'invoices';
    protected $guarded = [];

    public function deliveryOrder()
    {
        return $this->belongsTo(
            Delivery_orders::class,
            'delivery_order_id'
        );
    }

    public function customer()
    {
        return $this->belongsTo(
            Customer::class,
            'customer_id'
        );
    }
}
