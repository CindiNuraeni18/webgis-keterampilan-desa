<?php

namespace App\Http\Controllers;

use App\Models\Dusun;
use App\Models\Rw;
use Illuminate\Http\Request;

class RwController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $rws = Rw::with('dusun')
            ->when($search, function ($query, $search) {
                $query->where('nomor_rw', 'like', "%{$search}%")
                      ->orWhereHas('dusun', function ($q) use ($search) {
                          $q->where('nama_dusun', 'like', "%{$search}%");
                      });
            })
            ->latest()
            ->paginate(10);

        return view('admin.rw.index', compact('rws', 'search'));
    }

    public function create()
    {
        $dusuns = Dusun::all();
        return view('admin.rw.create', compact('dusuns'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'dusun_id' => 'required|exists:dusuns,id',
            'nomor_rw' => 'required|max:10',
        ]);

        Rw::create($request->only('dusun_id', 'nomor_rw'));

        return redirect()->route('admin.rw.index')
            ->with('success', 'Data RW berhasil ditambahkan.');
    }

    public function show(Rw $rw)
    {
        $rw->load('dusun');
        return view('admin.rw.show', compact('rw'));
    }

    public function edit(Rw $rw)
    {
        $dusuns = Dusun::all();
        return view('admin.rw.edit', compact('rw', 'dusuns'));
    }

    public function update(Request $request, Rw $rw)
    {
        $request->validate([
            'dusun_id' => 'required|exists:dusuns,id',
            'nomor_rw' => 'required|max:10',
        ]);

        $rw->update($request->only('dusun_id', 'nomor_rw'));

        return redirect()->route('admin.rw.index')
            ->with('success', 'Data RW berhasil diperbarui.');
    }

    public function destroy(Rw $rw)
    {
        $rw->delete();

        return redirect()->route('admin.rw.index')
            ->with('success', 'Data RW berhasil dihapus.');
    }
}