@extends('layouts.sidebar-admin')

@section('title', 'Data Warga')

@section('content')
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
<style>

/* =========================
   ANIMASI GLOBAL
========================= */
:root{
    --anim-speed: 0.85s;
    --anim-ease: cubic-bezier(0.4,0,0.2,1);
}

@keyframes fadeIn{
    from{
        opacity:0;
    }
    to{
        opacity:1;
    }
}

@keyframes slideInUp{
    from{
        opacity:0;
        transform:translateY(25px);
    }
    to{
        opacity:1;
        transform:translateY(0);
    }
}



/* =========================
   CARD & TABLE
========================= */
.card{
    border-radius:12px;
    transition:0.3s ease;
}

.card:hover{
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
    transform:translateY(-2px);
}

.table-responsive{
    border-radius:10px;
    overflow-x:auto;
    box-shadow:0 2px 6px rgba(0,0,0,0.05);
    animation:slideInUp var(--anim-speed) var(--anim-ease);
}

.table{
    margin-bottom:0;
}

.table tbody tr{
    animation:fadeIn var(--anim-speed) var(--anim-ease);
    animation-fill-mode:both;
    transition:0.2s ease;
}

.table tbody tr:hover{
    background-color:rgba(13,110,253,0.05);
    transform:translateX(3px);
}



/* =========================
   STICKY
========================= */
.sticky-col{
    position:sticky;
    right:0;
    background:#fff;
    z-index:2;
}

thead .sticky-col{
    background:#f8f9fa;
    z-index:3;
}



/* =========================
   SEARCH
========================= */
.search-wrapper{
    flex:1;
    max-width:380px;
}

.search-group{
    display:flex;
    align-items:center;
    width:100%;
    border-radius:12px;
    overflow:hidden;
    border:1px solid #e2e8f0;
    background:#fff;
    transition:0.2s ease;
}

.search-group:focus-within{
    border-color:#0d6efd;
    box-shadow:0 0 0 3px rgba(13,110,253,0.15);
}

.search-group input{
    flex:1;
    border:none;
    outline:none;
    padding:6px 10px;
}

.search-group .input-group-text{
    border:none;
    background:#0d6efd;
    color:white;
}



/* =========================
   BADGE
========================= */

.badge-skill{
    background:linear-gradient(
        135deg,
        #2563eb,
        #3b82f6
    );
    color:white;
    font-size:12px;
    padding:7px 10px;
    border-radius:10px;
    margin:2px;
    display:inline-block;
}

.badge-kategori{
    background:#fef3c7;
    color:#92400e;
    font-size:12px;
    padding:7px 10px;
    border-radius:10px;
    margin:2px;
    display:inline-block;
}



/* =========================
   BUTTON EDIT
========================= */

.btn-edit-modern{
    border:none;
    border-radius:12px;
    width:38px;
    height:38px;
    display:flex;
    align-items:center;
    justify-content:center;
    background:linear-gradient(
        135deg,
        #f59e0b,
        #fbbf24
    );
    color:white;
    transition:all .3s ease;
    box-shadow:0 4px 10px rgba(245,158,11,.2);
}

.btn-edit-modern:hover{
    transform:translateY(-2px) scale(1.05);
    box-shadow:0 8px 18px rgba(245,158,11,.35);
    color:white;
}



/* =========================
   BUTTON DELETE
========================= */

.btn-delete-modern{
    border:none;
    border-radius:12px;
    width:38px;
    height:38px;
    display:flex;
    align-items:center;
    justify-content:center;
    background:linear-gradient(
        135deg,
        #ef4444,
        #dc2626
    );
    color:white;
    transition:all .3s ease;
    box-shadow:0 4px 10px rgba(239,68,68,.2);
}

.btn-delete-modern:hover{
    transform:translateY(-2px) scale(1.05);
    box-shadow:0 8px 18px rgba(239,68,68,.35);
    color:white;
}



/* =========================
   BUTTON DETAIL
========================= */

