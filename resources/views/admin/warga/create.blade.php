@extends('layouts.sidebar-admin')

@section('title', 'Tambah Data Warga')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h4 class="mb-4">Tambah Data Warga</h4>

        <form action="{{ route('admin.warga.store') }}" method="POST">
            @csrf
            @include('admin.warga.form')

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Simpan
                </button>
                <a href="{{ route('admin.warga.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection