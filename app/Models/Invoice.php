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

    public function details()
    {
        return $this->hasMany(
            invoice_details::class,
            'invoice_id'
        );
    }

    public function sales_order_detail()
    {
        return $this->belongsTo(
            Sales_order_details::class,
            'sales_order_detail_id'
        );
    }

    public function deliveryOrders()
    {
        return $this->belongsToMany(
            Delivery_orders::class,
            'invoice_delivery_orders',
            'invoice_id',
            'delivery_order_id'
        );
    }
}
