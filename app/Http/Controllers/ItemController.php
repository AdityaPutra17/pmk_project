<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemCategories;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $items = Item::with('category')->get();
        $categories = ItemCategories::all();
        return view('admin.items.index', compact('items', 'categories'));
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
        //
        try {

            $request->validate([
                'category_id' => 'required|exists:item_categories,id',
                'harga' => 'required|numeric',
                'satuan' => 'required|string|max:255',
                'deskripsi' => 'required|string',
            ]);

            // ambil category
            $category = ItemCategories::findOrFail($request->category_id);

            // kode kategori
            $categoryCode = strtoupper($category->kd_category);

            // tahun 2 digit
            $year = date('y');

            // prefix contoh: LB26
            $prefix = $categoryCode . $year;

            // cari item terakhir berdasarkan prefix
            $lastItem = Item::where('kd_item', 'like', $prefix . '%')
                ->orderBy('kd_item', 'desc')
                ->first();

            if ($lastItem) {

                // ambil 4 digit terakhir
                $lastNumber = (int) substr($lastItem->kd_item, -4);

                $newNumber = $lastNumber + 1;

            } else {

                $newNumber = 1;
            }

            // format 4 digit
            $sequence = str_pad($newNumber, 4, '0', STR_PAD_LEFT);

            // hasil akhir
            $kd_item = $prefix . $sequence;

            Item::create([
                'kd_item' => $kd_item,
                'category_id' => $request->category_id,
                'harga' => $request->harga,
                'satuan' => strtoupper($request->satuan),
                'deskripsi' => strtoupper($request->deskripsi),
            ]);

            return redirect()
                ->route('items.index')
                ->with('success', 'Item created successfully.');

        } catch (\Exception $e) {

            return redirect()
                ->route('items.index')
                ->with('error', 'Failed to create Item: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        //
        try{

            $request->validate([
                'kd_item' => 'required|string|max:255|unique:items,kd_item,' . $item->id,
                'category_id' => 'required|exists:item_categories,id',
                'harga' => 'required|numeric',
                'satuan' => 'required|string|max:255',
                'deskripsi' => 'required|string',
            ]);
    
            $item->update([
                'kd_item' => strtoupper($request->kd_item),
                'category_id' => $request->category_id,
                'harga' => $request->harga,
                'satuan' => strtoupper($request->satuan),
                'deskripsi' => strtoupper($request->deskripsi),
            ]);
    
            return redirect()->route('items.index')->with('success', 'Item updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('items.index')->with('error', 'Failed to update Item: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        //
        try {
            $item->delete();
            return redirect()->route('items.index')->with('success', 'Item deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('items.index')->with('error', 'Failed to delete Item: ' . $e->getMessage());
        }
    }
}
