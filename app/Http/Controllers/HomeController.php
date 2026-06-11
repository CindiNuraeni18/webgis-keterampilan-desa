<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use App\Models\Keterampilan;
use App\Models\Dusun;
use App\Models\Rt;
use App\Models\Rw;
use Illuminate\Support\Facades\DB;

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

        $totalSkill = Keterampilan::count();

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

        return view(
            'admin.dashboard',
            compact(
                'totalWarga',
                'totalSkill',
                'totalDusun',
                'totalRTRW',
                'kategoriChart',
                'topSkillChart',
                'statistikDusun',
                'statistikRw',
                'statistikRt'
            )
        );
    }
}