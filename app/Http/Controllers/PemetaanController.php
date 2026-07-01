<?php

namespace App\Http\Controllers;

use App\Models\Dusun;
use App\Models\Rw;
use App\Models\Rt;
use App\Models\Keterampilan;
use App\Models\KategoriKeterampilan;

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
$jumlahKategoriDominan = 0;

if(count($semuaKategori) > 0){

    $hitung = array_count_values($semuaKategori);

  $max = max($hitung);

$jumlahKategoriDominan = $max;

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
$jumlahKategoriDominan = 0;

if(count($semuaKategori) > 0){

    $hitung = array_count_values($semuaKategori);

   $max = max($hitung);

$jumlahKategoriDominan = $max;

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
$jumlahKategoriDominan = 0;

if(count($semuaKategori) > 0){

    $hitung = array_count_values($semuaKategori);

   $max = max($hitung);

$jumlahKategoriDominan = $max;

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
    $namaSkillDominan,

    'jumlah_kategori_dominan' =>
$jumlahKategoriDominan
];

        });

$kategoriMap = [];

foreach ($rts as $rt) {

    $kategoriCounter = [];

    foreach ($rt->wargas as $warga) {

        foreach ($warga->keterampilans as $skill) {

            $kategori = $skill->kategori->nama_kategori;

            $kategoriId = $skill->kategori_keterampilan_id;

            if (!isset($kategoriCounter[$kategori])) {

                $kategoriCounter[$kategori] = [

                    'id' => $kategoriId,
                    'warga' => []

                ];

            }

            // supaya 1 warga tidak dihitung dua kali
            $kategoriCounter[$kategori]['warga'][$warga->id] = true;
        }
    }

    foreach ($kategoriCounter as $kategori => $dataKategori) {

        $kategoriMap[] = [

            'id' => $dataKategori['id'],

            'rt_id' => $rt->id,

            'rw_id' => optional($rt->rw)->id,

            'dusun_id' => optional(optional($rt->rw)->dusun)->id,

            'kategori' => $kategori,

            'jumlah_warga' => count($dataKategori['warga']),

            'latitude' => $rt->latitude,

            'longitude' => $rt->longitude,

            'rt' => $rt->nomor_rt,

            'rw' => optional($rt->rw)->nomor_rw,

            'dusun' => optional(optional($rt->rw)->dusun)->nama_dusun

        ];

    }

}

$maxJumlah = collect($kategoriMap)->max('jumlah_warga');

return response()->json([

    'dusun' => $dataDusun,

    'rw' => $dataRw,

    'rt' => $dataRt,

    'kategori' => array_values($kategoriMap),

    'max_jumlah' => $maxJumlah

]);

}

public function detailRt($id)
{
    $rt = Rt::with('rw.dusun')
        ->findOrFail($id);

    $wargaIds = $rt->wargas->pluck('id');

    $allSkills = Keterampilan::with([
        'kategori',
        'warga.rt.rw.dusun'
    ])
    ->whereIn('warga_id', $wargaIds)
    ->get();

    $skills = Keterampilan::with([
        'kategori',
        'warga.rt.rw.dusun'
    ])
    ->whereIn('warga_id', $wargaIds)
    ->paginate(50);

   $grafikKategori = $allSkills
    ->groupBy(fn($item) => $item->kategori->nama_kategori)
    ->map(fn($items) => $items->count());
    $totalWarga = $wargaIds->count();

$totalWargaTerampil = $allSkills
    ->pluck('warga_id')
    ->unique()
    ->count();

$totalSkill = $allSkills->count();

$kategoriDominan = $allSkills
    ->groupBy(fn($item) => $item->kategori->nama_kategori)
    ->sortByDesc(fn($item) => $item->count());

$namaKategoriDominan =
    $kategoriDominan->keys()->first() ?? '-';

$jumlahKategoriDominan =
    $kategoriDominan->first()?->count() ?? 0;

/* ===========================
   CEK KATEGORI DOMINAN
=========================== */

if ($grafikKategori->isEmpty()) {

    $namaKategoriDominan = 'Belum Ada';
    $jumlahKategoriDominan = 0;

} else {

    $max = $grafikKategori->max();

    $kategoriTerbanyak = $grafikKategori
        ->filter(fn($jumlah) => $jumlah == $max);

    if ($kategoriTerbanyak->count() > 1) {

        $namaKategoriDominan = 'Tidak Ada Dominan';
        $jumlahKategoriDominan = $max;

    } else {

        $namaKategoriDominan = $kategoriTerbanyak->keys()->first();
        $jumlahKategoriDominan = $max;

    }

}

    return view(
    'admin.pemetaan.detail-rt',
    compact(
        'rt',
        'skills',
        'grafikKategori',
        'totalWarga',
        'totalWargaTerampil',
        'totalSkill',
        'namaKategoriDominan',
        'jumlahKategoriDominan'
    )

    );
}

