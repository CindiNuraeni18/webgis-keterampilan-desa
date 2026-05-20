<?php

namespace App\Http\Controllers;

use App\Models\Rw;
use App\Models\Rt;
use App\Models\Dusun;
use App\Models\Warga;
use App\Models\Keterampilan;
use App\Models\KategoriKeterampilan;
use Illuminate\Support\Facades\DB;

class LandingPageController extends Controller
{
    public function index()
    {
        $totalRw = Rw::count();

        $totalRt = Rt::count();

        $totalDusun = Dusun::count();

        $totalWarga = Warga::count();

        $totalSkill = Warga::has('keterampilans')->count();

        $totalKategori = KategoriKeterampilan::count();

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

        // statistik dusun
     $statistikDusun = Keterampilan::join(
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
->join(
    'kategori_keterampilans',
    'keterampilans.kategori_keterampilan_id',
    '=',
    'kategori_keterampilans.id'
)

->select(
    'dusuns.nama_dusun',
    'rts.nomor_rt as rt',
    'rws.nomor_rw as rw',
    'kategori_keterampilans.nama_kategori',
    DB::raw('count(keterampilans.id) as total_skill')
)
->groupBy(
    'dusuns.nama_dusun',
    'rts.nomor_rt',
    'rws.nomor_rw',
    'kategori_keterampilans.nama_kategori'
)
->orderByDesc('total_skill')
->get();

        return view('welcome', compact(
            'totalRw',
            'totalRt',
            'totalDusun',
            'totalWarga',
            'totalSkill',
            'totalKategori',
            'kategoriChart',
            'statistikDusun'
        ));
    }
}