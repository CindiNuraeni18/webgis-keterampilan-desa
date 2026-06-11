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
            ->paginate(20);

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
        ]);

        Keterampilan::create($request->only([
            'warga_id',
            'kategori_keterampilan_id',
            'nama_keterampilan',
            'pengalaman',
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
        ]);

        $keterampilan->update($request->only([
            'warga_id',
            'kategori_keterampilan_id',
            'nama_keterampilan',
            'pengalaman',
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
    $tahun = $request->tahun;

    $laporans = $this->getFilteredLaporan($request)
    ->latest()
    ->paginate(20)
    ->withQueryString();

    $dusuns = Dusun::all();
    $rws = Rw::all();
    $rts = Rt::all();
    $kategoris = KategoriKeterampilan::all();

    $tahuns = Keterampilan::selectRaw('YEAR(created_at) as tahun')
    ->distinct()
    ->orderByDesc('tahun')
    ->pluck('tahun');

    return view('admin.keterampilan.laporan', compact(
        'laporans',
        'search',
        'dusuns',
        'rws',
        'rts',
        'kategoris',
        'tahuns'
    ));
}

public function exportPdf(Request $request)
{
    $laporans = $this->getFilteredLaporan($request)
        ->latest()
        ->get();

    // Ringkasan
    $totalWarga = $laporans->pluck('warga_id')
        ->unique()
        ->count();

    $totalKategori = $laporans->pluck('kategori_keterampilan_id')
        ->unique()
        ->count();

    $totalKeterampilan = $laporans->count();

    // Statistik kategori
    $statistikKategori = $laporans
        ->groupBy(function ($item) {
            return $item->kategori->nama_kategori ?? 'Tanpa Kategori';
        })
        ->map(function ($items) {
            return $items->count();
        });

    // Filter aktif
    $filterAktif = [];

    if ($request->search) {
        $filterAktif['Pencarian'] = $request->search;
    }

    if ($request->dusun) {
        $dusun = Dusun::find($request->dusun);
        $filterAktif['Dusun'] = $dusun?->nama_dusun;
    }

    if ($request->rw) {
        $rw = Rw::find($request->rw);
        $filterAktif['RW'] = $rw?->nomor_rw;
    }

    if ($request->rt) {
        $rt = Rt::find($request->rt);
        $filterAktif['RT'] = $rt?->nomor_rt;
    }

    if ($request->kategori) {
        $kategori = KategoriKeterampilan::find($request->kategori);
        $filterAktif['Kategori'] = $kategori?->nama_kategori;
    }

    if ($request->tahun) {
        $filterAktif['Tahun'] = $request->tahun;
    }

    $options = new Options();
    $options->set('isRemoteEnabled', false);

    $dompdf = new Dompdf($options);

    $html = view(
        'admin.keterampilan.pdf',
        compact(
            'laporans',
            'totalWarga',
            'totalKategori',
            'totalKeterampilan',
            'statistikKategori',
            'filterAktif'
        )
    )->render();

    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();

    return response($dompdf->output(), 200)
        ->header('Content-Type', 'application/pdf')
        ->header(
            'Content-Disposition',
            'attachment; filename="laporan_keterampilan.pdf"'
        );
}

public function exportExcel(Request $request)
{
    $laporans = $this->getFilteredLaporan($request)
        ->latest()
        ->get();

    $totalWarga = $laporans->pluck('warga_id')
        ->unique()
        ->count();

    $totalKategori = $laporans->pluck('kategori_keterampilan_id')
        ->unique()
        ->count();

    $totalKeterampilan = $laporans->count();

    $statistikKategori = $laporans
        ->groupBy(function ($item) {
            return $item->kategori->nama_kategori ?? 'Tanpa Kategori';
        })
        ->map(function ($items) {
            return $items->count();
        });

    $filterAktif = [];

    if ($request->search) {
        $filterAktif['Pencarian'] = $request->search;
    }

    if ($request->dusun) {
        $dusun = Dusun::find($request->dusun);
        $filterAktif['Dusun'] = $dusun?->nama_dusun;
    }

    if ($request->rw) {
        $rw = Rw::find($request->rw);
        $filterAktif['RW'] = $rw?->nomor_rw;
    }

    if ($request->rt) {
        $rt = Rt::find($request->rt);
        $filterAktif['RT'] = $rt?->nomor_rt;
    }

    if ($request->kategori) {
        $kategori = KategoriKeterampilan::find($request->kategori);
        $filterAktif['Kategori'] = $kategori?->nama_kategori;
    }

    if ($request->tahun) {
        $filterAktif['Tahun'] = $request->tahun;
    }

    $filename = "laporan_keterampilan.xls";

    $headers = [
        "Content-Type" => "application/vnd.ms-excel",
        "Content-Disposition" => "attachment; filename={$filename}"
    ];

    return response()->view(
        'admin.keterampilan.excel',
        compact(
            'laporans',
            'totalWarga',
            'totalKategori',
            'totalKeterampilan',
            'statistikKategori',
            'filterAktif'
        ),
        200,
        $headers
    );
}

private function getFilteredLaporan(Request $request)
{
    return Keterampilan::with(
        'warga.rt.rw.dusun',
        'kategori'
    )

    ->when($request->search, function ($query) use ($request) {
        $query->whereHas('warga', function ($q) use ($request) {
            $q->where('nama', 'like', "%{$request->search}%")
              ->orWhere('nik', 'like', "%{$request->search}%");
        });
    })

    ->when($request->dusun, function ($query) use ($request) {
        $query->whereHas('warga.rt.rw.dusun', function ($q) use ($request) {
            $q->where('id', $request->dusun);
        });
    })

    ->when($request->rw, function ($query) use ($request) {
        $query->whereHas('warga.rt.rw', function ($q) use ($request) {
            $q->where('id', $request->rw);
        });
    })

    ->when($request->rt, function ($query) use ($request) {
        $query->whereHas('warga.rt', function ($q) use ($request) {
            $q->where('id', $request->rt);
        });
    })

    ->when($request->kategori, function ($query) use ($request) {
        $query->where('kategori_keterampilan_id', $request->kategori);
    })

    ->when($request->tahun, function ($query) use ($request) {
        $query->whereYear('created_at', $request->tahun);
    });
}
}
