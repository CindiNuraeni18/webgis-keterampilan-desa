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
    'nama_kategori' =>
        'required|max:255|unique:kategori_keterampilans,nama_kategori',
],[
    'nama_kategori.required' =>
        'Nama kategori wajib diisi.',

    'nama_kategori.unique' =>
        'Kategori sudah ada.',

    'nama_kategori.max' =>
        'Nama kategori maksimal 255 karakter.',
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
    'nama_kategori' =>
        'required|max:255|unique:kategori_keterampilans,nama_kategori,' .
        $kategori_keterampilan->id,
],[
    'nama_kategori.required' =>
        'Nama kategori wajib diisi.',

    'nama_kategori.unique' =>
        'Kategori sudah ada.',

    'nama_kategori.max' =>
        'Nama kategori maksimal 255 karakter.',
]);

        $kategori_keterampilan->update($request->only('nama_kategori'));

        return redirect()->route('admin.kategori-keterampilan.index')
            ->with('success', 'Kategori keterampilan berhasil diperbarui.');
    }

    public function destroy(
    KategoriKeterampilan $kategori_keterampilan
)
{
    if(
        $kategori_keterampilan
            ->keterampilans()
            ->count() > 0
    ){

        return redirect()
            ->route(
                'admin.kategori-keterampilan.index'
            )
            ->with(
                'error',
                'Kategori sedang digunakan dan tidak dapat dihapus.'
            );

    }

    $kategori_keterampilan->delete();

    return redirect()
        ->route(
            'admin.kategori-keterampilan.index'
        )
        ->with(
            'hapus',
            'Kategori berhasil dihapus.'
        );
}
}