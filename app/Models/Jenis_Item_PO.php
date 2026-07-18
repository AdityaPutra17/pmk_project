<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jenis_Item_PO extends Model
{
    use HasFactory;

    protected $table = 'jenis__item__p_o_s';

    protected $fillable = [
        'code',
        'name',
    ];
    
}
