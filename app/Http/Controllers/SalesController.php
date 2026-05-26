<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use App\Models\Area;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $sales = Sales::with('area')->get();
        $areas = Area::all();
        return view('admin.sales.index', compact('sales', 'areas'));
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
                'phone' => 'required|string|max:255',
                'area_id' => 'required|exists:areas,id',
            ]);
    
            // Tahun 2 digit
            $year = date('y'); // contoh: 26
    
            // Ambil kode terakhir tahun ini
            $lastSales = Sales::where('kd_sales', 'like', 'SLS'.$year.'%')
                ->orderBy('kd_sales', 'desc')
                ->first();
    
            if ($lastSales) {
                // Ambil angka urutan terakhir
                $lastNumber = (int) substr($lastSales->kd_sales, -2);
                $newNumber = $lastNumber + 1;
            } else {
                $newNumber = 1;
            }
    
            // Format 2 digit
            $sequence = str_pad($newNumber, 2, '0', STR_PAD_LEFT);
    
            // Generate kode
            $kd_sales = 'SLS' . $year . $sequence;
    
            Sales::create([
                'name' => strtoupper($request->name),
                'kd_sales' => $kd_sales,
                'phone' => $request->phone,
                'area_id' => $request->area_id,
            ]);
    
            return redirect()
                ->route('sales.index')
                ->with('success', 'Sales created successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->route('sales.index')
                ->with('error', 'Failed to create sales.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Sales $sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sales $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sales $sale)
    {
        try{

            $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:255',
                'area_id' => 'required|exists:areas,id',
            ]);
    
            $sale->update([
                'name' => strtoupper($request->name),
                'phone' => $request->phone,
                'area_id' => $request->area_id,
            ]);
    
            // dd($sales->fresh());
    
            return redirect()
                ->route('sales.index')
                ->with('success', 'Sales updated successfully.');
        }catch (\Exception $e) {
            return redirect()
                ->route('sales.index')
                ->with('error', 'Failed to update sales.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sales $sale)
    {
        //
        try {
            $sale->delete();
            return redirect()->route('sales.index')->with('success', 'Sales deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('sales.index')->with('error', 'Failed to delete sales.');
        }
    }
}
