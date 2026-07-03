<?php

namespace App\Http\Controllers;

use App\Models\Jenis_Item_PO;
use Illuminate\Http\Request;

class JenisItemPOController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $jenisItems = Jenis_Item_PO::when($search, function($query) use ($search) {
            $query->where('name', 'like', '%'.$search.'%')
                  ->orWhere('code', 'like', '%'.$search.'%');
        })->latest()->paginate(15)->appends(['search' => $search]);

        return view('admin.po.jenisitempo.index', compact('jenisItems', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('jenis-item.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:jenis__item__p_o_s,code',
        ]);

        Jenis_Item_PO::create($validated);

        return redirect()->route('jenis-item.index')->with('success', 'Jenis Item PO berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Jenis_Item_PO $jenis_item)
    {
        return redirect()->route('jenis-item.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jenis_Item_PO $jenis_item)
    {
        return redirect()->route('jenis-item.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jenis_Item_PO $jenis_item)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:jenis__item__p_o_s,code,' . $jenis_item->id,
            'name' => 'required|string|max:255',
        ]);

        $jenis_item->update($validated);

        return redirect()->route('jenis-item.index')->with('success', 'Jenis Item PO berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jenis_Item_PO $jenis_item)
    {
        $jenis_item->delete();

        return redirect()->route('jenis-item.index')->with('success', 'Jenis Item PO berhasil dihapus.');
    }
}
