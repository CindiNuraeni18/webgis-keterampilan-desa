@extends('layouts.sidebar-admin')

@section('title', 'Detail RT')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h4 class="mb-4">Detail RT</h4>

        <table class="table table-bordered">
            <tr>
                <th width="200">Nomor RT</th>
                <td>{{ $rt->nomor_rt }}</td>
            </tr>
            <tr>
                <th>Nomor RW</th>
                <td>{{ $rt->rw->nomor_rw }}</td>
            </tr>
            <tr>
                <th>Dusun</th>
                <td>{{ $rt->rw->dusun->nama_dusun }}</td>
            </tr>
            <tr>
    <th>Latitude</th>
    <td>{{ $rt->latitude ?? '-' }}</td>
</tr>
<tr>
    <th>Longitude</th>
    <td>{{ $rt->longitude ?? '-' }}</td>
</tr>
        </table>

        <a href="{{ route('admin.rt.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection