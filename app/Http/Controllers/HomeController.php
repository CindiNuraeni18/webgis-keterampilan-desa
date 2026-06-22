<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use App\Models\Keterampilan;
use App\Models\Dusun;
use App\Models\Rt;
use App\Models\Rw;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // CARD DASHBOARD
        $totalWarga = Warga::count();

        $totalPunyaSkill = Warga::has('keterampilans')->count();

$totalBelumSkill = Warga::doesntHave('keterampilans')->count();

        $totalDusun = Dusun::count();

        $totalRTRW = Rt::count() + Rw::count();

        // CHART KATEGORI
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
        ->get();

        // TOP SKILL
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

$skillPerTahun = Warga::has('keterampilans')
    ->selectRaw('YEAR(created_at) as tahun')
    ->selectRaw('COUNT(*) as total')
    ->groupBy('tahun')
    ->orderBy('tahun')
    ->get();

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

        return view(
    'admin.dashboard',
    compact(
        'totalWarga',
        'totalPunyaSkill',
        'totalBelumSkill',
        'totalDusun',
        'totalRTRW',
        'kategoriChart',
        'topSkillChart',
        'statistikDusun',
        'statistikRw',
        'statistikRt',
        'genderSkillChart',
        'grafikRw',
        'grafikDusun',
        'skillPerTahun',
        'dusunTerampil',
        'rwTerampil',
        'rtTerampil',
         'kategoriTerbanyak',
        'genderTerbanyak',
        'usiaChart',
        'usiaTerbanyak'
    )
);
    }
}
