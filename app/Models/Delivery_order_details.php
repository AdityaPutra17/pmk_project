<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery_order_details extends Model
{
    protected $table = 'delivery_order_details';

    protected $guarded = [];

    public function delivery_order()
    {
        return $this->belongsTo(
            Delivery_orders::class,
            'delivery_order_id'
        );
    }

    public function salesOrderDetail()
    {
        return $this->belongsTo(
            Sales_order_details::class,
            'sales_order_detail_id'
        );
    }

    public function item()
    {
        return $this->belongsTo(
            Item::class,
            'item_id'
        );
    }
}