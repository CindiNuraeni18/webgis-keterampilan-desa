@extends('layouts.sidebar-admin')

@section('title', 'Edit RW')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h4 class="mb-4">Edit Data RW</h4>

        <form action="{{ route('admin.rw.update', $rw->id) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.rw.form')

            <button type="submit" class="btn btn-warning">Update</button>
            <a href="{{ route('admin.rw.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection