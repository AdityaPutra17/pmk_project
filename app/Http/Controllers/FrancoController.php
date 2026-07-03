<?php

namespace App\Http\Controllers;

use App\Models\Franco;
use Illuminate\Http\Request;

class FrancoController extends Controller
{
    public function index()
    {
        $francos = Franco::latest()->paginate(15);

        return view('admin.po.franco.index', compact('francos'));
    }

    public function create()
    {
        return redirect()->route('franco.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Franco::create($validated);

        return redirect()->route('franco.index')->with('success', 'Franco berhasil disimpan.');
    }

    public function show(Franco $franco)
    {
        return redirect()->route('franco.index');
    }

    public function edit(Franco $franco)
    {
        return redirect()->route('franco.index');
    }

    public function update(Request $request, Franco $franco)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $franco->update($validated);

        return redirect()->route('franco.index')->with('success', 'Franco berhasil diperbarui.');
    }

    public function destroy(Franco $franco)
    {
        $franco->delete();

        return redirect()->route('franco.index')->with('success', 'Franco berhasil dihapus.');
    }
}
