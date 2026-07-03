<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $areas = Area::paginate(15);
        return view('admin.area.index', compact('areas'));
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
        $request->validate([
            'name' => 'required|string|max:255',
            'kd_area' => 'required|string|max:255|unique:areas,kd_area',
        ]);

        Area::create([
            // 'name' => $request->name,
            'name' => strtoupper($request->name),
            'kd_area' => strtoupper($request->kd_area),
        ]);

        return redirect()->route('area.index')->with('success', 'Area created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Area $area)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Area $area)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Area $area)
    {
        //
        $request->validate([
            'name' => 'required|string|max:255',
            'kd_area' => 'required|string|max:255|unique:areas,kd_area,' . $area->id,
        ]);

        $area->update([
            'name' => strtoupper($request->name),
            'kd_area' => strtoupper($request->kd_area),
        ]);

        return redirect()->route('area.index')->with('success', 'Area updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Area $area)
    {
        //
        $area->delete();
        return redirect()->route('area.index')->with('success', 'Area deleted successfully.');
    }
}
