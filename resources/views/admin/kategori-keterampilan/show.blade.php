@extends('layouts.sidebar-admin')

@section('title', 'Detail Kategori Keterampilan')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h4 class="mb-4">Detail Kategori Keterampilan</h4>

        <table class="table table-bordered">
            <tr>
                <th width="200">Nama Kategori</th>
                <td>{{ $kategori_keterampilan->nama_kategori }}</td>
            </tr>
        </table>

        <a href="{{ route('admin.kategori-keterampilan.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection