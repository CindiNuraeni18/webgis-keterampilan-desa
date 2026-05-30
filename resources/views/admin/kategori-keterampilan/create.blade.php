@extends('layouts.sidebar-admin')

@section('title', 'Tambah Kategori Keterampilan')

@section('content')
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
        .btn-save {
            border: none;
            border-radius: 14px;
            padding: 13px;
            font-weight: 600;
            color: white;
            background: linear-gradient(135deg,
                    #2563eb,
                    #4f8cff);
            transition: all .3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(37, 99, 235, .25);
        }

        .btn-save::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, .2);
            transition: .5s;
        }

        .btn-save:hover::before {
            left: 100%;
        }

        .btn-save i {
            transition: .3s ease;
        }

        .btn-save:hover i {
            transform: rotate(-10deg) scale(1.15);
        }

        .btn-back {
            border-radius: 14px;
            padding: 13px;
            font-weight: 600;
            background: #f3f6fb;
            color: #374151;
            border: 1px solid #e5e7eb;
            transition: all .3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
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
    </style>
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h4 class="mb-4">Tambah Kategori Keterampilan</h4>

        <form action="{{ route('admin.kategori-keterampilan.store') }}" method="POST">
            @csrf
            @include('admin.kategori-keterampilan.form')


 <div class="d-flex gap-2 mt-4">

                    <!-- BUTTON SIMPAN -->
                    <button type="submit" class="btn btn-save px-4">

                        <i class="fa-solid fa-floppy-disk me-2"></i>

                        <span>
                            Simpan
                        </span>

                    </button>



                    <!-- BUTTON KEMBALI -->
                    <a href="{{ route('admin.kategori-keterampilan.index') }}" class="btn btn-back px-4">

                        <i class="fa-solid fa-arrow-left me-2"></i>

                        <span>
                            Kembali
                        </span>

                    </a>

                </div>
        </form>
    </div>
</div>
@endsection