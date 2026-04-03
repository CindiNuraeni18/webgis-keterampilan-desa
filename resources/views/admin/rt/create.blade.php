@extends('layouts.sidebar-admin')

@section('title', 'Tambah RT')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h4 class="mb-4">Tambah Data RT</h4>

        <form action="{{ route('admin.rt.store') }}" method="POST">
            @csrf
            @include('admin.rt.form')

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.rt.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection