<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Sales;
use App\Models\Area;
use Illuminate\Http\Request;


class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        
        // $customers = Customer::with('sales', 'area')->get();\
        $customers = Customer::paginate(15);
        $sales = Sales::with('area')->get();
        $areas = Area::all();
        return view('admin.customers.index', compact('customers', 'sales', 'areas'));
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
                'nama_customer' => 'required|string|max:255|unique:customers',
                // 'kd_customer' => 'required|string|max:255|unique:customers',
                'alamat' => 'required|string',
                'npwp' => 'required|string|max:255',
                'no_telp' => 'required|string|max:20',
                'sales_id' => 'required|exists:sales,id',
                'area_id' => 'required|exists:areas,id',
            ]);

            $year = date('y'); // contoh: 26
            $lastCustomer = Customer::where('kd_customer', 'like', 'CST'.$year.'%')
                ->orderBy('kd_customer', 'desc')
                ->first();

            if ($lastCustomer) {
                $lastNumber = (int) substr($lastCustomer->kd_customer, -2);
                $newNumber = $lastNumber + 1;
            } else {
                $newNumber = 1;
            }

            $sequence = str_pad($newNumber, 4, '0', STR_PAD_LEFT);
            $kd_customer = 'CST' . $year . $sequence;

            Customer::create([
                'nama_customer' => strtoupper($request->nama_customer),
                'kd_customer' => $kd_customer,
                'alamat' => $request->alamat,
                'npwp' => $request->npwp,
                'no_telp' => $request->no_telp,
                'sales_id' => $request->sales_id,
                'area_id' => $request->area_id,
            ]);

            return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('customers.index')->with('error', 'Failed to create customer: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        //
        $request->validate([
            'nama_customer' => 'required|string|max:255',
            'kd_customer' => 'required|string|max:255|unique:customers,kd_customer,' . $customer->id,
            'alamat' => 'required|string',
            'npwp' => 'required|string|max:255',
            'no_telp' => 'required|string|max:20',
            'sales_id' => 'required|exists:sales,id',
            'area_id' => 'required|exists:areas,id',
        ]);

        $customer->update($request->all());
        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }
}
