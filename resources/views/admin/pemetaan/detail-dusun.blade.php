@extends('layouts.sidebar-admin')

@section('title','Detail Dusun')

@section('content')

<div class="card shadow-sm border-0">
<div class="card-body">

<h4>
Detail Dusun {{ $dusun->nama_dusun }}
</h4>

<hr>

<table class="table table-bordered">

<thead>

<tr>
<th>No</th>
<th>Nama</th>
<th>Keterampilan</th>
<th>Kategori</th>
<th>RW</th>
<th>RT</th>
</tr>

</thead>

<tbody>

@php $no = 1; @endphp

@foreach($dusun->rws as $rw)
@foreach($rw->rts as $rt)
@foreach($rt->wargas as $warga)
@foreach($warga->keterampilans as $skill)

<tr>

<td>{{ $no++ }}</td>

<td>{{ $warga->nama }}</td>

<td>{{ $skill->nama_keterampilan }}</td>

<td>{{ $skill->kategori->nama_kategori }}</td>

<td>{{ $rw->nomor_rw }}</td>

<td>{{ $rt->nomor_rt }}</td>

</tr>

@endforeach
@endforeach
@endforeach
@endforeach

</tbody>

</table>

<a href="{{ route('admin.pemetaan.index') }}"
class="btn btn-secondary">

Kembali ke Peta

</a>

</div>
</div>

@endsection