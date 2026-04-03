@extends('layouts.sidebar-admin')

@section('title', 'Data RT')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">Data RT</h4>
                <p class="text-muted mb-0">Kelola data RT berdasarkan RW dan dusun.</p>
            </div>

            <div class="d-flex gap-2">
                <form action="{{ route('admin.rt.index') }}" method="GET" class="d-flex gap-2">
                    <input type="text" name="search" class="form-control" placeholder="Cari RT / RW / dusun" value="{{ request('search') }}">
                    <button type="submit" class="btn btn-outline-primary">Cari</button>
                </form>
                <a href="{{ route('admin.rt.create') }}" class="btn btn-primary">Tambah</a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th width="60">No</th>
                    <th>Nomor RT</th>
                    <th>Nomor RW</th>
                    <th>Dusun</th>
                    <th width="200">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rts as $key => $rt)
                    <tr>
                        <td>{{ $rts->firstItem() + $key }}</td>
                        <td>{{ $rt->nomor_rt }}</td>
                        <td>{{ $rt->rw->nomor_rw }}</td>
                        <td>{{ $rt->rw->dusun->nama_dusun }}</td>
                        <td>
                            <a href="{{ route('admin.rt.show', $rt->id) }}" class="btn btn-info btn-sm">Detail</a>
                            <a href="{{ route('admin.rt.edit', $rt->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.rt.destroy', $rt->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus data?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Data RT belum ada.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $rts->links() }}
    </div>
</div>
@endsection