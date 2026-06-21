<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerPO extends Model
{
    use HasFactory;

    protected $table = 'customer_p_o_s';

    protected $fillable = [
        'customer_code',
        'name',
    ];
}
