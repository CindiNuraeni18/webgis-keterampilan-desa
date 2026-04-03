@extends('layouts.sidebar-admin')

@section('title', 'Data Dusun')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">Data Dusun</h4>
                <p class="text-muted mb-0">Kelola data dusun.</p>
            </div>

            <div class="d-flex gap-2">
                <form action="{{ route('admin.dusun.index') }}" method="GET" class="d-flex gap-2">
                    <input type="text" name="search" class="form-control" placeholder="Cari dusun" value="{{ request('search') }}">
                    <button type="submit" class="btn btn-outline-primary">Cari</button>
                </form>
                <a href="{{ route('admin.dusun.create') }}" class="btn btn-primary">Tambah</a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th width="60">No</th>
                    <th>Nama Dusun</th>
                    <th width="200">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dusuns as $key => $dusun)
                    <tr>
                        <td>{{ $dusuns->firstItem() + $key }}</td>
                        <td>{{ $dusun->nama_dusun }}</td>
                        <td>
                            <a href="{{ route('admin.dusun.show', $dusun->id) }}" class="btn btn-info btn-sm">Detail</a>
                            <a href="{{ route('admin.dusun.edit', $dusun->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.dusun.destroy', $dusun->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus data?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">Data dusun belum ada.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $dusuns->links() }}
    </div>
</div>
@endsection