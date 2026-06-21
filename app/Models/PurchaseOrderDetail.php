<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderDetail extends Model
{
    //
    // protected $guarted = [];

    protected $fillable = [
        'purchase_order_id',
        'item_id',
        'description',
        'qty',
        'price',
        'total',
    ];
    
    public function item()
    {
        return $this->belongsTo(ItemPO::class);
    }
}
