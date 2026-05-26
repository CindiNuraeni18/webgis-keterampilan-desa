<?php

namespace App\Http\Controllers;

use App\Models\Rt;
use App\Models\Rw;
use Illuminate\Http\Request;

class RtController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $rts = Rt::with('rw.dusun')
            ->when($search, function ($query, $search) {

                $query->where(
                    'nomor_rt',
                    'like',
                    "%{$search}%"
                )

                ->orWhereHas('rw', function ($q) use ($search) {

                    $q->where(
                        'nomor_rw',
                        'like',
                        "%{$search}%"
                    )

                    ->orWhereHas('dusun', function ($subQ) use ($search) {

                        $subQ->where(
                            'nama_dusun',
                            'like',
                            "%{$search}%"
                        );

                    });

                });

            })
            ->latest()
            ->paginate(10);

        return view(
            'admin.rt.index',
            compact('rts', 'search')
        );
    }



    public function create()
    {
        $rws = Rw::with('dusun')->get();

        return view(
            'admin.rt.create',
            compact('rws')
        );
    }



    public function store(Request $request)
    {
        $request->validate([

    'rw_id' => 'required|exists:rws,id',

    'nomor_rt' => 'required|max:10|not_in:0,00',

    'latitude' => 'nullable|numeric',

    'longitude' => 'nullable|numeric',

], [

    'nomor_rt.not_in' =>
    'Nomor RT tidak boleh 0 atau 00.',

]);


        // ==========================
        // FORMAT NOMOR RT
        // ==========================

        $nomorRt = str_pad(
            $request->nomor_rt,
            2,
            '0',
            STR_PAD_LEFT
        );


        // ==========================
        // CEK DUPLIKAT RT DALAM RW
        // ==========================

        $cekRt = Rt::where(
                'rw_id',
                $request->rw_id
            )
            ->where(
                'nomor_rt',
                $nomorRt
            )
            ->exists();


        if($cekRt){

            return back()

                ->withInput()

                ->withErrors([

                    'nomor_rt' =>
                    'RT tersebut sudah ada pada RW yang dipilih.'

                ]);

        }


        Rt::create([

            'rw_id' => $request->rw_id,

            'nomor_rt' => $nomorRt,

            'latitude' => $request->latitude,

            'longitude' => $request->longitude,

        ]);


        return redirect()
            ->route('admin.rt.index')
           ->with(
    'tambah',
    'Data RT berhasil ditambahkan.'
);
    }



    public function show(Rt $rt)
    {
        $rt->load('rw.dusun');

        return view(
            'admin.rt.show',
            compact('rt')
        );
    }



    public function edit(Rt $rt)
    {
        $rws = Rw::with('dusun')->get();

        return view(
            'admin.rt.edit',
            compact('rt', 'rws')
        );
    }



    public function update(Request $request, Rt $rt)
    {
        $request->validate([

    'rw_id' => 'required|exists:rws,id',

    'nomor_rt' => 'required|max:10|not_in:0,00',

    'latitude' => 'nullable|numeric',

    'longitude' => 'nullable|numeric',

], [

    'nomor_rt.not_in' =>
    'Nomor RT tidak boleh 0 atau 00.',

]);


        // ==========================
        // FORMAT NOMOR RT
        // ==========================

        $nomorRt = str_pad(
            $request->nomor_rt,
            2,
            '0',
            STR_PAD_LEFT
        );


        // ==========================
        // CEK DUPLIKAT RT DALAM RW
        // ==========================

        $cekRt = Rt::where(
                'rw_id',
                $request->rw_id
            )
            ->where(
                'nomor_rt',
                $nomorRt
            )
            ->where(
                'id',
                '!=',
                $rt->id
            )
            ->exists();


        if($cekRt){

            return back()

                ->withInput()

                ->withErrors([

                    'nomor_rt' =>
                    'RT tersebut sudah ada pada RW yang dipilih.'

                ]);

        }


        $rt->update([

            'rw_id' => $request->rw_id,

            'nomor_rt' => $nomorRt,

            'latitude' => $request->latitude,

            'longitude' => $request->longitude,

        ]);


        return redirect()
            ->route('admin.rt.index')
         ->with(
    'edit',
    'Data RT berhasil diperbarui.'
);
    }



    public function destroy(Rt $rt)
    {
        $rt->delete();

        return redirect()
            ->route('admin.rt.index')
          ->with(
    'hapus',
    'Data RT berhasil dihapus.'
);
    }
}
