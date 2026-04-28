<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use App\Models\Keterampilan;
use App\Models\KategoriKeterampilan;
use Illuminate\Http\Request;

class KeterampilanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $keterampilans = Keterampilan::with('warga.rt.rw.dusun', 'kategori')
            ->when($search, function ($query, $search) {
                $query->where('nama_keterampilan', 'like', "%{$search}%")
                    ->orWhereHas('warga', function ($q) use ($search) {
                        $q->where('nama', 'like', "%{$search}%")
                          ->orWhere('nik', 'like', "%{$search}%");
                    })
                    ->orWhereHas('kategori', function ($q) use ($search) {
                        $q->where('nama_kategori', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(10);

        return view('admin.keterampilan.index', compact('keterampilans', 'search'));
    }

    public function create()
    {
        $wargas = Warga::with('rt.rw.dusun')->get();
        $kategoris = KategoriKeterampilan::all();

        return view('admin.keterampilan.create', compact('wargas', 'kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'warga_id' => 'required|exists:wargas,id',
            'kategori_keterampilan_id' => 'required|exists:kategori_keterampilans,id',
            'nama_keterampilan' => 'required|max:255',
            'pengalaman' => 'nullable|max:255',
            'keterangan' => 'nullable',
        ]);

        Keterampilan::create($request->only([
            'warga_id',
            'kategori_keterampilan_id',
            'nama_keterampilan',
            'pengalaman',
            'keterangan',
        ]));

        return redirect()->route('admin.keterampilan.index')
            ->with('success', 'Data keterampilan berhasil ditambahkan.');
    }

    public function show(Keterampilan $keterampilan)
    {
        $keterampilan->load('warga.rt.rw.dusun', 'kategori');

        return view('admin.keterampilan.show', compact('keterampilan'));
    }

    public function edit(Keterampilan $keterampilan)
    {
        $wargas = Warga::with('rt.rw.dusun')->get();
        $kategoris = KategoriKeterampilan::all();

        return view('admin.keterampilan.edit', compact('keterampilan', 'wargas', 'kategoris'));
    }

    public function update(Request $request, Keterampilan $keterampilan)
    {
        $request->validate([
            'warga_id' => 'required|exists:wargas,id',
            'kategori_keterampilan_id' => 'required|exists:kategori_keterampilans,id',
            'nama_keterampilan' => 'required|max:255',
            'pengalaman' => 'nullable|max:255',
            'keterangan' => 'nullable',
        ]);

        $keterampilan->update($request->only([
            'warga_id',
            'kategori_keterampilan_id',
            'nama_keterampilan',
            'pengalaman',
            'keterangan',
        ]));

        return redirect()->route('admin.keterampilan.index')
            ->with('success', 'Data keterampilan berhasil diperbarui.');
    }

    public function destroy(Keterampilan $keterampilan)
    {
        $keterampilan->delete();

        return redirect()->route('admin.keterampilan.index')
            ->with('success', 'Data keterampilan berhasil dihapus.');
    }
}