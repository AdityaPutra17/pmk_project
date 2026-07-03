<?php

namespace App\Http\Controllers;


use App\Models\Sales_orders;
use App\Models\Sales_order_details;
use App\Models\Customer;
use App\Models\Sales;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesOrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $search = $request->input('search');
        $salesOrders = Sales_orders::with([ 'customer', 'sales', 'details.item' ])->when($search, function($query) use ($search) {
            $query->where('nomor_so', 'like', '%'.$search.'%')
                  ->orWhereHas('customer', function($q) use ($search) {
                      $q->where('nama_customer', 'like', '%'.$search.'%');
                  });
        })->latest()->paginate(15)->appends(['search' => $search]);
        $customers = Customer::all();
        $sales = Sales::all();
        $items = Item::all();

        return view('admin.transaksi.so.index', compact('salesOrders', 'customers', 'sales', 'items', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([

            'customer_id'       => 'required|exists:customers,id',
            'sales_id'          => 'required|exists:sales,id',
            'tanggal_so'        => 'required|date',
            'delivery_request'  => 'nullable|date',
            'nomor_po'          => 'nullable|string|max:255',

            'items'             => 'required|array|min:1',

            'items.*.item_id'   => 'required|exists:items,id',
            'items.*.qty'       => 'required|numeric|min:1',
            'items.*.harga'     => 'required|numeric|min:0',

            'jenis_pajak' => 'required|in:ppn,non_ppn',

        ]);

        DB::beginTransaction();

        try {

            // Generate Nomor SO
            $lastSO = Sales_orders::latest()->first();

            $nextNumber = $lastSO
                ? $lastSO->id + 1
                : 1;

            $year = date('y');

            $nomorSO =
                'SO' .
                $year .
                '' .
                str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

            // Create Header
            $salesOrder = Sales_orders::create([
                'nomor_so'         => $nomorSO,
                'tanggal_so'       => $request->tanggal_so,
                'tahun'            => date('Y'),
                'customer_id'      => $request->customer_id,
                'sales_id'         => $request->sales_id,
                'nomor_po'         => $request->nomor_po,
                'delivery_request' => $request->delivery_request,
                'std_lead_time'    => 16,
                'status'           => 'draft',
                'total_dpp'        => 0,
                'ppn_total'        => 0,
                'grand_total'      => 0,
            ]);

            $totalDpp = 0;

            foreach ($request->items as $item) {

                $subtotal =
                    $item['qty'] * $item['harga'];

                if ($request->jenis_pajak == 'ppn') {

                    $ppn = $subtotal * 0.11;
                    $totalAfterPPN = $subtotal + $ppn;

                } else {

                    $ppn = 0;
                    $totalAfterPPN = $subtotal;

                }

                $salesOrder->details()->create([
                    'item_id'          => $item['item_id'],
                    'qty'              => $item['qty'],
                    'harga'            => $item['harga'],
                    'subtotal'         => $subtotal,
                    'ppn'              => $ppn,
                    'total_after_ppn' => $totalAfterPPN,
                ]);

                $totalDpp += $subtotal;
            }

            
            // PPN 11%
            if ($request->jenis_pajak == 'ppn') {

                $ppnTotal = $totalDpp * 0.11;
                $grandTotal = $totalDpp + $ppnTotal;

            } else {

                $ppnTotal = 0;
                $grandTotal = $totalDpp;

            }

            $salesOrder->update([

                'total_dpp'   => $totalDpp,

                'ppn_total'   => $ppnTotal,

                'grand_total' => $grandTotal,
            ]);

            DB::commit();

            return redirect()
                ->route('admin.transaksi.so.index')
                ->with('success', 'Sales Order berhasil dibuat.');

        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Sales_orders $sales_orders)
    {
        //
       
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sales_orders $sales_orders)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sales_orders $sales_orders)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $salesOrder = Sales_orders::findOrFail($id);

        DB::transaction(function () use ($salesOrder) {

        // hapus detail delivery
        foreach ($salesOrder->details as $detail) {
            $detail->deliveryDetails()->delete();
        }

        // hapus detail SO
        $salesOrder->details()->delete();

        // hapus Delivery Order
        $salesOrder->deliveryOrders()->delete();

        // terakhir hapus SO
        $salesOrder->delete();
    });

        return redirect()
            ->route('sales-orders.index')
            ->with('success', 'Sales Order berhasil dihapus.');
    }
}