public function detailRw($id)
{
    $rw = Rw::with('rts.wargas', 'dusun')
        ->findOrFail($id);

    $wargaIds = $rw->rts
        ->flatMap(fn($rt) => $rt->wargas)
        ->pluck('id');

    $allSkills = Keterampilan::with([
        'kategori',
        'warga.rt.rw.dusun'
    ])
    ->whereIn('warga_id', $wargaIds)
    ->get();

    $skills = Keterampilan::with([
        'kategori',
        'warga.rt.rw.dusun'
    ])
    ->whereIn('warga_id', $wargaIds)
    ->paginate(50);

    $grafikKategori = $allSkills
        ->groupBy(fn($item) => $item->kategori->nama_kategori)
        ->map(fn($items) => $items->count());

$kategoriDominan = $allSkills
    ->groupBy(fn($item) => $item->kategori->nama_kategori)
    ->sortByDesc(fn($item) => $item->count());

$namaKategoriDominan =
    $kategoriDominan->keys()->first() ?? '-';

$jumlahKategoriDominan =
    $kategoriDominan->first()?->count() ?? 0;
$totalWarga = $wargaIds->count();

$totalWargaTerampil = $allSkills
    ->pluck('warga_id')
    ->unique()
    ->count();

$totalSkill = $allSkills->count();

/* ===========================
   CEK KATEGORI DOMINAN
=========================== */

if ($grafikKategori->isEmpty()) {

    $namaKategoriDominan = 'Belum Ada';
    $jumlahKategoriDominan = 0;

} else {

    $max = $grafikKategori->max();

    $kategoriTerbanyak = $grafikKategori
        ->filter(fn($jumlah) => $jumlah == $max);

    if ($kategoriTerbanyak->count() > 1) {

        $namaKategoriDominan = 'Tidak Ada Dominan';
        $jumlahKategoriDominan = $max;

    } else {

        $namaKategoriDominan = $kategoriTerbanyak->keys()->first();
        $jumlahKategoriDominan = $max;

    }

}
    return view(
        'admin.pemetaan.detail-rw',
        compact(
    'rw',
    'skills',
    'grafikKategori',

    'totalWarga',
    'totalWargaTerampil',
    'totalSkill',

    'namaKategoriDominan',
    'jumlahKategoriDominan'
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

    $allSkills = \App\Models\Keterampilan::with([
    'kategori',
    'warga.rt.rw.dusun'
])
->whereIn('warga_id', $wargaIds)
->get();

$skills = \App\Models\Keterampilan::with([
    'kategori',
    'warga.rt.rw.dusun'
])
->whereIn('warga_id', $wargaIds)
->paginate(50);
$grafikKategori = $allSkills
    ->groupBy(function ($item) {
        return $item->kategori->nama_kategori;
    })
    ->map(function ($items) {
        return $items->count();
    });
    $kategoriDominan =
    $grafikKategori->sortDesc();

$namaKategoriDominan =
    $kategoriDominan->keys()->first();

$jumlahKategoriDominan =
    $kategoriDominan->first();
    return view(
    'admin.pemetaan.detail-dusun',
    compact(
    'dusun',
    'skills',
    'allSkills',
    'grafikKategori',
    'namaKategoriDominan',
        'jumlahKategoriDominan'
)
    );
}
public function detailKategori($id)
{
    $kategori = KategoriKeterampilan::findOrFail($id);
$rtId = request('rt');
$query = Keterampilan::with([
    'kategori',
    'warga.rt.rw.dusun'
])
->where('kategori_keterampilan_id', $id);

if ($rtId) {

    $query->whereHas('warga', function ($q) use ($rtId) {

        $q->where('rt_id', $rtId);

    });

}

$skills = (clone $query)->paginate(50);

$allSkills = (clone $query)->get();
    $totalSkill = $allSkills->count();

    $totalWarga = $allSkills
        ->pluck('warga_id')
        ->unique()
        ->count();

$wilayah = $allSkills
    ->groupBy(function ($item) {

        $rw = optional(optional($item->warga->rt)->rw)->nomor_rw;
        $rt = optional($item->warga->rt)->nomor_rt;

        return "RW {$rw} / RT {$rt}";

    })
    ->map(function ($items) {

        return $items
            ->pluck('warga_id')
            ->unique()
            ->count();

    });

if ($wilayah->isEmpty()) {

    $wilayahDominan = '-';
    $jumlahWilayahDominan = 0;

} else {

    $max = $wilayah->max();

    $terbanyak = $wilayah
        ->filter(fn($jml) => $jml == $max);

    if ($terbanyak->count() > 1) {

        $wilayahDominan = 'Tidak Ada Dominan';

    } else {

        $wilayahDominan = $terbanyak->keys()->first();

    }

    $jumlahWilayahDominan = $max;

}

  $grafikWilayah = Keterampilan::with('warga.rt.rw.dusun')
    ->where('kategori_keterampilan_id', $id)
    ->get()
    ->groupBy(function ($item) {

        $dusun = optional(optional(optional($item->warga->rt)->rw)->dusun)->nama_dusun;
        $rw     = optional(optional($item->warga->rt)->rw)->nomor_rw;
        $rt     = optional($item->warga->rt)->nomor_rt;

        return "{$dusun}|RW {$rw} RT {$rt}";
    })
   ->map(function ($items, $label) {

    $jumlah = $items
        ->pluck('warga_id')
        ->unique()
        ->count();

    $dusun = trim(explode('|', $label)[0]);

    switch (strtolower($dusun)) {

        case 'kemped':
            $warna = '#2563eb';
            break;

        case 'sukamelang':
            $warna = '#16a34a';
            break;

        default:
            $warna = '#94a3b8';
            break;
    }

    return [

        'label' => str_replace('|', ' - ', $label),

        'jumlah' => $jumlah,

        'warna' => $warna,

        'dusun' => $dusun

    ];

});

    return view(
        'admin.pemetaan.detail-kategori',
        compact(
            'kategori',
            'skills',
            'allSkills',
            'totalWarga',
            'totalSkill',
           'wilayahDominan',
'jumlahWilayahDominan',
            'grafikWilayah'
        )
    );
}
}
