<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemCategories extends Model
{
    //
    protected $table = 'item_categories';

    protected $fillable = [
        'name',
        'kd_category',
    ];

    public function items()
    {
        return $this->hasMany(Items::class, 'category_id');
    }
}
