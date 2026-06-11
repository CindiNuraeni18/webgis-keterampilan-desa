<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
</head>

<body>

    <!-- SPASI ATAS (biar judul turun) -->
    <br><br><br><br><br>

    <!-- JUDUL -->
    <h3 style="text-align:center; margin:0;">
        LAPORAN KETERAMPILAN WARGA
    </h3>

    <p style="text-align:center; margin:2px 0;">
        Desa Karangmulya <br>
        Kecamatan Kandanghaur, Kabupaten Indramayu
    </p>

    <!-- INFO -->
    <p style="text-align:right; margin:5px 0;">
        Dicetak: {{ \Carbon\Carbon::now('Asia/Jakarta')->format('d-m-Y H:i') }} WIB
    </p>
    <tr>
        <td colspan="7">
            Total Warga Terampil : {{ $totalWarga }} Orang
        </td>
    </tr>
    <br>
    <tr>
        <td colspan="7">
            Total Keterampilan : {{ $totalKeterampilan }} Data
        </td>
    </tr>
    <br>
    <tr>
        <td colspan="7">
            Total Kategori Keterampilan : {{ $totalKategori }} Kategori
        </td>
    </tr>
    <br>
    @foreach ($statistikKategori as $kategori => $jumlah)
        <tr>
            <td colspan="7">
                {{ $loop->iteration }}. {{ ucfirst($kategori) }}
                : {{ $jumlah }} Orang
            </td>
        </tr>
    @endforeach
    <!-- JARAK KE TABEL (diperkecil) -->
    <br>

    <!-- TABEL (naik ke atas) -->
    <table border="1" cellpadding="5" cellspacing="0" width="100%">
        <thead>
            <tr style="text-align:center;">
                <th>No</th>
                <th>Nama Warga</th>
                <th>Dusun</th>
                <th>RW</th>
                <th>RT</th>
                <th>Kategori</th>
                <th>Keterampilan</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($laporans as $index => $item)
                <tr style="text-align:center; vertical-align:middle;">
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->warga->nama ?? '-' }}</td>
                    <td>{{ $item->warga->rt->rw->dusun->nama_dusun ?? '-' }}</td>
                    <td>{{ $item->warga->rt->rw->nomor_rw ?? '-' }}</td>
                    <td>{{ $item->warga->rt->nomor_rt ?? '-' }}</td>
                    <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                    <td>{{ $item->nama_keterampilan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
