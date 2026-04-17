@extends('layouts.sidebar-admin')

@section('title', 'Tambah Kategori Keterampilan')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h4 class="mb-4">Tambah Kategori Keterampilan</h4>

        <form action="{{ route('admin.kategori-keterampilan.store') }}" method="POST">
            @csrf
            @include('admin.kategori-keterampilan.form')

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.kategori-keterampilan.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection