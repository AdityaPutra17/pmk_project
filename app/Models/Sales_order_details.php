<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sales_orders;
use App\Models\Item;

class Sales_order_details extends Model
{
    //
    protected $table = 'sales_order_details';
    // protected $guarded = [];
    protected $fillable = [ 'sales_order_id', 'item_id', 'qty', 'harga', 'subtotal', ];

    public function sales_order()
    {
        // return $this->belongsTo(Sales_orders::class);
        return $this->belongsTo( Sales_orders::class, 'sales_order_id' );
    }

    public function item()
    {
        // return $this->belongsTo(Item::class);
        return $this->belongsTo( Item::class, 'item_id' );
    }
}
