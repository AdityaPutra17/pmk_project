<?php

namespace App\Http\Controllers;

use App\Models\Delivery_orders;
use App\Models\Delivery_order_details;
use App\Models\Sales_orders;
use App\Models\Sales_order_details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeliveryOrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $deliveryOrders = Delivery_orders::with([
            'sales_order',
            'customer',
            'details.item',
        ])->when($search, function($query) use ($search) {
            $query->where('nomor_do', 'like', '%'.$search.'%')
                  ->orWhereHas('customer', function($q) use ($search) {
                      $q->where('nama_customer', 'like', '%'.$search.'%');
                  });
        })->paginate(15)->appends(['search' => $search]);

        $salesOrders = Sales_orders::with([
            'customer',
            'details.item'
        ])->get();

        return view(
            'admin.transaksi.do.index',
            compact('deliveryOrders', 'salesOrders', 'search')
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

            'sales_order_id' => 'required|exists:sales_orders,id',

            'customer_id' => 'required|exists:customers,id',

            'details' => 'required|array',

            'details.*.sales_order_detail_id'
                => 'required|exists:sales_order_details,id',

            'details.*.item_id'
                => 'required|exists:items,id',

            'details.*.qty'
                => 'nullable|numeric|min:0',
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

            // create header DO
            $do = Delivery_orders::create([

                'nomor_do' => $nomorDO,

                'tanggal_do' => now(),

                'sales_order_id' => $request->sales_order_id,

                'customer_id' => $request->customer_id,

                'nomor_po' => Sales_orders::find(
                    $request->sales_order_id
                )->nomor_po,

                'catatan' => $request->catatan,

                'status' => 'done',
            ]);

            // loop detail
            foreach ($request->details as $detail) {

                if (
                    empty($detail['qty']) ||
                    $detail['qty'] <= 0
                ) {
                    continue;
                }

                $detailSO = Sales_order_details::findOrFail(
                    $detail['sales_order_detail_id']
                );

                $sisaQty =
                    $detailSO->qty -
                    $detailSO->qty_delivered;

                if ($detail['qty'] > $sisaQty) {

                    throw new \Exception(
                        'Qty delivery melebihi sisa qty.'
                    );
                }

                Delivery_order_details::create([

                    'delivery_order_id' =>
                        $do->id,

                    'sales_order_detail_id' =>
                        $detail['sales_order_detail_id'],

                    'item_id' =>
                        $detail['item_id'],

                    'qty' =>
                        $detail['qty'],
                ]);

                $detailSO->increment(
                    'qty_delivered',
                    $detail['qty']
                );
            }

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

    public function print($id)
    {
        $do = Delivery_orders::with([
            'details.item',
            'customer',
            'sales_order'
        ])->findOrFail($id);

        return view(
            'admin.transaksi.do.print',
            compact('do')
        );
    }
}
