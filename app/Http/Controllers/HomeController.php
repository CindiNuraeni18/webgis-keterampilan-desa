<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        // statistik utama
        $totalWarga = Warga::count();
        $totalSkill = Keterampilan::count();
        $totalDusun = Dusun::count();
        $totalRTRW = Rt::count() + Rw::count();

        // warga yang punya keterampilan
        $wargaTerampil = Warga::whereHas('keterampilans')->count();

        // persentase
        $persentaseSkill = $totalWarga > 0 
            ? round(($wargaTerampil / $totalWarga) * 100, 1) 
            : 0;

        // top skill
        $topSkill = DB::table('keterampilans')
            ->select('nama_keterampilan', DB::raw('count(*) as total'))
            ->groupBy('nama_keterampilan')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalWarga',
            'totalSkill',
            'totalDusun',
            'totalRTRW',
            'wargaTerampil',
            'persentaseSkill',
            'topSkill'
        ));
    }
}
