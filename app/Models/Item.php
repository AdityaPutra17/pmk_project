<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    //
    protected $table = 'items';

    protected $fillable = [
        'kd_item',
        'category_id',
        'harga',
        'satuan',
        'deskripsi',
    ];

    public function category()
    {
        return $this->belongsTo(ItemCategories::class, 'category_id');
    }
}
