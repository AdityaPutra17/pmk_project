<?php

namespace App\Http\Controllers;

use App\Models\Top;
use Illuminate\Http\Request;

class TopController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $tops = Top::when($search, function($query) use ($search) {
            $query->where('code', 'like', '%'.$search.'%')
                  ->orWhere('description', 'like', '%'.$search.'%');
        })->latest()->paginate(15)->appends(['search' => $search]);
        $newTopCode = $this->generateTopCode();

        return view('admin.po.top.index', compact('tops', 'newTopCode', 'search'));
    }

    public function create()
    {
        return redirect()->route('top.index');
    }

    private function generateTopCode()
    {
        $year = date('y');

        $lastTop = Top::where('code', 'like', 'TOP' . $year . '%')
            ->orderBy('code', 'desc')
            ->first();

        if ($lastTop) {
            $lastNumber = (int) substr($lastTop->code, -4);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        return 'TOP' . $year . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
        ]);

        $validated['code'] = $this->generateTopCode();
        Top::create($validated);

        return redirect()->route('top.index')->with('success', 'TOP berhasil disimpan.');
    }

    public function show(Top $top)
    {
        return redirect()->route('top.index');
    }

    public function edit(Top $top)
    {
        return redirect()->route('top.index');
    }

    public function update(Request $request, Top $top)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
        ]);

        $top->update($validated);

        return redirect()->route('top.index')->with('success', 'TOP berhasil diperbarui.');
    }

    public function destroy(Top $top)
    {
        $top->delete();

        return redirect()->route('top.index')->with('success', 'TOP berhasil dihapus.');
    }
}
