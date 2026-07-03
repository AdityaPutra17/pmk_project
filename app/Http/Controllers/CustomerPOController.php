<?php

namespace App\Http\Controllers;

use App\Models\CustomerPO;
use Illuminate\Http\Request;

class CustomerPOController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customerpos = CustomerPO::latest()->paginate(15);

        return view('admin.po.customerpo.index', compact('customerpos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('customerpos.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_code' => 'required|string|max:50|unique:customer_p_o_s,customer_code',
            'name' => 'required|string|max:255',
        ]);

        CustomerPO::create($validated);

        return redirect()->route('customerpos.index')->with('success', 'Customer PO berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CustomerPO $customerPO)
    {
        return redirect()->route('customerpos.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CustomerPO $customerPO)
    {
        return redirect()->route('customerpos.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $customerPO = CustomerPO::findOrFail($id);
        // dd($request->all());
        $validated = $request->validate([
            'customer_code' => 'required|string|max:50|unique:customer_p_o_s,customer_code,' . $id,
            'name' => 'required|string|max:255',
        ]);

        $customerPO->update($validated);

        return redirect()->route('customerpos.index')->with('success', 'Customer PO berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $customerPO = CustomerPO::findOrFail($id);

        $customerPO->delete();

        return redirect()
            ->route('customerpos.index')
            ->with('success', 'Customer PO berhasil dihapus.');
    }
}
