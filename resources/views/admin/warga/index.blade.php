@extends('layouts.sidebar-admin')

@section('title', 'Data Warga')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <div>
                <h4 class="mb-1">Data Warga</h4>
                <p class="text-muted mb-0">Kelola data warga Desa Karangmulya.</p>
            </div>

            <div class="d-flex gap-2">
                <form action="{{ route('admin.warga.index') }}" method="GET" class="d-flex gap-2">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama / NIK" value="{{ request('search') }}">
                    <button type="submit" class="btn btn-outline-primary">Cari</button>
                </form>

                <a href="{{ route('admin.warga.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i> Tambah
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="60">No</th>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>JK</th>
                        <th>RT</th>
                        <th>RW</th>
                        <th>Dusun</th>
                        <th>No HP</th>
                        <th>Pekerjaan</th>
                        <th width="220">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($wargas as $key => $warga)
                        <tr>
                            <td>{{ $wargas->firstItem() + $key }}</td>
                            <td>{{ $warga->nik }}</td>
                            <td>{{ $warga->nama }}</td>
                            <td>{{ $warga->jenis_kelamin }}</td>
                            <td>{{ $warga->rt->nomor_rt }}</td>
                            <td>{{ $warga->rt->rw->nomor_rw }}</td>
                            <td>{{ $warga->rt->rw->dusun->nama_dusun }}</td>
                            <td>{{ $warga->no_hp ?? '-' }}</td>
                            <td>{{ $warga->pekerjaan ?? '-' }}</td>
                            <td>
                                <a href="{{ route('admin.warga.show', $warga->id) }}" class="btn btn-info btn-sm">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.warga.edit', $warga->id) }}" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('admin.warga.destroy', $warga->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted">Data warga belum tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $wargas->links() }}
        </div>
    </div>
</div>
@endsection