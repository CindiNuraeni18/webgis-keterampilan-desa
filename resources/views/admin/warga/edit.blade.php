@extends('layouts.sidebar-admin')

@section('title', 'Edit Data Warga')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
        .btn-update {
            border: none;
            border-radius: 14px;
            padding: 12px 22px;
            font-weight: 600;
            color: white;
            background: linear-gradient(135deg,
                    #f59e0b,
                    #fbbf24);
            transition: all .3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-update:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(245, 158, 11, .25);
        }

        .btn-update::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, .2);
            transition: .5s;
        }

        .btn-update:hover::before {
            left: 100%;
        }

        .btn-update i {
            transition: .3s ease;
        }

        .btn-update:hover i {
            transform: rotate(-10deg) scale(1.15);
        }

        .btn-back {
            border-radius: 14px;
            padding: 12px 22px;
            font-weight: 600;
            background: #f3f6fb;
            color: #374151;
            border: 1px solid #e5e7eb;
            transition: all .3s ease;
            display: inline-flex;
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
        <form action="{{ route('admin.warga.update', $warga->id) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.warga.form')
 <div class="d-flex gap-2 mt-4">

                    <button type="submit" class="btn btn-update px-4">

                        <i class="fa-solid fa-pen-to-square me-2"></i>

                        <span>
                            Update
                        </span>

                    </button>



                    <a href="{{ route('admin.warga.index') }}" class="btn btn-back px-4">

                        <i class="fa-solid fa-arrow-left me-2"></i>

                        <span>
                            Kembali
                        </span>

                    </a>

                </div>
           
        </form>
</div>
@endsection