.btn-detail-modern{
    border:none;
    border-radius:12px;
    width:38px;
    height:38px;
    display:flex;
    align-items:center;
    justify-content:center;
    background:linear-gradient(
        135deg,
        #0ea5e9,
        #38bdf8
    );
    color:white;
    transition:all .3s ease;
    box-shadow:0 4px 10px rgba(14,165,233,.2);
}

.btn-detail-modern:hover{
    transform:translateY(-2px) scale(1.05);
    box-shadow:0 8px 18px rgba(14,165,233,.35);
    color:white;
}



/* =========================
   BUTTON SAVE
========================= */

.btn-save{

    position: relative;

    overflow: hidden;

    border: none;

    border-radius: 14px;

    background: linear-gradient(
        135deg,
        #2563eb,
        #3b82f6
    );

    color: white !important;

    font-weight: 600;

    transition: all .35s ease;

    box-shadow:
        0 6px 18px rgba(37,99,235,.25);

}

.btn-save::before{

    content: '';

    position: absolute;

    top: 0;

    left: -75%;

    width: 50%;

    height: 100%;

    background: rgba(255,255,255,.22);

    transform: skewX(-25deg);

    transition: .7s;

}

.btn-save:hover{

    transform:
        translateY(-2px)
        scale(1.03);

    box-shadow:
        0 10px 24px rgba(37,99,235,.35);

    color: white !important;

}

.btn-save:hover::before{
    left:130%;
}



/* =========================
   RESPONSIVE
========================= */

@media (max-width:768px){

    .table{
        font-size:12px;
        white-space:nowrap;
    }

    .search-wrapper{
        max-width:100%;
        width:100%;
    }

}

/* =========================
   ALERT MODERN
========================= */

.custom-alert{

    border:none;

    border-radius:18px;

    padding:16px 18px;

    animation:fadeIn .4s ease;

}

.success-alert{

    background:
    linear-gradient(
        135deg,
        #ecfdf5,
        #d1fae5
    );

    border-left:
    5px solid #10b981;

}

.alert-icon{

    width:52px;

    height:52px;

    border-radius:16px;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:22px;

    color:white;

    flex-shrink:0;

}

.success-icon{

    background:
    linear-gradient(
        135deg,
        #10b981,
        #34d399
    );

}
/* =========================
   SWEET ALERT BUTTON MODERN
========================= */

.btn-delete-swal{

    position: relative;

    overflow: hidden;

    border: none;

    border-radius: 14px;

    padding: 12px 24px;

    background: linear-gradient(
        135deg,
        #ef4444,
        #dc2626
    );

    color: white;

    font-weight: 600;

    font-size: 15px;

    transition: all .35s ease;

    box-shadow:
        0 6px 18px rgba(239,68,68,.25);

    margin-left: 10px;

}

.btn-delete-swal::before{

    content: '';

    position: absolute;

    top: 0;

    left: -75%;

    width: 50%;

    height: 100%;

    background: rgba(255,255,255,.25);

    transform: skewX(-25deg);

    transition: .7s;

}

.btn-delete-swal:hover{

    transform:
        translateY(-2px)
        scale(1.04);

    box-shadow:
        0 10px 22px rgba(239,68,68,.4);

}

.btn-delete-swal:hover::before{

    left: 130%;

}



/* CANCEL */
.btn-cancel-swal{

    position: relative;

    overflow: hidden;

    border: none;

    border-radius: 14px;

    padding: 12px 24px;

    background: linear-gradient(
        135deg,
        #6b7280,
        #4b5563
    );

    color: white;

    font-weight: 600;

    font-size: 15px;

    transition: all .35s ease;

    box-shadow:
        0 6px 18px rgba(107,114,128,.2);

}

.btn-cancel-swal::before{

    content: '';

    position: absolute;

    top: 0;

    left: -75%;

    width: 50%;

    height: 100%;

    background: rgba(255,255,255,.2);

    transform: skewX(-25deg);

    transition: .7s;

}

.btn-cancel-swal:hover{

    transform:
        translateY(-2px)
        scale(1.04);

    box-shadow:
        0 10px 22px rgba(107,114,128,.35);

}

.btn-cancel-swal:hover::before{

    left: 130%;

}



/* ICON */
.btn-delete-swal i,
.btn-cancel-swal i{

    transition: .3s ease;

}

.btn-delete-swal:hover i{

    transform: rotate(-10deg);

}

.btn-cancel-swal:hover i{

    transform: scale(1.15);

}
.btn-edit-modern i{
    transition:.3s ease;
}

.btn-edit-modern:hover i{
    transform:rotate(-10deg);
}

.btn-delete-modern i{
    transition:.3s ease;
}

.btn-delete-modern:hover i{
    transform:scale(1.12);
}
.btn-detail-modern i{
    transition:.3s ease;
}

.btn-detail-modern:hover i{
    transform:scale(1.12);
}
.btn-save i{

    position: relative;

    z-index: 2;

    transition: all .3s ease;

}

.btn-save:hover i{

    transform:
        rotate(-15deg)
        scale(1.15);

}
</style>

<div class="card border-0 shadow-sm">

    <div class="card-body">

        <!-- HEADER -->
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

            <div>

                <h4 class="mb-1 fw-bold">

                    Data Warga Terampil

                </h4>

                <p class="text-muted mb-0">

                    Informasi warga dan keterampilan Desa Karangmulya

                </p>

            </div>

            <div class="d-flex flex-wrap gap-2">

                <!-- SEARCH -->
                <form action="{{ route('admin.warga.index') }}"
    method="GET"
    class="search-wrapper">
                   <div class="input-group search-group shadow-sm">

    <button type="submit"
        class="input-group-text bg-primary text-white border-0">

        <i class="bi bi-search"></i>

    </button>

                        <input type="text"
                            name="search"
                            class="form-control"
                            placeholder="Cari nama atau NIK..."
                            value="{{ request('search') }}">

                        @if(request()->filled('search'))

                            <a href="{{ route('admin.warga.index', request()->except('search')) }}"
    class="btn btn-light border-0">

                                <i class="bi bi-x-circle"></i>

                            </a>

                        @endif

                    </div>

                </form>



                <!-- BUTTON TAMBAH -->
                <a href="{{ route('admin.warga.create') }}"
                      class="btn btn-save px-4">

    <i class="fa-solid fa-plus me-2"></i>


                    Tambah

                </a>

            </div>

        </div>



        <!-- ALERT -->
        @if(session('success'))

    <div class="custom-alert success-alert mb-4">

        <div class="d-flex align-items-center">

            <div class="alert-icon success-icon">

                <i class="fa-solid fa-circle-check"></i>

            </div>

            <div class="ms-3">

                <div class="fw-bold">

                    Berhasil

                </div>

                <small>

                    {{ session('success') }}

                </small>

            </div>

        </div>

    </div>

@endif



        <!-- TABLE -->
        <div class="table-responsive">

          <table class="table table-bordered align-middle table-striped table-hover text-nowrap">

             <thead class="table-primary text-center">

                    <tr>

                        <th width="60">
                            No
                        </th>

                        <th>
                            Nama
                        </th>

                        <th>
                            RT
                        </th>

                        <th>
                            RW
                        </th>

                        <th>
                            Dusun
                        </th>

                        <th>
                            Kategori
                        </th>

                        <th>
                            Keterampilan
                        </th>

                        <th width="180"
                            class="sticky-col">

                            Aksi

                        </th>

                    </tr>

                </thead>

               <tbody>

    @forelse($wargas as $key => $warga)

        <tr>

            <!-- NO -->
            <td class="text-center">

                {{ $wargas->firstItem() + $key }}

            </td>



            <!-- NAMA -->
            <td>

                <div class="fw-semibold text-dark">

                    {{ $warga->nama }}

                </div>

            </td>



            <!-- RT -->
            <td class="text-center">

                RT {{ $warga->rt->nomor_rt }}

            </td>



            <!-- RW -->
            <td class="text-center">

                RW {{ $warga->rt->rw->nomor_rw }}

            </td>



            <!-- DUSUN -->
            <td class="text-center">

                {{ $warga->rt->rw->dusun->nama_dusun }}

            </td>



            <!-- KATEGORI -->
<td>

    @php

        $groupSkill = [];



        foreach($warga->keterampilans as $skill){

            $kategori =
            $skill->kategori->nama_kategori
            ?? 'Lainnya';



            $groupSkill[$kategori][] =
            $skill->nama_keterampilan;

        }

    @endphp



    @forelse($groupSkill as $kategori => $skills)

        <div
            class="pb-2 mb-2"
            style="
                border-bottom:
                1px solid #dbe2ea;
            ">

            {{ $kategori }}

        </div>

    @empty

        <span class="text-muted small">

            -

        </span>

    @endforelse

</td>



<!-- KETERAMPILAN -->
<td>

    @forelse($groupSkill as $kategori => $skills)

        <div
            class="pb-2 mb-2"
            style="
                border-bottom:
                1px solid #dbe2ea;
            ">

            @foreach($skills as $item)

                <div>

                    • {{ $item }}

                </div>

            @endforeach

        </div>

    @empty

        <span class="text-muted small">

            -

        </span>

    @endforelse

</td>



            <!-- AKSI -->
            <td class="text-center sticky-col">

                <div class="d-flex justify-content-center gap-2">

                    <!-- DETAIL -->
                    <a href="{{ route('admin.warga.show', $warga->id) }}"
                        class="btn-detail-modern">
<i class="bi bi-eye-fill"></i>
                    </a>



                    <!-- EDIT -->
                    <a href="{{ route('admin.warga.edit', $warga->id) }}"
                        class="btn-edit-modern">
                        <i class="bi bi-pencil-fill"></i>
                    </a>



                    <!-- DELETE -->
                    <form action="{{ route('admin.warga.destroy', $warga->id) }}"
    method="POST"
    class="form-delete">

    @csrf
    @method('DELETE')

    <button type="button"
        class="btn-delete-modern"
        onclick="confirmDelete(this)">
<i class="bi bi-trash"></i>
    </button>

</form>

                </div>

            </td>

        </tr>

    @empty

        <tr>

            <td colspan="8"
                class="text-center text-muted py-4">

                Data warga tidak ditemukan.

            </td>

        </tr>

    @endforelse

</tbody>
            </table>

        </div>



        <!-- PAGINATION -->
        <div class="mt-3">

            {{ $wargas->links() }}

        </div>

    </div>

</div>
<!-- SWEET ALERT -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

function confirmDelete(button){

    const form = button.closest('form');

    Swal.fire({

        title: 'Hapus Data?',

        text:
        'Data warga yang dihapus tidak dapat dikembalikan.',

        icon: 'warning',

        showCancelButton: true,

        customClass: {

            confirmButton: 'btn-delete-swal',

            cancelButton: 'btn-cancel-swal'

        },

        buttonsStyling: false,

        confirmButtonText:
        '<i class="fa-solid fa-trash me-2"></i>Ya, Hapus',

        cancelButtonText:
        '<i class="fa-solid fa-xmark me-2"></i>Batal',

        reverseButtons: true

    }).then((result) => {

        if(result.isConfirmed){

            form.submit();

        }

    });

}

</script>
<!-- SWEET ALERT -->

@if(session('tambah'))

<script>

Swal.fire({

    icon: 'success',

    title: 'Berhasil Ditambahkan',

    text: "{{ session('tambah') }}",

    showConfirmButton: false,

    timer: 2200,

    background: '#ffffff',

    backdrop: `
        rgba(0,0,0,0.45)
    `

});

</script>

@endif



@if(session('edit'))

<script>

Swal.fire({

    icon: 'success',

    title: 'Berhasil Diperbarui',

    text: "{{ session('edit') }}",

    showConfirmButton: false,

    timer: 2200,

    background: '#ffffff',

    backdrop: `
        rgba(0,0,0,0.45)
    `

});

</script>

@endif



@if(session('hapus'))

<script>

Swal.fire({

    icon: 'success',

    title: 'Berhasil Dihapus',

    text: "{{ session('hapus') }}",

    showConfirmButton: false,

    timer: 2200,

    background: '#ffffff',

    backdrop: `
        rgba(0,0,0,0.45)
    `

});

</script>

@endif
@endsection