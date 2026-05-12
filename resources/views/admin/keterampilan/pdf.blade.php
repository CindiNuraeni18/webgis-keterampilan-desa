<!DOCTYPE html>
<html>

<head>
    <title>Laporan Keterampilan</title>

    <style>
        @page {
            margin: 40px 30px;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid black;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .header img {
            width: 70px;
            margin-bottom: 5px;
        }

        .header h2 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
        }

        .header p {
            margin: 2px 0;
            font-size: 12px;
        }

        .info {
            text-align: right;
            font-size: 11px;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #555;
            padding: 5px;
            text-align: center;
            font-size: 11px;
        }

        th {
            background: #eaeaea;
        }

        /* ❌ HAPUS nth-child biar lebih cepat */
    </style>
</head>

<body>

    <div class="header">
        <!-- ✅ FIX gambar -->
        @php
            $path = public_path('images/logo-indramayu.png');
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        @endphp

        <img src="{{ $base64 }}" style="width:70px;">

        <h2>Laporan Keterampilan Warga</h2>
        <p><strong>Desa Karangmulya</strong></p>
        <p>Kecamatan Kandanghaur, Kabupaten Indramayu</p>
    </div>

    <div class="info">
        Dicetak: {{ \Carbon\Carbon::now('Asia/Jakarta')->format('d-m-Y H:i') }} WIB
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Warga</th>
                <th>NIK</th>
                <th>Dusun</th>
                <th>RW</th>
                <th>RT</th>
                <th>Kategori</th>
                <th>Keterampilan</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($laporans as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->warga->nama ?? '-' }}</td>
                    <td>{{ $item->warga->nik ?? '-' }}</td>
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
