<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoryTransaction extends Model
{
    protected $fillable = [
        'invoice_id',
        'nomor_invoice',
        'tipe_transaksi',
        'nominal_sebelum',
        'nominal_bayar',
        'nominal_setelah',
        'status_sebelum',
        'status_setelah',
        'user_name'
    ];

    public function invoice()
    {
        return $this->belongsTo(
            Invoice::class
        );
    }
}