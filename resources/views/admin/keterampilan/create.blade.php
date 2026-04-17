@extends('layouts.sidebar-admin')

@section('title', 'Tambah Data Keterampilan')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h4 class="mb-4">Tambah Data Keterampilan</h4>

        <form action="{{ route('admin.keterampilan.store') }}" method="POST">
            @csrf
            @include('admin.keterampilan.form')

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.keterampilan.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection