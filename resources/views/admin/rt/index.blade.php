@extends('layouts.sidebar-admin')

@section('title', 'Data RT')

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
    position: sticky;
    right: 0;
    background: #fff;
    z-index: 2;
}

thead .sticky-col{
    background: #f8f9fa;
    z-index: 3;
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

.search-group .input-group-text{
    border:none;
    background:#0d6efd;
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



/* EFEK PUTIH */
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



/* HOVER */
.btn-save:hover{

    transform:
        translateY(-2px)
        scale(1.03);

    box-shadow:
        0 10px 24px rgba(37,99,235,.35);

    color: white !important;

}



/* GERAK PUTIH */
.btn-save:hover::before{

    left: 130%;

}



/* ICON */
.btn-save i{

    transition: .3s ease;

}



/* ICON HOVER */
.btn-save:hover i{

    transform: rotate(-10deg);

}



/* SAAT DIKLIK */
.btn-save:active{

    transform: scale(0.97);

    color: white !important;

}



/* FOCUS & VISITED */
.btn-save:focus,
.btn-save:visited{

    color: white !important;

    outline: none;

    box-shadow:
        0 10px 24px rgba(37,99,235,.35) !important;

}



/* SPAN TEXT */
.btn-save span{

    color: white !important;

    position: relative;

    z-index: 2;

}



/* ICON Z-INDEX */
.btn-save i{

    position: relative;

    z-index: 2;

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
}

.btn-edit-modern:hover{
    transform:translateY(-2px) scale(1.05);
    color:white;
}

.btn-edit-modern:hover i{
    transform:rotate(-10deg);
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
}

.btn-delete-modern:hover{
    transform:translateY(-2px) scale(1.05);
    color:white;
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



/* EFEK PUTIH BERGERAK */
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



/* HOVER */
.btn-delete-swal:hover{

    transform:
        translateY(-2px)
        scale(1.04);

    box-shadow:
        0 10px 22px rgba(239,68,68,.4);

}



/* GERAK PUTIH */
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



/* EFEK PUTIH */
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



/* HOVER */
.btn-cancel-swal:hover{

    transform:
        translateY(-2px)
        scale(1.04);

    box-shadow:
        0 10px 22px rgba(107,114,128,.35);

}



/* GERAK PUTIH */
.btn-cancel-swal:hover::before{

    left: 130%;

}
/* ICON ANIMATION */
.btn-delete-swal i,
.btn-cancel-swal i{

    transition: .3s ease;

}



/* ICON HOVER */
.btn-delete-swal:hover i{

    transform: rotate(-10deg);

}

.btn-cancel-swal:hover i{

    transform: scale(1.15);

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

</style>



<div class="card border-0 shadow-sm">

    <div class="card-body">

        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

            <div>

                <h4 class="mb-1">
                    Data RT
                </h4>

                <p class="text-muted mb-0">
                    Kelola data RT berdasarkan RW dan dusun
                </p>

            </div>



            <div class="d-flex flex-wrap gap-2">

                <!-- SEARCH -->
                <form action="{{ route('admin.rt.index') }}"
                    method="GET"
                    class="search-wrapper">

                    <div class="input-group search-group shadow-sm">

                        <button type="submit"
                            class="input-group-text bg-primary text-white border-0">

                            <i class="bi bi-search"></i>

                        </button>

                        <input type="text"
    name="search"
    class="form-control border-0"
    placeholder="Cari RT / RW / dusun..."
    value="{{ request('search') }}">


@if(request()->filled('search'))

<a href="{{ route('admin.rt.index', request()->except('search')) }}"
    class="btn btn-light border-0">

    <i class="bi bi-x-circle"></i>

</a>

@endif

                    </div>

                </form>



                <!-- TAMBAH -->
                <a href="{{ route('admin.rt.create') }}"
                    class="btn btn-save px-4">

                    <i class="fa-solid fa-plus me-2"></i>

                    <span>
                        Tambah
                    </span>

                </a>

            </div>

        </div>



        <!-- SWEET ALERT -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



        {{-- ALERT TAMBAH --}}
        @if(session('tambah'))

        <script>

            Swal.fire({

                icon: 'success',

                title: 'Berhasil Ditambahkan',

                text: "{{ session('tambah') }}",

                showConfirmButton: false,

                timer: 2200

            });

        </script>

        @endif



        {{-- ALERT EDIT --}}
        @if(session('edit'))

        <script>

            Swal.fire({

                icon: 'success',

                title: 'Berhasil Diperbarui',

                text: "{{ session('edit') }}",

                showConfirmButton: false,

                timer: 2200

            });

        </script>

        @endif



        {{-- ALERT HAPUS --}}
        @if(session('hapus'))

        <script>

            Swal.fire({

                icon: 'success',

                title: 'Berhasil Dihapus',

                text: "{{ session('hapus') }}",

                showConfirmButton: false,

                timer: 2200

            });

        </script>

        @endif



        <div class="table-responsive">

            <table class="table table-bordered align-middle table-striped table-hover text-nowrap">

                <thead class="table-primary text-center">

                    <tr>

                        <th>No</th>
                        <th>RT</th>
                        <th>RW</th>
                        <th>Dusun</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th width="180" class="sticky-col">Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($rts as $key => $rt)

                    <tr>

                        <td class="text-center">{{ $rts->firstItem() + $key }}</td>

                        <td>{{ $rt->nomor_rt }}</td>

                        <td>{{ $rt->rw->nomor_rw }}</td>

                        <td>{{ $rt->rw->dusun->nama_dusun }}</td>

                        <td>{{ $rt->latitude ?? '-' }}</td>

                        <td>{{ $rt->longitude ?? '-' }}</td>

                        <td class="text-center sticky-col">

                            <div class="d-flex justify-content-center gap-2">

                                <!-- EDIT -->
                                <a href="{{ route('admin.rt.edit', $rt->id) }}"
                                    class="btn-edit-modern">

                                    <i class="bi bi-pencil-fill"></i>

                                </a>



                                <!-- DELETE -->
                                <form action="{{ route('admin.rt.destroy', $rt->id) }}"
                                    method="POST">

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

                        <td colspan="7"
                            class="text-center text-muted">

                            Data RT belum ada.

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="mt-3">

            {{ $rts->links() }}

        </div>

    </div>

</div>



<script>

function confirmDelete(button){

    const form = button.closest('form');

    Swal.fire({

        title: 'Hapus Data?',

        text:
        'Data RT yang dihapus tidak dapat dikembalikan.',

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

@endsection