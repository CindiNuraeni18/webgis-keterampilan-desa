@extends('layouts.sidebar-admin')

@section('title', 'Edit Dusun')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h4 class="mb-4">Edit Data Dusun</h4>

        <form action="{{ route('admin.dusun.update', $dusun->id) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.dusun.form')

            <button type="submit" class="btn btn-warning">Update</button>
            <a href="{{ route('admin.dusun.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection