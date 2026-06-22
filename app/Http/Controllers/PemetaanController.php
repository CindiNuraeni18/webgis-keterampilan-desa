<?php

namespace App\Http\Controllers;

use App\Models\Dusun;
use App\Models\Rw;
use App\Models\Rt;
use App\Models\Keterampilan;

class PemetaanController extends Controller
{
    public function index()
    {
         $dusuns = Dusun::whereNotNull('geojson')->get();

    return view('admin.pemetaan.index', compact('dusuns'));
    }

    public function api()
{
    $dusuns = Dusun::with(
    'rws.rts.wargas.keterampilans.kategori'
)->get();

$rws = Rw::with(
    'dusun',
    'rts.wargas.keterampilans.kategori'
)->get();

$rts = Rt::with(
    'rw.dusun',
    'wargas.keterampilans.kategori'
)->get();


    // =======================
    // DATA DUSUN
    // =======================
    $dataDusun = $dusuns->map(function ($dusun) {

        $jumlahWarga=0;
        $jumlahSkill=0;
        $jumlahRt=0;

        $semuaKategori=[];
        $semuaNamaSkill=[];

        foreach($dusun->rws as $rw){

        $jumlahRt += $rw->rts->count();

        foreach($rw->rts as $rt){

       foreach($rt->wargas as $warga){

    if($warga->keterampilans->count() > 0){

        $jumlahWarga++;

    }

    foreach($warga->keterampilans as $skill){

        $jumlahSkill++;

        $semuaKategori[] =
        $skill->kategori->nama_kategori;

        $semuaNamaSkill[] =
        $skill->nama_keterampilan;

    }

}
        

        }

        }

        $kategoriDominan = 'Belum tersedia';

if(count($semuaKategori) > 0){

    $hitung = array_count_values($semuaKategori);

    $max = max($hitung);

    $tertinggi = array_filter(
        $hitung,
        fn($jumlah) => $jumlah == $max
    );

    if(count($tertinggi) > 1){

        $kategoriDominan = 'Tidak Ada Dominan';

    }else{

        $kategoriDominan = array_key_first($tertinggi);

    }
}

        $namaSkillDominan = 'Belum tersedia';

if(count($semuaNamaSkill) > 0){

    $hitung2 = array_count_values($semuaNamaSkill);

    $maxSkill = max($hitung2);

    $tertinggiSkill = array_filter(
        $hitung2,
        fn($jumlah) => $jumlah == $maxSkill
    );

    if(count($tertinggiSkill) > 1){

        $namaSkillDominan = 'Tidak Ada Dominan';

    }else{

        $namaSkillDominan =
            array_key_first($tertinggiSkill);

    }
}

        return[
    'id' => $dusun->id,
    'nama_dusun' => $dusun->nama_dusun,

    'latitude' => $dusun->rws->avg('latitude'),
    'longitude' => $dusun->rws->avg('longitude'),

    'jumlah_rw' => $dusun->rws->count(),
    'jumlah_rt' => $jumlahRt,
    'jumlah_warga' => $jumlahWarga,
    'jumlah_keterampilan' => $jumlahSkill,

    'keterampilan_dominan' => $kategoriDominan,
    'nama_keterampilan_dominan' => $namaSkillDominan
];

        });



    // =======================
    // DATA RW
    // =======================
    $dataRw = $rws->map(function($rw){

        $jumlahWarga=0;
        $jumlahSkill=0;

        $semuaKategori=[];
        $semuaNamaSkill=[];

        foreach($rw->rts as $rt){

       foreach($rt->wargas as $warga){

    if($warga->keterampilans->count() > 0){

        $jumlahWarga++;

    }

    foreach($warga->keterampilans as $skill){

        $jumlahSkill++;

        $semuaKategori[] =
        $skill->kategori->nama_kategori;

        $semuaNamaSkill[] =
        $skill->nama_keterampilan;

    }

}

       

        }

        $kategoriDominan = 'Belum tersedia';

if(count($semuaKategori) > 0){

    $hitung = array_count_values($semuaKategori);

    $max = max($hitung);

    $tertinggi = array_filter(
        $hitung,
        fn($jumlah) => $jumlah == $max
    );

    if(count($tertinggi) > 1){

        $kategoriDominan = 'Tidak Ada Dominan';

    }else{

        $kategoriDominan = array_key_first($tertinggi);

    }
}
      $namaSkillDominan = 'Belum tersedia';

if(count($semuaNamaSkill) > 0){

    $hitung2 = array_count_values($semuaNamaSkill);

    $maxSkill = max($hitung2);

    $tertinggiSkill = array_filter(
        $hitung2,
        fn($jumlah) => $jumlah == $maxSkill
    );

    if(count($tertinggiSkill) > 1){

        $namaSkillDominan = 'Tidak Ada Dominan';

    }else{

        $namaSkillDominan =
            array_key_first($tertinggiSkill);

    }
}

        return[
        'id'=>$rw->id,
        'nama_rw'=>$rw->nomor_rw,
        'nama_dusun'=>optional($rw->dusun)->nama_dusun,
        'latitude'=>$rw->latitude,
        'longitude'=>$rw->longitude,
        'jumlah_rt'=>$rw->rts->count(),
        'jumlah_warga'=>$jumlahWarga,
        'jumlah_keterampilan'=>$jumlahSkill,

        'keterampilan_dominan'=>$kategoriDominan,

        'nama_keterampilan_dominan'=>$namaSkillDominan

        ];

        });



    // =======================
    // DATA RT
    // =======================
    $dataRt = $rts->map(function($rt){

    $jumlahWarga = 0;

    $jumlahSkill = 0;

    $semuaKategori = [];

    $semuaNamaSkill = [];

        foreach($rt->wargas as $warga){

    if($warga->keterampilans->count() > 0){

        $jumlahWarga++;

    }

    foreach($warga->keterampilans as $skill){

        $jumlahSkill++;

        $semuaKategori[] =
        $skill->kategori->nama_kategori;

        $semuaNamaSkill[] =
        $skill->nama_keterampilan;

    }

}

        $kategoriDominan = 'Belum tersedia';

if(count($semuaKategori) > 0){

    $hitung = array_count_values($semuaKategori);

    $max = max($hitung);

    $tertinggi = array_filter(
        $hitung,
        fn($jumlah) => $jumlah == $max
    );

    if(count($tertinggi) > 1){

        $kategoriDominan = 'Tidak Ada Dominan';

    }else{

        $kategoriDominan = array_key_first($tertinggi);

    }
}

        $namaSkillDominan = 'Belum tersedia';

if(count($semuaNamaSkill) > 0){

    $hitung2 = array_count_values($semuaNamaSkill);

    $maxSkill = max($hitung2);

    $tertinggiSkill = array_filter(
        $hitung2,
        fn($jumlah) => $jumlah == $maxSkill
    );

    if(count($tertinggiSkill) > 1){

        $namaSkillDominan = 'Tidak Ada Dominan';

    }else{

        $namaSkillDominan =
            array_key_first($tertinggiSkill);

    }
}

        return[
    'id' => $rt->id,

    'rw_id' => $rt->rw_id,

    'nama_rt' => $rt->nomor_rt,

    'nama_rw' => optional($rt->rw)->nomor_rw,

    'nama_dusun' =>
    optional(optional($rt->rw)->dusun)
    ->nama_dusun,

    'latitude' => $rt->latitude,

    'longitude' => $rt->longitude,

    'jumlah_warga' => $jumlahWarga,

    'jumlah_keterampilan' => $jumlahSkill,

    'keterampilan_dominan' =>
    $kategoriDominan,

    'nama_keterampilan_dominan' =>
    $namaSkillDominan
];

        });



    return response()->json([
        'dusun' => $dataDusun,
        'rw' => $dataRw,
        'rt' => $dataRt
    ]);
}

public function detailRt($id)
{
    $rt = Rt::with('rw.dusun')
        ->findOrFail($id);

    $wargas = $rt->wargas()
        ->with('keterampilans.kategori')
        ->paginate(50);

    return view(
        'admin.pemetaan.detail-rt',
        compact(
            'rt',
            'wargas'
        )
    );
}

public function detailRw($id)
{
    $rw = Rw::with(
        'rts.wargas',
        'dusun'
    )->findOrFail($id);

    $wargaIds = $rw->rts
        ->flatMap(fn($rt) => $rt->wargas)
        ->pluck('id');

    $skills = \App\Models\Keterampilan::with([
        'kategori',
        'warga.rt.rw.dusun'
    ])
    ->whereIn('warga_id', $wargaIds)
    ->paginate(50);

    return view(
        'admin.pemetaan.detail-rw',
        compact(
            'rw',
            'skills'
        )
    );
}

public function detailDusun($id)
{
    $dusun = Dusun::with('rws.rts')
        ->findOrFail($id);

    $wargaIds = $dusun->rws
        ->flatMap(fn($rw) => $rw->rts)
        ->flatMap(fn($rt) => $rt->wargas)
        ->pluck('id');

    $skills = \App\Models\Keterampilan::with([
        'kategori',
        'warga.rt.rw.dusun'
    ])
    ->whereIn('warga_id', $wargaIds)
    ->paginate(50);

    return view(
        'admin.pemetaan.detail-dusun',
        compact(
            'dusun',
            'skills'
        )
    );
}
}
