<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemPO extends Model
{
    use HasFactory;

    protected $table = 'item_p_o_s';

    protected $fillable = [
        'item_code',
        'id_jenis_item_po',
        'description',
    ];

    public function itemType()
    {
        return $this->belongsTo(Jenis_Item_PO::class, 'id_jenis_item_po');
    }
}
