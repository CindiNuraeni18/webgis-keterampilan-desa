@extends('layouts.sidebar-admin')

@section('title', 'Edit RT')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h4 class="mb-4">Edit Data RT</h4>

        <form action="{{ route('admin.rt.update', $rt->id) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.rt.form')

            <button type="submit" class="btn btn-warning">Update</button>
            <a href="{{ route('admin.rt.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection