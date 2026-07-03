<?php

namespace App\Http\Controllers;

use App\Models\ItemCategories;
use Illuminate\Http\Request;

class ItemCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $itemCategories = ItemCategories::paginate(15);
        return view('admin.itemcategories.index', compact('itemCategories'));
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
        try{

            $request->validate([
                'name' => 'required|string|max:255',
                'kd_category' => 'required|string|max:255|unique:item_categories,kd_category',
            ]);
    
            ItemCategories::create([
                'name' => strtoupper($request->name),
                'kd_category' => strtoupper($request->kd_category),
            ]);
    
            return redirect()->route('item-categories.index')->with('success', 'Item Category created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('item-categories.index')->with('error', 'Failed to create Item Category: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ItemCategories $itemCategories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ItemCategories $itemCategories)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ItemCategories $itemCategory)
    {
        //
        try{

            $request->validate([
                'name' => 'required|string|max:255',
                'kd_category' => 'required|string|max:255|unique:item_categories,kd_category,' . $itemCategory->id,
            ]);
    
            $itemCategory->update([
                'name' => strtoupper($request->name),
                'kd_category' => strtoupper($request->kd_category),
            ]);
    
            return redirect()->route('item-categories.index')->with('success', 'Item Category updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('item-categories.index')->with('error', 'Failed to update Item Category: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ItemCategories $itemCategory)
    {
        //
        try {
            $itemCategory->delete();
            return redirect()->route('item-categories.index')->with('success', 'Item Category deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('item-categories.index')->with('error', 'Failed to delete Item Category: ' . $e->getMessage());
        }
    }
}
