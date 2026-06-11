<?php

namespace App\Http\Controllers;
use App\Models\Delivery_orders;
use App\Models\Sales_orders;
use App\Models\Sales_order_details;
use App\Models\Invoice;
use App\Models\Invoice_details;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function create()
    {
        $deliveryOrders = Delivery_orders::with([
            'customer',
            'details.item',
            'details.salesOrderDetail',
            'invoices'
        ])
        ->whereDoesntHave('invoices', function ($q) {

            $q->where('status', 'lunas');

        })
        ->get();

        return view(
            'admin.transaksi.invoice.create',
            compact('deliveryOrders')
        );
    }

    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {

            $status = 'unpaid';

            if ($request->jenis_invoice == 'pelunasan') {
                $status = 'lunas';
            } elseif ($request->jenis_invoice == 'cicilan') {
                $status = 'partial';
            }
            

            $invoice = Invoice::create([

                'nomor_invoice'
                    => $this->generateNomorInvoice(),

                'kode_transaksi'
                    => $this->generateKodeTransaksi(),

                'customer_id'
                    => $request->customer_id,

                'tanggal_invoice'
                    => $request->tanggal,

                'jenis_invoice'
                    => $request->jenis_invoice,

                'persentase_dp'
                    => $request->persentase_dp ?? 0,

                'nominal_dp'
                    => $request->nominal_dp ?? 0,

                'catatan'
                    => $request->catatan,

                'total_dpp'
                    => $request->total_dpp,

                'ppn_total'
                    => $request->ppn_total,

                'grand_total'
                    => $request->grand_total,

                'status'
                    => $status
            ]);
            
            $invoice->deliveryOrders()
                ->sync($request->delivery_order_ids);
            

            foreach ($request->items as $item)
            {
                Invoice_details::create([

                    'invoice_id'
                        => $invoice->id,

                    'delivery_order_detail_id'
                        => $item['do_detail_id'],

                    'sales_order_detail_id'
                        => $item['so_detail_id'],

                    'qty'
                        => $item['qty'],

                    'harga'
                        => $item['harga'],

                    'subtotal'
                        => $item['subtotal']
                ]);
            }
        });

        return redirect()
            ->route('invoice.index')
            ->with(
                'success',
                'Invoice berhasil dibuat'
            );
    }

    private function generateNomorInvoice()
    {
        $tahun = now()->format('y');

        $last = Invoice::orderByDesc('id')
            ->first();

        $urut = $last
            ? ((int) substr(
                $last->nomor_invoice,
                -4
            )) + 1
            : 1;

        return 'IF'
            .$tahun
            .str_pad(
                $urut,
                4,
                '0',
                STR_PAD_LEFT
            );
    }

    private function generateKodeTransaksi()
    {
        return 'IF'
            .now()->format('y')
            .str_pad(
                Invoice::count() + 1,
                6,
                '0',
                STR_PAD_LEFT
            );
    }

    public function print($id)
    {
        $invoice = Invoice::with([
            'details.salesOrderDetail.item',
            'customer',
            'deliveryOrders.sales_order.sales'
        ])->findOrFail($id);

        $totalDibayar = Invoice::where(
            'customer_id',
            $invoice->customer_id
        )
        ->where('id', '<=', $invoice->id)
        ->sum('nominal_dp');

        $sisaTagihan =
            $invoice->grand_total - $totalDibayar;

        if ($sisaTagihan < 0) {
            $sisaTagihan = 0;
        }

        return view(
            'admin.transaksi.invoice.print',
            compact(
                'invoice',
                'totalDibayar',
                'sisaTagihan'
            )
        );
    }
    public function show($id)
    {
        $invoice = Invoice::with([
            'customer',
            'details.salesOrderDetail.item',
            'details.deliveryOrderDetail.deliveryOrder',
            'deliveryOrders.customer'
        ])->findOrFail($id);

        $totalDibayar =
            $invoice->nominal_dp;

        $sisaTagihan =
            $invoice->grand_total -
            $totalDibayar;

        if($sisaTagihan < 0)
        {
            $sisaTagihan = 0;
        }

        return view(
            'admin.transaksi.invoice.show',
            compact(
                'invoice',
                'totalDibayar',
                'sisaTagihan'
            )
        );
    }

    public function storePayment(Request $request, $id)
    {
        $request->validate([
            'nominal_dp' => 'required|numeric|min:1'
        ]);

        $invoice = Invoice::findOrFail($id);

        $totalDibayar =
            $invoice->nominal_dp +
            $request->nominal_dp;

        $status = 'partial';

        if($totalDibayar >= $invoice->grand_total)
        {
            $totalDibayar =
                $invoice->grand_total;

            $status = 'lunas';
        }

        $invoice->update([
            'nominal_dp' => $totalDibayar,
            'status' => $status
        ]);

        return redirect()
            ->route('invoice.show', $invoice->id)
            ->with(
                'success',
                'Pembayaran berhasil disimpan'
            );
    }
}
