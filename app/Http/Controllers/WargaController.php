<?php

namespace App\Http\Controllers;

use App\Models\Rt;
use App\Models\Warga;
use App\Models\Dusun;
use App\Models\Rw;
use App\Models\KategoriKeterampilan;
use App\Imports\WargaImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class WargaController extends Controller
{
    public function index(Request $request)
{
    $search = $request->search;

    $dusunId = $request->dusun_id;
    $rwId = $request->rw_id;
    $rtId = $request->rt_id;
    $kategoriId = $request->kategori_id;

    $wargas = Warga::with([
        'rt.rw.dusun',
        'keterampilans.kategori'
    ])

    ->when($search, function ($query) use ($search) {

        $query->where(function ($q) use ($search) {

            $q->where('nama', 'like', "%{$search}%")
              ->orWhere('nik', 'like', "%{$search}%");

        });

    })

    ->when($dusunId, function ($query) use ($dusunId) {

        $query->whereHas('rt.rw', function ($q) use ($dusunId) {

            $q->where('dusun_id', $dusunId);

        });

    })

    ->when($rwId, function ($query) use ($rwId) {

        $query->whereHas('rt', function ($q) use ($rwId) {

            $q->where('rw_id', $rwId);

        });

    })

    ->when($rtId, function ($query) use ($rtId) {

        $query->where('rt_id', $rtId);

    })

    ->when($kategoriId, function ($query) use ($kategoriId) {

        $query->whereHas('keterampilans', function ($q) use ($kategoriId) {

            $q->where('kategori_keterampilan_id', $kategoriId);

        });

    })

    ->latest()
    ->paginate(100)
    ->withQueryString();

    $dusuns = Dusun::orderBy('nama_dusun')->get();

    $rws = Rw::with('dusun')
        ->orderBy('nomor_rw')
        ->get();

    $rts = Rt::with('rw')
        ->orderBy('nomor_rt')
        ->get();

    $kategoris = KategoriKeterampilan::orderBy('nama_kategori')
        ->get();

    return view(
        'admin.warga.index',
        compact(
            'wargas',
            'search',
            'dusuns',
            'rws',
            'rts',
            'kategoris'
        )
    );
}

    public function create()
    {
        $rts = Rt::with('rw.dusun')->get();

$kategoris =
\App\Models\KategoriKeterampilan::all();

return view(
    'admin.warga.create',
    compact('rts', 'kategoris')
);
    }

    public function store(Request $request)
    {
        $request->validate([
            'rt_id' => 'required|exists:rts,id',
           'nik' => 'required|digits:16|unique:wargas,nik',
            'nama' => 'required|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir' => 'required|max:255',
            'tanggal_lahir' => 'required|date',
            'no_hp' => 'nullable|max:20',
           'kategori_keterampilan_id.*' =>
'nullable',

'nama_keterampilan.*' =>
'nullable|string|max:255',

'kategori_keterampilan_id.*' =>
'nullable',

'pengalaman.*' =>
'nullable|max:255',
        ]);

        $warga = Warga::create([

    'rt_id' => $request->rt_id,

    'nik' => $request->nik,

    'nama' => $request->nama,

    'jenis_kelamin' => $request->jenis_kelamin,

    'tempat_lahir' => $request->tempat_lahir,

    'tanggal_lahir' => $request->tanggal_lahir,

    'no_hp' => $request->no_hp,

]);

/* =========================
   SIMPAN KETERAMPILAN
========================= */

if($request->filled('nama_keterampilan')){

    foreach($request->nama_keterampilan as $i => $skill){

        if($skill){

    if(
        empty(
            $request->kategori_keterampilan_id[$i]
        )
    ){
        continue;
    }

    if(
        $request->kategori_keterampilan_id[$i]
        == 'lainnya'
    ){

        if(
            empty(
                $request->kategori_baru[$i]
            )
        ){
            continue;
        }

        $kategori =
        \App\Models\KategoriKeterampilan::firstOrCreate([

            'nama_kategori' =>
            $request->kategori_baru[$i]

        ]);

        $kategoriId =
        $kategori->id;

    }else{

        $kategoriId =
        $request->kategori_keterampilan_id[$i];

    }

    \App\Models\Keterampilan::create([

        'warga_id' =>
        $warga->id,

        'kategori_keterampilan_id' =>
        $kategoriId,

        'nama_keterampilan' =>
        $skill,

        'pengalaman' =>
        $request->pengalaman[$i] ?? null,

    ]);

}

    }

}

        return redirect()->route('admin.warga.index')->with('tambah', 'Data warga berhasil ditambahkan.');
    }

    public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls,csv'
    ]);

    $import = new WargaImport();

