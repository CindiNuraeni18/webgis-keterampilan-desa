<?php

namespace App\Http\Controllers;

use App\Models\Dusun;
use App\Models\Rw;
use App\Models\Rt;

class PemetaanController extends Controller
{
    public function index()
    {
        return view('admin.pemetaan.index');
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

        $jumlahWarga += $rt->wargas->count();

        foreach($rt->wargas as $warga){

        foreach($warga->keterampilans as $skill){

        $jumlahSkill++;

        $semuaKategori[]=$skill->kategori->nama_kategori;

        $semuaNamaSkill[]=$skill->nama_keterampilan;

        }

        }

        }

        }

        $kategoriDominan='Belum tersedia';
        $namaSkillDominan='Belum tersedia';

        if(count($semuaKategori)>0){

        $hitung=array_count_values($semuaKategori);

        arsort($hitung);

        $kategoriDominan=array_key_first($hitung);
        }

        if(count($semuaNamaSkill)>0){

        $hitung2=array_count_values($semuaNamaSkill);

        arsort($hitung2);

        $namaSkillDominan=array_key_first($hitung2);
        }

        return[
        'id'=>$dusun->id,
        'nama_dusun'=>$dusun->nama_dusun,
        'latitude'=>$dusun->latitude,
        'longitude'=>$dusun->longitude,
        'jumlah_rw'=>$dusun->rws->count(),
        'jumlah_rt'=>$jumlahRt,
        'jumlah_warga'=>$jumlahWarga,
        'jumlah_keterampilan'=>$jumlahSkill,

        'keterampilan_dominan'=>$kategoriDominan,

        'nama_keterampilan_dominan'=>$namaSkillDominan

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

        $jumlahWarga += $rt->wargas->count();

        foreach($rt->wargas as $warga){

        foreach($warga->keterampilans as $skill){

        $jumlahSkill++;

        $semuaKategori[]=$skill->kategori->nama_kategori;

        $semuaNamaSkill[]=$skill->nama_keterampilan;

        }

        }

        }

        $kategoriDominan='Belum tersedia';
        $namaSkillDominan='Belum tersedia';

        if(count($semuaKategori)>0){

        $hitung=array_count_values($semuaKategori);

        arsort($hitung);

        $kategoriDominan=array_key_first($hitung);
        }

        if(count($semuaNamaSkill)>0){

        $hitung2=array_count_values($semuaNamaSkill);

        arsort($hitung2);

        $namaSkillDominan=array_key_first($hitung2);
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

        $jumlahSkill=0;

        $semuaKategori=[];
        $semuaNamaSkill=[];

        foreach($rt->wargas as $warga){

        foreach($warga->keterampilans as $skill){

        $jumlahSkill++;

        $semuaKategori[]=$skill->kategori->nama_kategori;

        $semuaNamaSkill[]=$skill->nama_keterampilan;

        }

        }

        $kategoriDominan='Belum tersedia';
        $namaSkillDominan='Belum tersedia';

        if(count($semuaKategori)>0){

        $hitung=array_count_values($semuaKategori);

        arsort($hitung);

        $kategoriDominan=array_key_first($hitung);
        }

        if(count($semuaNamaSkill)>0){

        $hitung2=array_count_values($semuaNamaSkill);

        arsort($hitung2);

        $namaSkillDominan=array_key_first($hitung2);
        }

        return[
        'id'=>$rt->id,
        'nama_rt'=>$rt->nomor_rt,
        'nama_rw'=>optional($rt->rw)->nomor_rw,
        'nama_dusun'=>optional(optional($rt->rw)->dusun)->nama_dusun,
        'latitude'=>$rt->latitude,
        'longitude'=>$rt->longitude,
        'jumlah_warga'=>$rt->wargas->count(),
        'jumlah_keterampilan'=>$jumlahSkill,

        'keterampilan_dominan'=>$kategoriDominan,

        'nama_keterampilan_dominan'=>$namaSkillDominan

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
    $rt = Rt::with('wargas.keterampilans.kategori', 'rw.dusun')->findOrFail($id);

    return view('admin.pemetaan.detail-rt', compact('rt'));
}

public function detailRw($id)
{
    $rw = Rw::with('rts.wargas.keterampilans.kategori', 'dusun')->findOrFail($id);

    return view('admin.pemetaan.detail-rw', compact('rw'));
}
}
