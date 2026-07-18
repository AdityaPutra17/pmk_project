<?php

namespace App\Http\Controllers;

use App\Models\ItemPO;
use App\Models\Jenis_Item_PO;
use Illuminate\Http\Request;

class ItemPOController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $itemPOs = ItemPO::with('itemType')->when($search, function($query) use ($search) {
            $query->where('item_code', 'like', '%'.$search.'%')
                  ->orWhere('description', 'like', '%'.$search.'%');
        })->latest()->paginate(15)->appends(['search' => $search]);
        $jenisItems = Jenis_Item_PO::orderBy('name')->get();
        $newItemCode = $this->generateItemCode();

        return view('admin.po.itempo.index', compact('itemPOs', 'jenisItems', 'newItemCode', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('item-po.index');
    }

    private function generateItemCode()
    {
        $year = date('y');

        $lastItem = ItemPO::where('item_code', 'like', 'IP' . $year . '%')
            ->orderBy('item_code', 'desc')
            ->first();

        if ($lastItem) {
            $lastNumber = (int) substr($lastItem->item_code, -4);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        return 'IP' . $year . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_jenis_item_po' => 'required|exists:jenis__item__p_o_s,id',
            'description' => 'required|string|max:65535',
        ]);

        $validated['item_code'] = $this->generateItemCode();

        ItemPO::create($validated);

        return redirect()->route('item-po.index')->with('success', 'Item PO berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ItemPO $itemPO)
    {
        return redirect()->route('item-po.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ItemPO $itemPO)
    {
        return redirect()->route('item-po.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $itemPO = ItemPO::findOrFail($id);
        // 1. Validasi request input
        $validated = $request->validate([
            'id_jenis_item_po' => 'required|exists:jenis__item__p_o_s,id',
            'description' => 'required|string|max:65535',
        ]);

        // 2. Lakukan update data pada database
        $itemPO->update($validated);

        // 3. Kembalikan ke halaman index dengan notifikasi
        return redirect()->route('item-po.index')->with('success', 'Item PO berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $itemPO = ItemPO::findOrFail($id);
        try{
            $itemPO->delete();
            return redirect()->route('item-po.index')->with('success', 'Item Deleted Successfully');
        } catch (\Exception $e){
                return redirect()->route('item-po.index')->with('error', 'Failed to delete Item: ' .$e->getMessage());
        }

    }
}
