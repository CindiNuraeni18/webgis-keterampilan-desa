<?php

namespace App\Http\Controllers;

use App\Models\Dusun;
use App\Models\Rw;
use Illuminate\Http\Request;

class RwController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $rws = Rw::with('dusun')
            ->when($search, function ($query, $search) {

                $query->where(
                    'nomor_rw',
                    'like',
                    "%{$search}%"
                )

                ->orWhereHas('dusun', function ($q) use ($search) {

                    $q->where(
                        'nama_dusun',
                        'like',
                        "%{$search}%"
                    );

                });

            })
            ->latest()
            ->paginate(10);

        return view(
            'admin.rw.index',
            compact('rws', 'search')
        );
    }



    public function create()
    {
        $dusuns = Dusun::all();

        return view(
            'admin.rw.create',
            compact('dusuns')
        );
    }



    public function store(Request $request)
    {
        $request->validate([

    'dusun_id' => 'required|exists:dusuns,id',

    'nomor_rw' => 'required|max:10|not_in:0,00',

    'latitude' => 'nullable|numeric',

    'longitude' => 'nullable|numeric',

], [

    'nomor_rw.not_in' =>
    'Nomor RW tidak boleh 0 atau 00.',

]);


        // ==========================
        // FORMAT NOMOR RW
        // ==========================

        $nomorRw = str_pad(
            $request->nomor_rw,
            2,
            '0',
            STR_PAD_LEFT
        );


        // ==========================
        // CEK DUPLIKAT RW DALAM DUSUN
        // ==========================

        $cekRw = Rw::where(
                'dusun_id',
                $request->dusun_id
            )
            ->where(
                'nomor_rw',
                $nomorRw
            )
            ->exists();


        if($cekRw){

            return back()

                ->withInput()

                ->withErrors([

                    'nomor_rw' =>
                    'RW tersebut sudah ada pada dusun yang dipilih.'

                ]);

        }


        Rw::create([

            'dusun_id' => $request->dusun_id,

            'nomor_rw' => $nomorRw,

            'latitude' => $request->latitude,

            'longitude' => $request->longitude,

        ]);


        return redirect()
            ->route('admin.rw.index')
            ->with(
    'tambah',
    'Data RW berhasil ditambahkan.'
);
    }



    public function show(Rw $rw)
    {
        $rw->load('dusun');

        return view(
            'admin.rw.show',
            compact('rw')
        );
    }



    public function edit(Rw $rw)
    {
        $dusuns = Dusun::all();

        return view(
            'admin.rw.edit',
            compact('rw', 'dusuns')
        );
    }



    public function update(Request $request, Rw $rw)
    {
       $request->validate([

    'dusun_id' => 'required|exists:dusuns,id',

    'nomor_rw' => 'required|max:10|not_in:0,00',

    'latitude' => 'nullable|numeric',

    'longitude' => 'nullable|numeric',

], [

    'nomor_rw.not_in' =>
    'Nomor RW tidak boleh 0 atau 00.',

]);


        // ==========================
        // FORMAT NOMOR RW
        // ==========================

        $nomorRw = str_pad(
            $request->nomor_rw,
            2,
            '0',
            STR_PAD_LEFT
        );


        // ==========================
        // CEK DUPLIKAT RW DALAM DUSUN
        // ==========================

        $cekRw = Rw::where(
                'dusun_id',
                $request->dusun_id
            )
            ->where(
                'nomor_rw',
                $nomorRw
            )
            ->where(
                'id',
                '!=',
                $rw->id
            )
            ->exists();


        if($cekRw){

            return back()

                ->withInput()

                ->withErrors([

                    'nomor_rw' =>
                    'RW tersebut sudah ada pada dusun yang dipilih.'

                ]);

        }


        $rw->update([

            'dusun_id' => $request->dusun_id,

            'nomor_rw' => $nomorRw,

            'latitude' => $request->latitude,

            'longitude' => $request->longitude,

        ]);


        return redirect()
            ->route('admin.rw.index')
            ->with(
    'edit',
    'Data RW berhasil diperbarui.'
);
    }



    public function destroy(Rw $rw)
    {
        $rw->delete();

        return redirect()
            ->route('admin.rw.index')
           ->with(
    'hapus',
    'Data RW berhasil dihapus.'
);
    }
}
