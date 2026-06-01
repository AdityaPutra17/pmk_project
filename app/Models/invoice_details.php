<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class invoice_details extends Model
{
    //
    protected $table = 'invoice_details';
    protected $guarded = [];

    public function invoice()
    {
        return $this->belongsTo(
            Invoice::class,
            'invoice_id'
        );
    }

    public function deliveryOrderDetail()
    {
        return $this->belongsTo(
            Delivery_order_details::class,
            'delivery_order_detail_id'
        );
    }

    public function salesOrderDetail()
    {
        return $this->belongsTo(
            Sales_order_details::class,
            'sales_order_detail_id'
        );
    }
}

