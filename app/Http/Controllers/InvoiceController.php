<?php

namespace App\Http\Controllers;
use App\Models\Delivery_orders;
use App\Models\Sales_orders;
use App\Models\Sales_order_details;
use App\Models\Invoice;

use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with([
            'deliveryOrder',
            'customer'
        ])->latest()->get();

        return view(
            'admin.transaksi.invoice.index',
            compact('invoices')
        );
    }
    //
    public function generate($id)
    {
        $do = Delivery_orders::with([
            'details.item',
            'customer',
            'sales_order'
        ])->findOrFail($id);

        $lastInvoice = Invoice::latest()->first();

        $nextNumber =
            $lastInvoice
            ? $lastInvoice->id + 1
            : 1;

        $nomorInvoice =
            'INV' .
            now()->format('ym') .
            str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        Invoice::create([

            'nomor_invoice'   => $nomorInvoice,

            'tanggal_invoice' => now(),

            'delivery_order_id' => $do->id,

            'customer_id' => $do->customer_id,

            'total_dpp' => $do->sales_order->total_dpp,

            'ppn_total' => $do->sales_order->ppn_total,

            'grand_total' => $do->sales_order->grand_total,

            'status' => 'unpaid',
        ]);

        return back()->with(
            'success',
            'Invoice berhasil dibuat'
        );
    }

    public function print($id)
    {
        $invoice = Invoice::with([
            'deliveryOrder.details.item',
            'deliveryOrder.details.salesOrderDetail',
            'deliveryOrder.sales_order.sales',
            'customer'
        ])->findOrFail($id);

        return view(
            'admin.transaksi.invoice.print',
            compact('invoice')
        );
    }
}
