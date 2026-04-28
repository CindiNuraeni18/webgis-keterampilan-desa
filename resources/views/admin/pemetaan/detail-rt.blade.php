@extends('layouts.sidebar-admin')

@section('title','Detail RT')

@section('content')

<div class="card shadow-sm border-0">
<div class="card-body">

<h4 class="mb-3">Detail RT {{ $rt->nomor_rt }}</h4>

<p>
<b>RW :</b> {{ optional($rt->rw)->nomor_rw }}
&nbsp; | &nbsp;
<b>Dusun :</b> {{ optional($rt->rw->dusun)->nama_dusun }}
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
@foreach($rt->wargas as $i => $warga)

@foreach($warga->keterampilans as $skill)

<tr>
<td>{{ $i+1 }}</td>
<td>{{ $warga->nama }}</td>
<td>{{ $skill->nama_keterampilan }}</td>
<td>{{ $skill->kategori->nama_kategori }}</td>
<td>{{ optional($rt->rw->dusun)->nama_dusun }}</td>
</tr>

@endforeach

@endforeach
</tbody>
</table>

<a href="{{ route('admin.pemetaan.index') }}" class="btn btn-secondary">
Kembali ke Peta
</a>

</div>
</div>

@endsection