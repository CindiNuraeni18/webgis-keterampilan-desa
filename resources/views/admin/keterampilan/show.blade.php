@extends('layouts.sidebar-admin')

@section('title', 'Detail Data Keterampilan')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h4 class="mb-4">Detail Data Keterampilan</h4>

        <table class="table table-bordered">
            <tr>
                <th width="220">Nama Warga</th>
                <td>{{ $keterampilan->warga->nama }}</td>
            </tr>
            <tr>
                <th>Dusun</th>
                <td>{{ $keterampilan->warga->rt->rw->dusun->nama_dusun }}</td>
            </tr>
            <tr>
                <th>RW</th>
                <td>{{ $keterampilan->warga->rt->rw->nomor_rw }}</td>
            </tr>
            <tr>
                <th>RT</th>
                <td>{{ $keterampilan->warga->rt->nomor_rt }}</td>
            </tr>
            <tr>
                <th>Kategori</th>
                <td>{{ $keterampilan->kategori->nama_kategori }}</td>
            </tr>
            <tr>
                <th>Nama Keterampilan</th>
                <td>{{ $keterampilan->nama_keterampilan }}</td>
            </tr>
            <tr>
                <th>Tingkat Keahlian</th>
                <td>{{ $keterampilan->tingkat_keahlian ?? '-' }}</td>
            </tr>
            <tr>
                <th>Pengalaman</th>
                <td>{{ $keterampilan->pengalaman ?? '-' }}</td>
            </tr>
            <tr>
                <th>Keterangan</th>
                <td>{{ $keterampilan->keterangan ?? '-' }}</td>
            </tr>
        </table>

        <a href="{{ route('admin.keterampilan.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection