@extends('layouts.sidebar-admin')

@section('title', 'Tambah Dusun')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h4 class="mb-4">Tambah Data Dusun</h4>

        <form action="{{ route('admin.dusun.store') }}" method="POST">
            @csrf
            @include('admin.dusun.form')

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.dusun.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection