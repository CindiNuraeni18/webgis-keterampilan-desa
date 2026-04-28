@extends('layouts.sidebar-admin')

@section('title','Detail RW')

@section('content')

<div class="card shadow-sm border-0">
<div class="card-body">

<h4 class="mb-3">
Detail RW {{ $rw->nomor_rw }}
</h4>

<p>
<b>Dusun:</b>
{{ $rw->dusun->nama_dusun }}
</p>

<hr>

<h5>Data Warga & Keterampilan</h5>

<table class="table table-bordered">

<thead>
<tr>
<th>No</th>
<th>Nama</th>
<th>Keterampilan</th>
<th>Kategori</th>
<th>Dusun</th>
</tr>
</thead>

<tbody>

@php $no=1; @endphp

@foreach($rw->rts as $rt)

@foreach($rt->wargas as $warga)

@foreach($warga->keterampilans as $skill)

<tr>

<td>{{ $no++ }}</td>

<td>{{ $warga->nama }}</td>

<td>{{ $skill->nama_keterampilan }}</td>

<td>{{ $skill->kategori->nama_kategori }}</td>

<td>{{ $rw->dusun->nama_dusun }}</td>

</tr>

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