@extends('layouts.sidebar-admin')

@section('title', 'Detail RW')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h4 class="mb-4">Detail RW</h4>

        <table class="table table-bordered">
            <tr>
                <th width="200">Nomor RW</th>
                <td>{{ $rw->nomor_rw }}</td>
            </tr>
            <tr>
                <th>Dusun</th>
                <td>{{ $rw->dusun->nama_dusun }}</td>
            </tr>
        </table>

        <a href="{{ route('admin.rw.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection