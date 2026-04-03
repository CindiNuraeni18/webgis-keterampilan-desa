@extends('layouts.sidebar-admin')

@section('title', 'Detail Data Warga')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h4 class="mb-4">Detail Data Warga</h4>

        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <th width="250">NIK</th>
                    <td>{{ $warga->nik }}</td>
                </tr>
                <tr>
                    <th>Nama Lengkap</th>
                    <td>{{ $warga->nama }}</td>
                </tr>
                <tr>
                    <th>Jenis Kelamin</th>
                    <td>{{ $warga->jenis_kelamin }}</td>
                </tr>
                <tr>
                    <th>Tempat Lahir</th>
                    <td>{{ $warga->tempat_lahir }}</td>
                </tr>
                <tr>
                    <th>Tanggal Lahir</th>
                    <td>{{ $warga->tanggal_lahir }}</td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <td>{{ $warga->alamat }}</td>
                </tr>
                <tr>
                    <th>RT</th>
                    <td>{{ $warga->rt->nomor_rt }}</td>
                </tr>
                <tr>
                    <th>RW</th>
                    <td>{{ $warga->rt->rw->nomor_rw }}</td>
                </tr>
                <tr>
                    <th>Dusun</th>
                    <td>{{ $warga->rt->rw->dusun->nama_dusun }}</td>
                </tr>
                <tr>
                    <th>No HP</th>
                    <td>{{ $warga->no_hp ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Pekerjaan</th>
                    <td>{{ $warga->pekerjaan ?? '-' }}</td>
                </tr>
            </table>
        </div>

        <a href="{{ route('admin.warga.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection