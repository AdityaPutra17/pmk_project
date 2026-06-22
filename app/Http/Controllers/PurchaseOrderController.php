<?php

namespace App\Http\Controllers;

use App\Models\Franco;
use App\Models\PurchaseOrder;
use App\Models\CustomerPO;
use App\Models\Supplier;
use App\Models\Top;
use App\Models\ItemPO;
use App\Models\PurchaseOrderDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        $purchaseOrders = PurchaseOrder::with(['supplier', 'customer', 'top', 'franco'])->latest()->get();
        $suppliers = Supplier::orderBy('name')->get();
        $customers = CustomerPO::orderBy('name')->get();
        $tops = Top::orderBy('description')->get();
        $francos = Franco::orderBy('name')->get();
        $items = ItemPO::orderBy('description')->get();

        return view('admin.po.index', compact('purchaseOrders', 'suppliers', 'customers', 'tops', 'francos', 'items'));
    }

    public function create()
    {
        return redirect()->route('po.index');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([

            'po_number' => 'required|unique:purchase_orders',

            'supplier_id' => 'required',

            'customer_id' => 'required',

            'items' => 'required|array|min:1'
        ]);

        DB::transaction(function() use ($request){

            $subtotal = 0;

            foreach($request->items as $item)
            {
                $subtotal +=
                    $item['qty'] *
                    $item['price'];
            }

            $tax =
                $request->ppn == 'Ya'
                ? $subtotal * 0.11
                : 0;

            $grandTotal =
                $subtotal + $tax;

            $po = PurchaseOrder::create([

                'po_number' => $request->po_number,
                'po_date' => $request->po_date,

                'supplier_id' => $request->supplier_id,
                'customer_id' => $request->customer_id,

                'delivery_date' => $request->delivery_date,

                'top_id' => $request->top_id,
                'franco_id' => $request->franco_id,

                'ppn' => $request->ppn,

                'subtotal' => $subtotal,
                'tax' => $tax,
                'grand_total' => $grandTotal,

                'notes' => $request->notes
            ]);

            foreach($request->items as $row)
            {
                $item = ItemPO::find($row['item_id']);

                PurchaseOrderDetail::create([

                    'purchase_order_id' => $po->id,

                    'item_id' => $item->id,

                    'description' => $item->description,

                    'qty' => $row['qty'],

                    'price' => $row['price'],

                    'total' =>
                        $row['qty'] *
                        $row['price']
                ]);
            }
        });

        return redirect()
            ->route('po.index')
            ->with(
                'success',
                'Purchase Order berhasil dibuat'
            );
    }

    public function show(PurchaseOrder $purchaseOrder)
    {
        return redirect()->route('po.index');
    }

    public function edit(PurchaseOrder $purchaseOrder)
    {
        return redirect()->route('po.index');
    }

    public function update(Request $request, PurchaseOrder $purchaseOrder)
    {
        $validated = $request->validate([
            'po_number' => 'required|string|max:100|unique:purchase_orders,po_number,' . $purchaseOrder->id,
            'po_date' => 'required|date',
            'supplier_id' => 'required|exists:suppliers,id',
            'customer_id' => 'required|exists:customers,id',
            'delivery_date' => 'nullable|date',
            'top_id' => 'nullable|exists:tops,id',
            'franco_id' => 'nullable|exists:francos,id',
            'ppn' => 'required|in:Ya,Tidak',
            'subtotal' => 'required|numeric|min:0',
            'tax' => 'required|numeric|min:0',
            'grand_total' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $purchaseOrder->update($validated);

        return redirect()->route('po.index')->with('success', 'Purchase Order berhasil diperbarui.');
    }

    public function destroy(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->delete();

        return redirect()->route('po.index')->with('success', 'Purchase Order berhasil dihapus.');
    }

    public function print($id)
    {
        $po = PurchaseOrder::with([
            'supplier',
            'customer',
            'details.item',
            'top',
            'franco'
        ])->findOrFail($id);

        if ($po->supplier->name === 'pt berkah 1234') {
            return view('admin.po.print2', compact('po'));
        }


        return view('admin.po.print', compact('po'));
    }
}