Excel::import(
    $import,
    $request->file('file')
);

    return redirect()
->route('admin.warga.index')
->with(
'success',
[
    'berhasil'  => $import->berhasil,
    'duplikat'  => $import->duplikat,
    'skill'     => $import->skillBaru,
    'gagal'     => $import->gagal,
]
);
}

    public function show(Warga $warga)
    {
        $warga->load('rt.rw.dusun');
        return view('admin.warga.show', compact('warga'));
    }

   public function edit(Warga $warga)
{
    $rts = Rt::with('rw.dusun')->get();

    $kategoris =
    \App\Models\KategoriKeterampilan::all();

    $warga->load('keterampilans');

    return view(
        'admin.warga.edit',
        compact(
            'warga',
            'rts',
            'kategoris'
        )
    );
}

   
public function update(Request $request, Warga $warga)
{
    $request->validate([

        'rt_id' =>
        'required|exists:rts,id',

        'nik' =>
'required|digits:16|unique:wargas,nik,' . $warga->id,

        'nama' =>
        'required|max:255',

        'jenis_kelamin' =>
        'required|in:Laki-laki,Perempuan',

        'tempat_lahir' =>
        'required|max:255',

        'tanggal_lahir' =>
        'required|date',

        'no_hp' =>
        'nullable|max:20',

        'kategori_keterampilan_id.*' =>
'nullable',

        'nama_keterampilan.*' =>
'nullable|string|max:255',

'kategori_keterampilan_id.*' =>
'nullable',

        'pengalaman.*' =>
        'nullable|max:255',

    ]);


    /* =========================
       UPDATE DATA WARGA
    ========================= */

    $warga->update([

        'rt_id' =>
        $request->rt_id,

        'nik' =>
        $request->nik,

        'nama' =>
        $request->nama,

        'jenis_kelamin' =>
        $request->jenis_kelamin,

        'tempat_lahir' =>
        $request->tempat_lahir,

        'tanggal_lahir' =>
        $request->tanggal_lahir,

        'no_hp' =>
        $request->no_hp,

    ]);


    /* =========================
       HAPUS KETERAMPILAN LAMA
    ========================= */

    $warga->keterampilans()->delete();


    /* =========================
       SIMPAN KETERAMPILAN BARU
    ========================= */

    if($request->nama_keterampilan){

        foreach(
            $request->nama_keterampilan
            as $i => $skill
        ){

           if($skill){

    if(
        isset($request->kategori_keterampilan_id[$i]) &&
        $request->kategori_keterampilan_id[$i] == 'lainnya'
    ){

        $kategori =
        \App\Models\KategoriKeterampilan::firstOrCreate([

            'nama_kategori' =>
            $request->kategori_baru[$i]

        ]);

        $kategoriId = $kategori->id;

    }else{

        $kategoriId =
        $request->kategori_keterampilan_id[$i] ?? null;

    }

    \App\Models\Keterampilan::create([
   'warga_id' => $warga->id,

    'kategori_keterampilan_id' => $kategoriId,

    'nama_keterampilan' => $skill,

    'pengalaman' => $request->pengalaman[$i],

]);
        }

    }

}
    return redirect()
        ->route('admin.warga.index')
        ->with(
            'edit',
            'Data warga berhasil diperbarui.'
        );
}


    public function destroy(Warga $warga)
    {
        $warga->delete();

        return redirect()->route('admin.warga.index')->with('hapus', 'Data warga berhasil dihapus.');
    }
}
