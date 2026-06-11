<?php

namespace App\Http\Controllers;

use App\Models\Pesan;
use Illuminate\Http\Request;

class PesanController extends Controller
{
    // kirim pesan dari landing page
    public function store(Request $request)
{
    $request->validate([
        'nama' => 'required',
        'nik' => 'required|digits:16',
        'nomor_hp' => 'required',
        'dusun' => 'required',
        'pesan' => 'required',
    ]);

    // otomatis ubah 08 menjadi 62
    $nomor = preg_replace('/[^0-9]/', '', $request->nomor_hp);

    if (substr($nomor, 0, 1) == '0') {
        $nomor = '62' . substr($nomor, 1);
    }

    Pesan::create([
        'nama' => $request->nama,
        'nik' => $request->nik,
        'nomor_hp' => $nomor,
        'dusun' => $request->dusun,
        'rw' => $request->rw,
        'rt' => $request->rt,
          'kategori_keterampilan_id' =>
        $request->kategori_keterampilan_id,

        'keterampilan' => $request->keterampilan,
        'pesan' => $request->pesan,
        'status' => 'Menunggu',
        'status_baca' => false,
    ]);

    return redirect()
    ->route('landing', ['#' => 'kontak'])
    ->with('success', 'Pengajuan berhasil dikirim');
}

    // tampil data admin
    public function index()
{
    // otomatis tandai sudah dibaca
    Pesan::where('status_baca', false)
        ->update([
            'status_baca' => true
        ]);

    $pesans = Pesan::latest()->paginate(20);

    return view(
        'admin.pesan.index',
        compact('pesans')
    );
}

    // setujui pengajuan
    public function setujui($id)
    {
        $pesan = Pesan::findOrFail($id);

        $pesan->status = 'Disetujui';

        $pesan->alasan_penolakan = null;

        $pesan->save();

        return back()->with(
            'success',
            'Pengajuan berhasil disetujui'
        );
    }

    // tolak pengajuan
    public function tolak(Request $request, $id)
    {
        $request->validate([
            'alasan_penolakan' => 'required'
        ]);

        $pesan = Pesan::findOrFail($id);

        $pesan->status = 'Ditolak';

        $pesan->alasan_penolakan =
            $request->alasan_penolakan;

        $pesan->save();

        return back()->with(
            'success',
            'Pengajuan berhasil ditolak'
        );
    }
}