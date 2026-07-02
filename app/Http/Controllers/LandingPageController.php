<?php

namespace App\Http\Controllers;

use App\Models\Rw;
use App\Models\Rt;
use App\Models\Dusun;
use App\Models\Warga;
use App\Models\Keterampilan;
use App\Models\KategoriKeterampilan;
use App\Models\Pesan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LandingPageController extends Controller
{
   public function index(Request $request)
{
   $hasil = null;
$jenis = null;

if ($request->filled('nik')) {

    $warga = Warga::with([
    'rt.rw.dusun',
    'keterampilans.kategori'
])->where('nik', $request->nik)->first();

    if ($warga) {

        $hasil = $warga;
        $jenis = 'warga';

    } else {

        $pesan = Pesan::with('kategori')
    ->where('nik', $request->nik)
    ->latest()
    ->first();

        if ($pesan) {
            $hasil = $pesan;
            $jenis = 'pesan';
        }
    }
}

    $totalRw = Rw::count();
    $totalRt = Rt::count();
    $totalDusun = Dusun::count();
    $totalWarga = Warga::count();
    $totalSkill = Warga::has('keterampilans')->count();
    $totalKategori = KategoriKeterampilan::count();
$totalBelumSkill = Warga::doesntHave('keterampilans')->count();

        // statistik kategori
        $kategoriChart = Keterampilan::join(
            'kategori_keterampilans',
            'keterampilans.kategori_keterampilan_id',
            '=',
            'kategori_keterampilans.id'
        )
        ->select(
            'kategori_keterampilans.nama_kategori',
            DB::raw('count(*) as total')
        )
        ->groupBy('kategori_keterampilans.nama_kategori')
        ->orderByDesc('total')
        ->get();
         $topSkillChart = Keterampilan::select(
            'nama_keterampilan',
            DB::raw('count(*) as total')
        )
        ->groupBy('nama_keterampilan')
        ->orderByDesc('total')
        ->limit(10)
        ->get();

        // STATISTIK DUSUN
        $statistikDusun = Dusun::with(
            'rws.rts.wargas.keterampilans'
        )->get();

        // STATISTIK RW
        $statistikRw = Rw::with(
            'dusun',
            'rts.wargas.keterampilans'
        )->get();

        // STATISTIK RT
        $statistikRt = Rt::with(
            'rw.dusun',
            'wargas.keterampilans'
        )->get();

$genderSkillChart = Warga::has('keterampilans')
    ->select(
        'jenis_kelamin',
        DB::raw('count(*) as total')
    )
    ->groupBy('jenis_kelamin')
    ->get();

    $grafikRw = Rw::withCount([
    'rts as total_warga' => function ($q) {

    }
])->get();

$grafikDusun = Dusun::with(
    'rws.rts.wargas'
)->get();
        $dusunTerampil = Dusun::with('rws.rts.wargas.keterampilans')
    ->get()
    ->sortByDesc(function ($dusun) {

        return $dusun->rws->sum(

            fn($rw) =>

            $rw->rts->sum(

                fn($rt) =>

                $rt->wargas
                    ->filter(
                        fn($warga) =>
                        $warga->keterampilans->count() > 0
                    )
                    ->count()

            )

        );

    })
    ->first();
$rwTerampil = $statistikRw
    ->sortByDesc(

        fn($rw) =>

        $rw->rts->sum(

            fn($rt) =>

            $rt->wargas
                ->filter(
                    fn($warga) =>
                    $warga->keterampilans->count() > 0
                )
                ->count()

        )

    )
    ->first();

$rtTerampil = $statistikRt
    ->sortByDesc(

        fn($rt) =>

        $rt->wargas
            ->filter(
                fn($warga) =>
                $warga->keterampilans->count() > 0
            )
            ->count()

    )
    ->first();

    $kategoriTerbanyak = Keterampilan::join(
    'kategori_keterampilans',
    'keterampilans.kategori_keterampilan_id',
    '=',
    'kategori_keterampilans.id'
)
->select(
    'kategori_keterampilans.nama_kategori',
    DB::raw('COUNT(*) as total')
)
->groupBy('kategori_keterampilans.nama_kategori')
->orderByDesc('total')
->first();

$genderTerbanyak = Warga::has('keterampilans')
    ->select(
        'jenis_kelamin',
        DB::raw('count(*) as total')
    )
    ->groupBy('jenis_kelamin')
    ->orderByDesc('total')
    ->first();

$usiaChart = [
    '18-25 Tahun' => 0,
    '26-35 Tahun' => 0,
    '36-45 Tahun' => 0,
    '46-55 Tahun' => 0,
    '56+ Tahun'   => 0,
];

$wargaSkill = Warga::has('keterampilans')->get();

foreach ($wargaSkill as $warga) {

    if (!$warga->tanggal_lahir) {
        continue;
    }

    $usia = \Carbon\Carbon::parse(
        $warga->tanggal_lahir
    )->age;

    if ($usia <= 25) {

        $usiaChart['18-25 Tahun']++;

    } elseif ($usia <= 35) {

        $usiaChart['26-35 Tahun']++;

    } elseif ($usia <= 45) {

        $usiaChart['36-45 Tahun']++;

    } elseif ($usia <= 55) {

        $usiaChart['46-55 Tahun']++;

    } else {

        $usiaChart['56+ Tahun']++;

    }
}

$usiaTerbanyak = collect($usiaChart)
    ->sortDesc()
    ->keys()
    ->first();

$grafikKategoriDusun = Keterampilan::join(
    'kategori_keterampilans',
    'keterampilans.kategori_keterampilan_id',
    '=',
    'kategori_keterampilans.id'
)
->join(
    'wargas',
    'keterampilans.warga_id',
    '=',
    'wargas.id'
)
->join(
    'rts',
    'wargas.rt_id',
    '=',
    'rts.id'
)
->join(
    'rws',
    'rts.rw_id',
    '=',
    'rws.id'
)
->join(
    'dusuns',
    'rws.dusun_id',
    '=',
    'dusuns.id'
)
->select(
    'dusuns.nama_dusun',
    'kategori_keterampilans.nama_kategori',
    DB::raw('COUNT(*) as total')
)
->groupBy(
    'dusuns.nama_dusun',
    'kategori_keterampilans.nama_kategori'
)
->get();
$skillPerTahun = Warga::has('keterampilans')
    ->selectRaw('YEAR(created_at) as tahun')
    ->selectRaw('COUNT(*) as total')
    ->groupBy('tahun')
    ->orderBy('tahun')
    ->get();
// ===== Grafik Per Dusun (Total Warga vs Punya Keterampilan) =====
$dusunChart = $statistikDusun->map(function ($dusun) {
    $totalWarga = $dusun->rws->sum(
        fn($rw) => $rw->rts->sum(fn($rt) => $rt->wargas->count())
    );

    $totalSkillWarga = $dusun->rws->sum(
        fn($rw) => $rw->rts->sum(
            fn($rt) => $rt->wargas
                ->filter(fn($w) => $w->keterampilans->count() > 0)
                ->count()
        )
    );

    return (object) [
        'nama_dusun'  => $dusun->nama_dusun,
        'total_warga' => $totalWarga,
        'total_skill' => $totalSkillWarga,
    ];
});

// ===== Grafik Per RT/RW (Total Warga vs Punya Keterampilan) =====
$rtRwChart = $statistikRt->map(function ($rt) {
    $totalWarga = $rt->wargas->count();

    $totalSkillWarga = $rt->wargas
        ->filter(fn($w) => $w->keterampilans->count() > 0)
        ->count();

    return (object) [
        'rt'          => $rt->nama_rt ?? $rt->nomor_rt ?? $rt->id,
        'rw'          => optional($rt->rw)->nama_rw ?? optional($rt->rw)->nomor_rw ?? '-',
        'total_warga' => $totalWarga,
        'total_skill' => $totalSkillWarga,
    ];
});
$dusuns = Dusun::all();

$rws = Rw::with('dusun')->get();

$rts = Rt::with('rw.dusun')->get();

$kategoriKeterampilans = KategoriKeterampilan::orderBy('nama_kategori')->get();

       return view('welcome', compact(

'totalRw',
'totalRt',
'totalDusun',
'totalWarga',
'totalSkill',
'totalKategori',
'kategoriChart',
'statistikDusun',
'statistikRw',
'statistikRt',
'dusuns',
'rws',
'rts',
'hasil',
'jenis',
'kategoriKeterampilans',
'totalBelumSkill',
'dusunTerampil',
'rwTerampil',
'rtTerampil',
'kategoriTerbanyak',
'genderTerbanyak',
'usiaChart',
'usiaTerbanyak',
'genderSkillChart',
'grafikKategoriDusun',
'topSkillChart',
'skillPerTahun',
'dusunChart',  
'rtRwChart' 

));
    }

    
}
