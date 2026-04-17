@extends('layouts.sidebar-admin')

@section('title', 'Edit Kategori Keterampilan')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h4 class="mb-4">Edit Kategori Keterampilan</h4>

        <form action="{{ route('admin.kategori-keterampilan.update', $kategori_keterampilan->id) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.kategori-keterampilan.form')

            <button type="submit" class="btn btn-warning">Update</button>
            <a href="{{ route('admin.kategori-keterampilan.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection