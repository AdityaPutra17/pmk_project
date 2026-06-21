<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'po_number',
        'po_date',
        'supplier_id',
        'customer_id',
        'delivery_date',
        'top_id',
        'franco_id',
        'ppn',
        'subtotal',
        'tax',
        'grand_total',
        'notes',
        'status',
    ];

    public function details()
    {
        return $this->hasMany(PurchaseOrderDetail::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function customer()
    {
        return $this->belongsTo(CustomerPO::class);
    }

    public function top()
    {
        return $this->belongsTo(Top::class);
    }

    public function franco()
    {
        return $this->belongsTo(Franco::class);
    }
}
