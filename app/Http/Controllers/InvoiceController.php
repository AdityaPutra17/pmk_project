<?php

namespace App\Http\Controllers;
use App\Models\Delivery_orders;
use App\Models\Sales_orders;
use App\Models\Sales_order_details;
use App\Models\Invoice;
use App\Models\Invoice_details;
use App\Models\HistoryTransaction;

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

            // if ($request->jenis_invoice == 'pelunasan') {
            //     $status = 'lunas';
            // } elseif ($request->jenis_invoice == 'cicilan') {
            //     $status = 'partial';
            // }
            

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
                    => 'dp',

                'persentase_dp' => 0,

                'nominal_dp' => 0,

                'catatan'
                    => $request->catatan,

                'total_dpp'
                    => $request->total_dpp,

                'ppn_total'
                    => ceil($request->ppn_total),

                'grand_total'
                    => $request->grand_total,

                'status'
                    => $status
            ]);

            HistoryTransaction::create([

                'invoice_id'
                    => $invoice->id,

                'nomor_invoice'
                    => $invoice->nomor_invoice,

                'tipe_transaksi'
                    => 'create',

                'nominal_sebelum'
                    => 0,

                'nominal_bayar'
                    => $invoice->nominal_dp,

                'nominal_setelah'
                    => $invoice->nominal_dp,

                'status_sebelum'
                    => null,

                'status_setelah'
                    => $invoice->status,

                'user_name'
                    => auth()->user()->name ?? 'System'
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

    public function updateJenisInvoice(Request $request, $id)
{
    $request->validate([
        'jenis_invoice' => 'required|in:dp,cicilan,pelunasan'
    ]);

    $invoice = Invoice::findOrFail($id);

    $invoice->update([
        'jenis_invoice' => $request->jenis_invoice
    ]);

    return redirect()
        ->back()
        ->with(
            'success',
            'Jenis invoice berhasil diubah'
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

         // simpan data sebelum update
        $nominalSebelum = $invoice->nominal_dp;
        $statusSebelum  = $invoice->status;

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

        HistoryTransaction::create([

            'invoice_id'
                => $invoice->id,

            'nomor_invoice'
                => $invoice->nomor_invoice,

            'tipe_transaksi'
                => 'payment',

            'nominal_sebelum'
                => $nominalSebelum,

            'nominal_bayar'
                => $request->nominal_dp,

            'nominal_setelah'
                => $totalDibayar,

            'status_sebelum'
                => $statusSebelum,

            'status_setelah'
                => $status,

            'user_name'
                => auth()->user()->name ?? 'System'
        ]);

        return redirect()
            ->route('invoice.show', $invoice->id)
            ->with(
                'success',
                'Pembayaran berhasil disimpan'
            );
    }

    public function exportExcel()
    {
        $invoices = Invoice::with([
            'customer',
            'details',
            'details.salesOrderDetail',
            'details.salesOrderDetail.item',
            'deliveryOrders'
        ])->get();

        $filename = "invoice-detail-" . date('Y-m-d') . ".xls";

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Pragma: no-cache");
        header("Expires: 0");

        echo "
        <table border='1'>
            <thead>
                <tr>
                    <th>No Invoice</th>
                    <th>Tanggal</th>
                    <th>Kode Transaksi</th>
                    <th>Customer</th>
                    <th>Jenis</th>
                    <th>Status</th>
                    <th>Delivery Order</th>
                    <th>Kode Item</th>
                    <th>Deskripsi Item</th>
                    <th>Qty</th>
                    <th>Satuan</th>
                    <th>Harga</th>
                    <th>Subtotal Item</th>
                    <th>Total DPP</th>
                    <th>PPN</th>
                    <th>Grand Total</th>
                    <th>DP</th>
                    <th>Catatan</th>
                </tr>
            </thead>
            <tbody>
        ";

        foreach ($invoices as $invoice) {

            $doList = $invoice->deliveryOrders->pluck('id')->join(',');

            foreach ($invoice->details as $detail) {

                $itemCode = $detail->salesOrderDetail?->item?->kd_item ?? '-';
                $itemDesc = $detail->salesOrderDetail?->item?->deskripsi ?? '-';
                $itemSatuan = $detail->salesOrderDetail?->item?->satuan ?? '-';

                echo "
                <tr>
                    <td>{$invoice->nomor_invoice}</td>
                    <td>{$invoice->tanggal_invoice}</td>
                    <td>{$invoice->kode_transaksi}</td>
                    <td>{$invoice->customer->nama_customer}</td>
                    <td>{$invoice->jenis_invoice}</td>
                    <td>{$invoice->status}</td>
                    <td>{$doList}</td>
                    <td>{$itemCode}</td>
                    <td>{$itemDesc}</td>
                    <td>{$detail->qty}</td>
                    <td>{$itemSatuan}</td>
                    <td>{$detail->harga}</td>
                    <td>{$detail->subtotal}</td>
                    <td>{$invoice->total_dpp}</td>
                    <td>{$invoice->ppn_total}</td>
                    <td>{$invoice->grand_total}</td>
                    <td>{$invoice->nominal_dp}</td>
                    <td>{$invoice->catatan}</td>
                </tr>
                ";
            }
        }

        echo "
            </tbody>
        </table>
        ";

        exit;
    }

    
}
