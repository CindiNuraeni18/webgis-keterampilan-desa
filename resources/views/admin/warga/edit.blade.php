@extends('layouts.sidebar-admin')

@section('title', 'Edit Data Warga')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h4 class="mb-4">Edit Data Warga</h4>

        <form action="{{ route('admin.warga.update', $warga->id) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.warga.form')

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-warning">
                    <i class="bi bi-pencil-square me-1"></i> Update
                </button>
                <a href="{{ route('admin.warga.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection