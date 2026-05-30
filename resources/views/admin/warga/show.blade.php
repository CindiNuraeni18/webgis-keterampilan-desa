@extends('layouts.sidebar-admin')

@section('title', 'Detail Data Warga')

@section('content')

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

<style>

/* =========================
   ANIMASI
========================= */

@keyframes fadeUp{

    from{
        opacity:0;
        transform:translateY(20px);
    }

    to{
        opacity:1;
        transform:translateY(0);
    }

}



/* =========================
   CARD
========================= */

.detail-card{

    border:none;

    border-radius:24px;

    background:white;

    padding:28px;

    animation:fadeUp .45s ease;

    box-shadow:
    0 10px 30px rgba(0,0,0,.05);

}



/* =========================
   TITLE
========================= */

.page-title{

    font-size:30px;

    font-weight:700;

    color:#1e293b;

}

.page-subtitle{

    color:#64748b;

    margin-top:4px;

}



/* =========================
   TABLE
========================= */

.table-detail{

    margin-top:25px;

    margin-bottom:0;

    border-radius:18px;

    overflow:hidden;

}

.table-detail tr{

    transition:.25s ease;

}

.table-detail tr:hover{

    background:#f8fbff;

}

.table-detail th{

    width:240px;

    background:#f8fafc;

    color:#334155;

    font-weight:600;

    padding:16px;

    border-color:#e2e8f0;

}

.table-detail td{

    padding:16px;

    border-color:#e2e8f0;

    color:#334155;

}



/* =========================
   KETERAMPILAN
========================= */

.skill-box{

    border:
    1px solid #e2e8f0;

    border-radius:16px;

    padding:16px;

    margin-bottom:16px;

    background:#fff;

    transition:.25s ease;

}

.skill-box:hover{

    transform:translateY(-2px);

    box-shadow:
    0 8px 20px rgba(0,0,0,.05);

}



/* LABEL */
.skill-label{

    font-size:13px;

    font-weight:600;

    color:#64748b;

    margin-bottom:6px;

}



/* VALUE */
.skill-value{

    color:#1e293b;

    font-weight:500;

}



/* =========================
   BUTTON BACK
========================= */

.btn-back {
    border-radius: 14px;
    padding: 13px;
    font-weight: 600;
    background: #f3f6fb;
    color: #374151;
    border: 1px solid #e5e7eb;
    transition: all .3s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration:none;
}

.btn-back:hover {
    background: #e8eefc;
    color: #2563eb;
    transform: translateY(-2px);
    box-shadow: 0 8px 18px rgba(37, 99, 235, .12);
}

.btn-back i {
    transition: .3s ease;
}

.btn-back:hover i {
    transform: translateX(-4px);
}



/* =========================
   RESPONSIVE
========================= */

@media(max-width:768px){

    .detail-card{

        padding:20px;

    }

    .page-title{

        font-size:24px;

    }

    .table-detail th{

        width:140px;

        font-size:13px;

    }

    .table-detail td{

        font-size:13px;

    }

}

</style>



<div class="detail-card">

    <!-- TITLE -->
    <div class="mb-4">

        <h2 class="page-title">

            Detail Data Warga

        </h2>

        <div class="page-subtitle">

            Informasi lengkap data warga dan keterampilan

        </div>

    </div>



    <!-- TABLE -->
    <div class="table-responsive">

        <table class="table table-bordered align-middle table-detail">

            <tr>

                <th>NIK</th>

                <td>{{ $warga->nik }}</td>

            </tr>



            <tr>

                <th>Nama Lengkap</th>

                <td>{{ $warga->nama }}</td>

            </tr>



            <tr>

                <th>Jenis Kelamin</th>

                <td>{{ $warga->jenis_kelamin }}</td>

            </tr>



            <tr>

                <th>Tempat Lahir</th>

                <td>{{ $warga->tempat_lahir }}</td>

            </tr>



            <tr>

                <th>Tanggal Lahir</th>

                <td>

                    {{ \Carbon\Carbon::parse($warga->tanggal_lahir)->translatedFormat('d F Y') }}

                </td>

            </tr>



            <tr>

                <th>RT</th>

                <td>{{ $warga->rt->nomor_rt }}</td>

            </tr>



            <tr>

                <th>RW</th>

                <td>{{ $warga->rt->rw->nomor_rw }}</td>

            </tr>



            <tr>

                <th>Dusun</th>

                <td>{{ $warga->rt->rw->dusun->nama_dusun }}</td>

            </tr>



            <tr>

                <th>No HP</th>

                <td>{{ $warga->no_hp ?? '-' }}</td>

            </tr>



            <!-- KETERAMPILAN -->
            <tr>

                <th>
                    Keterampilan
                </th>

                <td>

                    @forelse($warga->keterampilans as $skill)

                        <div class="skill-box">

                            <!-- KATEGORI -->
                            <div class="mb-3">

                                <div class="skill-label">

                                    Kategori

                                </div>

                                <div class="skill-value">

                                    {{ $skill->kategori->nama_kategori ?? '-' }}

                                </div>

                            </div>



                            <!-- KETERAMPILAN -->
                            <div class="mb-3">

                                <div class="skill-label">

                                    Keterampilan

                                </div>

                                <div class="skill-value">

                                    {{ $skill->nama_keterampilan }}

                                </div>

                            </div>



                            <!-- PENGALAMAN -->
                            <div>

                                <div class="skill-label">

                                    Pengalaman

                                </div>

                                <div class="skill-value">

                                    {{ $skill->pengalaman ?? '-' }}

                                </div>

                            </div>

                        </div>

                    @empty

                        <span class="text-muted">

                            Belum ada keterampilan

                        </span>

                    @endforelse

                </td>

            </tr>

        </table>

    </div>



    <!-- BUTTON -->
    <div class="mt-4">

        <a href="{{ route('admin.warga.index') }}"
            class="btn btn-back px-4">

            <i class="fa-solid fa-arrow-left me-2"></i>

            <span>
                Kembali
            </span>

        </a>

    </div>

</div>

@endsection