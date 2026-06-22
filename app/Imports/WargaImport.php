<?php

namespace App\Imports;

use App\Models\Rt;
use App\Models\Warga;
use App\Models\Keterampilan;
use App\Models\KategoriKeterampilan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;

class WargaImport implements ToModel, WithHeadingRow
{
    public $berhasil = 0;
    public $duplikat = 0;
    public $gagal = 0;
    public $skillBaru = 0;

    public function model(array $row)
    {
        // Cari RT berdasarkan nomor_rt di Excel
        if (
    empty($row['rt']) ||
    empty($row['rw']) ||
    empty($row['dusun'])
) {

    \Log::warning(
        'Data wilayah tidak lengkap',
        $row
    );

    return null;
}
    $rt = Rt::where(
    'nomor_rt',
    str_pad($row['rt'], 2, '0', STR_PAD_LEFT)
)
->whereHas('rw', function($q) use ($row){

   $q->where(
    'nomor_rw',
    str_pad($row['rw'], 2, '0', STR_PAD_LEFT)
)

    ->whereHas('dusun', function($d) use ($row){

        $d->whereRaw(
    'LOWER(nama_dusun) = ?',
    [strtolower(trim($row['dusun']))]
);

    });

})
->first();

if (!$rt) {

    \Log::info('RT tidak ditemukan', $row);

    return null;
}
if (
    empty($row['nik']) ||
    strlen(preg_replace('/\D/', '', $row['nik'])) != 16
) {

    \Log::warning(
        'NIK tidak valid',
        $row
    );

    return null;
}
        // Simpan warga atau ambil jika sudah ada
        $warga = Warga::where(
    'nik',
    trim($row['nik'])
)->first();

if (!$warga) {

    $warga = Warga::create([

        'rt_id' => $rt->id,

        'nik' => trim($row['nik']),

        'nama' => $row['nama'],

        'jenis_kelamin' => $row['jenis_kelamin'],

        'tempat_lahir' => $row['tempat_lahir'],

       'tanggal_lahir' => is_numeric($row['tanggal_lahir'])
    ? Date::excelToDateTimeObject(
        $row['tanggal_lahir']
      )->format('Y-m-d')
    : Carbon::parse(
        $row['tanggal_lahir']
      )->format('Y-m-d'),

        'no_hp' => $row['no_hp'] ?? null,

    ]);

    $this->berhasil++;

} else {

    $this->duplikat++;

}

        // Simpan keterampilan
        if (
            !empty($row['kategori_keterampilan']) &&
            !empty($row['nama_keterampilan'])
        ) {

            $kategori =
            KategoriKeterampilan::firstOrCreate([

                'nama_kategori' =>
                $row['kategori_keterampilan']

            ]);

            $cekSkill = Keterampilan::where(
                'warga_id',
                $warga->id
            )
            ->where(
                'nama_keterampilan',
                $row['nama_keterampilan']
            )
            ->first();

            if (!$cekSkill) {

    Keterampilan::create([

        'warga_id' => $warga->id,

        'kategori_keterampilan_id' => $kategori->id,

        'nama_keterampilan' => $row['nama_keterampilan'],

        'pengalaman' => $row['pengalaman'] ?? null,

    ]);

    $this->skillBaru++;
}
        }

        return $warga;
    }
}