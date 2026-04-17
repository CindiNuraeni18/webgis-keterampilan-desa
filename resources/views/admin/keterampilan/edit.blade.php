@extends('layouts.sidebar-admin')

@section('title', 'Edit Data Keterampilan')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h4 class="mb-4">Edit Data Keterampilan</h4>

        <form action="{{ route('admin.keterampilan.update', $keterampilan->id) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.keterampilan.form')

            <button type="submit" class="btn btn-warning">Update</button>
            <a href="{{ route('admin.keterampilan.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection