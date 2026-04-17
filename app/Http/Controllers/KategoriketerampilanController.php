<?php

namespace App\Http\Controllers;

use App\Models\KategoriKeterampilan;
use Illuminate\Http\Request;

class KategoriKeterampilanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $kategoris = KategoriKeterampilan::when($search, function ($query, $search) {
                $query->where('nama_kategori', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return view('admin.kategori-keterampilan.index', compact('kategoris', 'search'));
    }

    public function create()
    {
        return view('admin.kategori-keterampilan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|max:255',
        ]);

        KategoriKeterampilan::create($request->only('nama_kategori'));

        return redirect()->route('admin.kategori-keterampilan.index')
            ->with('success', 'Kategori keterampilan berhasil ditambahkan.');
    }

    public function show(KategoriKeterampilan $kategori_keterampilan)
    {
        return view('admin.kategori-keterampilan.show', compact('kategori_keterampilan'));
    }

    public function edit(KategoriKeterampilan $kategori_keterampilan)
    {
        return view('admin.kategori-keterampilan.edit', compact('kategori_keterampilan'));
    }

    public function update(Request $request, KategoriKeterampilan $kategori_keterampilan)
    {
        $request->validate([
            'nama_kategori' => 'required|max:255',
        ]);

        $kategori_keterampilan->update($request->only('nama_kategori'));

        return redirect()->route('admin.kategori-keterampilan.index')
            ->with('success', 'Kategori keterampilan berhasil diperbarui.');
    }

    public function destroy(KategoriKeterampilan $kategori_keterampilan)
    {
        $kategori_keterampilan->delete();

        return redirect()->route('admin.kategori-keterampilan.index')
            ->with('success', 'Kategori keterampilan berhasil dihapus.');
    }
}