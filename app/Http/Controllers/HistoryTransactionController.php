<?php

namespace App\Http\Controllers;

use App\Models\HistoryTransaction;

class HistoryTransactionController extends Controller
{
    public function index()
    {
        $histories = HistoryTransaction::with(
            'invoice'
        )
        ->latest()
        ->paginate(20);

        return view(
            'admin.transaksi.histori.index',
            compact('histories')
        );
    }
}