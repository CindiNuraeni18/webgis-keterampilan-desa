@extends('layouts.sidebar-admin')

@section('title', 'Data RW')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">Data RW</h4>
                <p class="text-muted mb-0">Kelola data RW berdasarkan dusun.</p>
            </div>

            <div class="d-flex gap-2">
                <form action="{{ route('admin.rw.index') }}" method="GET" class="d-flex gap-2">
                    <input type="text" name="search" class="form-control" placeholder="Cari RW / dusun" value="{{ request('search') }}">
                    <button type="submit" class="btn btn-outline-primary">Cari</button>
                </form>
                <a href="{{ route('admin.rw.create') }}" class="btn btn-primary">Tambah</a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th width="60">No</th>
                    <th>Nomor RW</th>
                    <th>Dusun</th>
                    <th width="200">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rws as $key => $rw)
                    <tr>
                        <td>{{ $rws->firstItem() + $key }}</td>
                        <td>{{ $rw->nomor_rw }}</td>
                        <td>{{ $rw->dusun->nama_dusun }}</td>
                        <td>
                            <a href="{{ route('admin.rw.show', $rw->id) }}" class="btn btn-info btn-sm">Detail</a>
                            <a href="{{ route('admin.rw.edit', $rw->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.rw.destroy', $rw->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus data?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Data RW belum ada.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $rws->links() }}
    </div>
</div>
@endsection