<?php

namespace App\Http\Controllers;

use App\Models\Rt;
use App\Models\Warga;
use Illuminate\Http\Request;

class WargaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $wargas = Warga::with('rt.rw.dusun')
            ->when($search, function ($query, $search) {
                $query->where('nama', 'like', "%{$search}%")
                      ->orWhere('nik', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return view('admin.warga.index', compact('wargas', 'search'));
    }

    public function create()
    {
        $rts = Rt::with('rw.dusun')->get();
        return view('admin.warga.create', compact('rts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rt_id' => 'required|exists:rts,id',
            'nik' => 'required|max:20|unique:wargas,nik',
            'nama' => 'required|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'required|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required',
            'no_hp' => 'nullable|max:20',
            'pekerjaan' => 'nullable|max:255',
        ]);

        Warga::create($request->all());

        return redirect()->route('admin.warga.index')->with('success', 'Data warga berhasil ditambahkan.');
    }

    public function show(Warga $warga)
    {
        $warga->load('rt.rw.dusun');
        return view('admin.warga.show', compact('warga'));
    }

    public function edit(Warga $warga)
    {
        $rts = Rt::with('rw.dusun')->get();
        return view('admin.warga.edit', compact('warga', 'rts'));
    }

    public function update(Request $request, Warga $warga)
    {
        $request->validate([
            'rt_id' => 'required|exists:rts,id',
            'nik' => 'required|max:20|unique:wargas,nik,' . $warga->id,
            'nama' => 'required|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'required|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required',
            'no_hp' => 'nullable|max:20',
            'pekerjaan' => 'nullable|max:255',
        ]);

        $warga->update($request->all());

        return redirect()->route('admin.warga.index')->with('success', 'Data warga berhasil diperbarui.');
    }

    public function destroy(Warga $warga)
    {
        $warga->delete();

        return redirect()->route('admin.warga.index')->with('success', 'Data warga berhasil dihapus.');
    }
}