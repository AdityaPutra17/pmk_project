<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $suppliers = Supplier::when($search, function($query) use ($search) {
            $query->where('name', 'like', '%'.$search.'%')
                  ->orWhere('supplier_code', 'like', '%'.$search.'%')
                  ->orWhere('address', 'like', '%'.$search.'%')
                  ->orWhere('phone', 'like', '%'.$search.'%');
        })->latest()->paginate(15)->appends(['search' => $search]);

        return view('admin.po.supplier.index', compact('suppliers', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('suppliers.index');
    }

    private function generateSupplierCode()
    {
        $year = date('y'); // 26

        $lastSupplier = Supplier::where('supplier_code', 'like', 'EP'.$year.'%')
            ->orderBy('supplier_code', 'desc')
            ->first();

        if ($lastSupplier) {
            $lastNumber = (int) substr($lastSupplier->supplier_code, -4);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        return 'EP' . $year . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:50',
            'pic' => 'nullable|string|max:255',
        ]);

        $validated['supplier_code'] = $this->generateSupplierCode();

        Supplier::create($validated);

        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        return redirect()->route('suppliers.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        return redirect()->route('suppliers.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'supplier_code' => 'required|string|max:50|unique:suppliers,supplier_code,' . $supplier->id,
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:50',
            'pic' => 'nullable|string|max:255',
        ]);

        $supplier->update($validated);

        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return redirect()->route('suppliers.index')->with('success', 'Supplier berhasil dihapus.');
    }
}
