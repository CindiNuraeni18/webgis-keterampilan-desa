<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use App\Models\Keterampilan;
use App\Models\KategoriKeterampilan;
use App\Models\Dusun;
use App\Models\Rw;
use App\Models\Rt;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Dompdf\Options;

class KeterampilanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $keterampilans = Keterampilan::with('warga.rt.rw.dusun', 'kategori')
            ->when($search, function ($query, $search) {
                $query->where('nama_keterampilan', 'like', "%{$search}%")
                    ->orWhereHas('warga', function ($q) use ($search) {
                        $q->where('nama', 'like', "%{$search}%")
                          ->orWhere('nik', 'like', "%{$search}%");
                    })
                    ->orWhereHas('kategori', function ($q) use ($search) {
                        $q->where('nama_kategori', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(10);

        return view('admin.keterampilan.index', compact('keterampilans', 'search'));
    }

    public function create()
    {
        $wargas = Warga::with('rt.rw.dusun')->get();
        $kategoris = KategoriKeterampilan::all();

        return view('admin.keterampilan.create', compact('wargas', 'kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'warga_id' => 'required|exists:wargas,id',
            'kategori_keterampilan_id' => 'required|exists:kategori_keterampilans,id',
            'nama_keterampilan' => 'required|max:255',
            'pengalaman' => 'nullable|max:255',
            'keterangan' => 'nullable',
        ]);

        Keterampilan::create($request->only([
            'warga_id',
            'kategori_keterampilan_id',
            'nama_keterampilan',
            'pengalaman',
            'keterangan',
        ]));

        return redirect()->route('admin.keterampilan.index')
            ->with('success', 'Data keterampilan berhasil ditambahkan.');
    }

    public function show(Keterampilan $keterampilan)
    {
        $keterampilan->load('warga.rt.rw.dusun', 'kategori');

        return view('admin.keterampilan.show', compact('keterampilan'));
    }

    public function edit(Keterampilan $keterampilan)
    {
        $wargas = Warga::with('rt.rw.dusun')->get();
        $kategoris = KategoriKeterampilan::all();

        return view('admin.keterampilan.edit', compact('keterampilan', 'wargas', 'kategoris'));
    }

    public function update(Request $request, Keterampilan $keterampilan)
    {
        $request->validate([
            'warga_id' => 'required|exists:wargas,id',
            'kategori_keterampilan_id' => 'required|exists:kategori_keterampilans,id',
            'nama_keterampilan' => 'required|max:255',
            'pengalaman' => 'nullable|max:255',
            'keterangan' => 'nullable',
        ]);

        $keterampilan->update($request->only([
            'warga_id',
            'kategori_keterampilan_id',
            'nama_keterampilan',
            'pengalaman',
            'keterangan',
        ]));

        return redirect()->route('admin.keterampilan.index')
            ->with('success', 'Data keterampilan berhasil diperbarui.');
    }

    public function destroy(Keterampilan $keterampilan)
    {
        $keterampilan->delete();

        return redirect()->route('admin.keterampilan.index')
            ->with('success', 'Data keterampilan berhasil dihapus.');
    }

    public function statistik()
{
    // chart kategori
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

    // top skill
    $topSkillChart = Keterampilan::select(
        'nama_keterampilan',
        DB::raw('count(*) as total')
    )
    ->groupBy('nama_keterampilan')
    ->orderByDesc('total')
    ->limit(5)
    ->get();

    // statistik dusun
    $statistikDusun = Dusun::with('rws.rts.wargas.keterampilans')->get();

    // statistik RW
    $statistikRw = Rw::with('rts.wargas.keterampilans','dusun')->get();

    // statistik RT
    $statistikRt = Rt::with('wargas.keterampilans','rw.dusun')->get();

    return view('admin.keterampilan.statistik', compact(
        'kategoriChart',
        'topSkillChart',
        'statistikDusun',
        'statistikRw',
        'statistikRt'
    ));
}

public function laporan(Request $request)
{
    $search = $request->search;
    $dusun = $request->dusun;
    $rw = $request->rw;
    $rt = $request->rt;
    $kategori = $request->kategori;

    $laporans = Keterampilan::with(
        'warga.rt.rw.dusun',
        'kategori'
    )

    ->when($search, function ($query) use ($search) {
    $query->whereHas('warga', function ($q) use ($search) {
        $q->where('nama', 'like', "%$search%")
          ->orWhere('nik', 'like', "%$search%");
    });
})

    ->when($dusun, function ($query) use ($dusun) {
        $query->whereHas('warga.rt.rw.dusun', function ($q) use ($dusun) {
            $q->where('id', $dusun);
        });
    })

    ->when($rw, function ($query) use ($rw) {
        $query->whereHas('warga.rt.rw', function ($q) use ($rw) {
            $q->where('id', $rw);
        });
    })

    ->when($rt, function ($query) use ($rt) {
        $query->whereHas('warga.rt', function ($q) use ($rt) {
            $q->where('id', $rt);
        });
    })

    ->when($kategori, function ($query) use ($kategori) {
        $query->where('kategori_keterampilan_id', $kategori);
    })

    ->latest()
    ->paginate(10);

    $dusuns = Dusun::all();
    $rws = Rw::all();
    $rts = Rt::all();
    $kategoris = KategoriKeterampilan::all();

    return view('admin.keterampilan.laporan', compact(
        'laporans',
        'search',
        'dusuns',
        'rws',
        'rts',
        'kategoris'
    ));
}

 public function exportPdf()
    {
        // 🔥 OPTIMASI DATA (biar cepat)
        $laporans = Keterampilan::select(
                'id','warga_id','kategori_keterampilan_id','nama_keterampilan'
            )
            ->with([
                'warga:id,nama,nik,rt_id',
                'warga.rt:id,nomor_rt,rw_id',
                'warga.rt.rw:id,nomor_rw,dusun_id',
                'warga.rt.rw.dusun:id,nama_dusun',
                'kategori:id,nama_kategori'
            ])
            ->limit(100)
            ->get();

        $options = new Options();
        $options->set('isRemoteEnabled', false);

        $dompdf = new Dompdf($options);

        $html = view('admin.keterampilan.pdf', compact('laporans'))->render();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return response($dompdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="laporan_keterampilan.pdf"');
    }

public function exportExcel()
{
    $laporans = Keterampilan::with(
        'warga.rt.rw.dusun',
        'kategori'
    )->get();

    $filename = "laporan_keterampilan.xls";

    $headers = [
        "Content-Type" => "application/vnd.ms-excel",
        "Content-Disposition" => "attachment; filename=$filename"
    ];

    return response()->view(
        'admin.keterampilan.excel',
        compact('laporans'),
        200,
        $headers
    );
}
}
