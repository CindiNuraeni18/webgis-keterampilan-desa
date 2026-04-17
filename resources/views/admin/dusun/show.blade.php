@extends('layouts.sidebar-admin')

@section('title', 'Detail Dusun')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h4 class="mb-4">Detail Dusun</h4>

        <table class="table table-bordered">
            <tr>
                <th width="200">Nama Dusun</th>
                <td>{{ $dusun->nama_dusun }}</td>
            </tr>
            <tr>
    <th>Latitude</th>
    <td>{{ $dusun->latitude ?? '-' }}</td>
</tr>
<tr>
    <th>Longitude</th>
    <td>{{ $dusun->longitude ?? '-' }}</td>
</tr>
        </table>

        <a href="{{ route('admin.dusun.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection