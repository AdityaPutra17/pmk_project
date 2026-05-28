<?php

namespace App\Http\Controllers;

use App\Models\Delivery_orders;
use App\Models\Sales_orders;
use App\Models\Sales_order_details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeliveryOrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $deliveryOrders = Delivery_orders::with([
            'sales_order',
            'customer',
            'item'
        ])->get();

        $salesOrders = Sales_orders::with([
            'customer',
            'details.item'
        ])->get();

        return view(
            'admin.transaksi.do.index',
            compact('deliveryOrders', 'salesOrders')
        );
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([

            'sales_order_id'         => 'required|exists:sales_orders,id',

            'sales_order_detail_id'  => 'required|exists:sales_order_details,id',

            'customer_id'            => 'required|exists:customers,id',

            'item_id'                => 'required|exists:items,id',

            'qty'                    => 'required|numeric|min:1',

            'catatan'                => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {

            // generate nomor DO
            $lastDO = Delivery_orders::latest()->first();

            $nextNumber = $lastDO
                ? $lastDO->id + 1
                : 1;

            $nomorDO =
                'DO' .
                now()->format('y') .
                str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

            // ambil detail SO
            $detailSO = Sales_order_details::findOrFail(
                $request->sales_order_detail_id
            );

            // validasi qty
            $sisaQty =
                $detailSO->qty -
                $detailSO->qty_delivered;

            if ($request->qty > $sisaQty) {

                return back()->with(
                    'error',
                    'Qty delivery melebihi sisa qty SO.'
                );
            }

            // create DO
            Delivery_orders::create([

                'nomor_do'               => $nomorDO,

                'tanggal_do'             => now(),

                'sales_order_id'         => $request->sales_order_id,

                'sales_order_detail_id'  => $request->sales_order_detail_id,

                'customer_id'            => $request->customer_id,

                'item_id'                => $request->item_id,

                'nomor_po'               => $detailSO
                                                ->sales_order
                                                ->nomor_po,

                'qty'                    => $request->qty,

                'catatan'                => $request->catatan,

                'status'                 => 'done',
            ]);

            // update qty delivered
            $detailSO->increment(
                'qty_delivered',
                $request->qty
            );

            DB::commit();

            return redirect()
                ->route('delivery-orders.index')
                ->with(
                    'success',
                    'Delivery Order berhasil dibuat.'
                );

        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with(
                    'error',
                    $e->getMessage()
                );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Delivery_orders $delivery_orders)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Delivery_orders $delivery_orders)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Delivery_orders $delivery_orders)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Delivery_orders $delivery_orders)
    {
        //
    }
}
