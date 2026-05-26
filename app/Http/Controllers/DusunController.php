<?php

namespace App\Http\Controllers;

use App\Models\Dusun;
use Illuminate\Http\Request;

class DusunController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $dusuns = Dusun::when($search, function ($query, $search) {
                $query->where('nama_dusun', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return view('admin.dusun.index', compact('dusuns', 'search'));
    }

    public function create()
    {
        return view('admin.dusun.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'nama_dusun' => 'required|max:255',
        'geojson' => 'nullable|file',
    ]);

   $geojsonPath = null;

if ($request->hasFile('geojson')) {

    $geojsonPath = $request
        ->file('geojson')
        ->store('geojson-dusun', 'public');
}

Dusun::create([
    'nama_dusun' => $request->nama_dusun,
    'geojson' => $geojsonPath,
]);
    return redirect()->route('admin.dusun.index')
        ->with('success', 'Data dusun berhasil ditambahkan.');
}
    public function show(Dusun $dusun)
    {
        return view('admin.dusun.show', compact('dusun'));
    }

    public function edit(Dusun $dusun)
    {
        return view('admin.dusun.edit', compact('dusun'));
    }

    public function update(Request $request, Dusun $dusun)
{
    $request->validate([
        'nama_dusun' => 'required|max:255',
         'geojson' => 'nullable|file',
    ]);

  $geojsonPath = $dusun->geojson;

if ($request->hasFile('geojson')) {

    $geojsonPath = $request
        ->file('geojson')
        ->store('geojson-dusun', 'public');
}

$dusun->update([
    'nama_dusun' => $request->nama_dusun,
    'geojson' => $geojsonPath,
]);

    return redirect()->route('admin.dusun.index')
        ->with('success', 'Data dusun berhasil diperbarui.');
}

    public function destroy(Dusun $dusun)
    {
        $dusun->delete();

        return redirect()->route('admin.dusun.index')
            ->with('success', 'Data dusun berhasil dihapus.');
    }
}
