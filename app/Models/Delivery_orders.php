<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery_orders extends Model
{
    //
    protected $table = 'delivery_orders';

    protected $guarded = [];

    public function sales_order()
    {
        return $this->belongsTo(Sales_orders::class, 'sales_order_id');
    }

    public function sales_order_detail()
    {
        return $this->belongsTo(
            Sales_order_details::class,
            'sales_order_detail_id'
        );
    }


    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function details()
    {
        return $this->hasMany(Delivery_order_details::class, 'delivery_order_id');
    }

    // public function invoice()
    // {
    //     return $this->hasOne(Invoice_headers::class, 'delivery_order_id');
    // }
    public function invoices()
    {
        return $this->hasMany(
            Invoice::class,
            'delivery_order_id'
        );
    }

}
