@extends('layouts.sidebar-admin')

@section('title', 'Tambah RW')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h4 class="mb-4">Tambah Data RW</h4>

        <form action="{{ route('admin.rw.store') }}" method="POST">
            @csrf
            @include('admin.rw.form')

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.rw.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection