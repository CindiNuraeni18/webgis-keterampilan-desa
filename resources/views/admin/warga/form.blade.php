<style>
    /* =========================
       SECTION
    ========================= */

    .form-section {

        background: white;

        border-radius: 24px;

        padding: 28px;

        margin-bottom: 28px;

        box-shadow:
            0 8px 24px rgba(15, 23, 42, .05);

        transition: .3s ease;

        border: 1px solid #eef2ff;

    }

    .form-section:hover {

        transform: translateY(-2px);

        box-shadow:
            0 14px 34px rgba(15, 23, 42, .08);

    }



    /* =========================
       TITLE
    ========================= */

    .section-title {

        font-size: 20px;

        font-weight: 700;

        color: #0f172a;

        margin-bottom: 6px;

    }

    .section-subtitle {

        color: #64748b;

        font-size: 13px;

        margin-bottom: 24px;

    }



    /* =========================
       INPUT
    ========================= */

    .form-control,
    .form-select {

        border-radius: 16px;

        padding: 13px 15px;

        border: 1px solid #dbeafe;

        background: #f8fbff;

        transition: .25s ease;

    }

    .form-control:focus,
    .form-select:focus {

        border-color: #3b82f6;

        background: white;

        box-shadow:
            0 0 0 4px rgba(59, 130, 246, .14);

    }



    /* =========================
       LABEL
    ========================= */

    .form-label {

        font-weight: 600;

        color: #334155;

        margin-bottom: 8px;

    }



    /* =========================
       BUTTON SAVE
    ========================= */

    .btn-save {

        border: none;

        border-radius: 16px;

        padding: 14px 22px;

        font-weight: 600;

        color: white;

        background: linear-gradient(135deg,
                #2563eb,
                #4f8cff);

        transition: .3s ease;

        position: relative;

        overflow: hidden;
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

    .btn-save:hover {

        transform: translateY(-2px);

        box-shadow:
            0 12px 24px rgba(37, 99, 235, .25);

    }



    /* =========================
       BUTTON BACK
    ========================= */

    .btn-back {

        border-radius: 16px;

        padding: 14px 22px;

        background: #f1f5f9;

        color: #334155;

        font-weight: 600;

        border: none;

        transition: .25s ease;

    }

    .btn-back:hover {

        background: #dbeafe;

        color: #2563eb;

        transform: translateY(-2px);

    }



    /* =========================
       SKILL ITEM
    ========================= */

    .skill-item {

        background: #ffffff;

        border: 1px solid #e2e8f0;

        border-radius: 22px;

        padding: 24px;

        margin-bottom: 18px;

        transition: .3s ease;

        position: relative;

        overflow: hidden;

    }

    .skill-item:hover {

        transform: translateY(-3px);

        box-shadow:
            0 12px 28px rgba(15, 23, 42, .08);

    }



    /* =========================
       BUTTON ADD SKILL
    ========================= */

    .btn-save {

        position: relative;

        overflow: hidden;

        border: none;

        border-radius: 14px;

        background: linear-gradient(135deg,
                #2563eb,
                #3b82f6);

        color: white !important;

        font-weight: 600;

        transition: all .35s ease;

        box-shadow:
            0 6px 18px rgba(37, 99, 235, .25);

    }



    /* EFEK PUTIH */
    .btn-save::before {

        content: '';

        position: absolute;

        top: 0;

        left: -75%;

        width: 50%;

        height: 100%;

        background: rgba(255, 255, 255, .22);

        transform: skewX(-25deg);

        transition: .7s;

    }



    /* HOVER */
    .btn-save:hover {

        transform:
            translateY(-2px) scale(1.03);

        box-shadow:
            0 10px 24px rgba(37, 99, 235, .35);

        color: white !important;

    }



    /* GERAK PUTIH */
    .btn-save:hover::before {

        left: 130%;

    }



    /* ICON */
    .btn-save i {

        transition: .3s ease;

    }



    /* ICON HOVER */
    .btn-save:hover i {

        transform: rotate(-10deg);

    }



    /* SAAT DIKLIK */
    .btn-save:active {

        transform: scale(0.97);

        color: white !important;

    }



    /* FOCUS & VISITED */
    .btn-save:focus,
    .btn-save:visited {

        color: white !important;

        outline: none;

        box-shadow:
            0 10px 24px rgba(37, 99, 235, .35) !important;

    }



    /* SPAN TEXT */
    .btn-save span {

        color: white !important;

        position: relative;

        z-index: 2;

    }



    /* ICON Z-INDEX */
    .btn-save i {

        position: relative;

        z-index: 2;

    }

    /* =========================
       BUTTON REMOVE
    ========================= */

    .btn-remove-skill {

        width: 44px;

        height: 44px;

        border: none;

        border-radius: 14px;

        background: #fee2e2;

        color: #dc2626;

        transition: .25s ease;

    }

    .btn-remove-skill:hover {

        background: #dc2626;

        color: white;

        transform: scale(1.08);

    }



    /* =========================
       ANIMATION
    ========================= */

    .skill-item {

        animation: fadeIn .35s ease;

    }

    @keyframes fadeIn {

        from {

            opacity: 0;

            transform:
                translateY(15px);

        }

        to {

            opacity: 1;

            transform:
                translateY(0);

        }

    }



    /* =========================
       MOBILE
    ========================= */

    @media(max-width:768px) {

        .form-section {

            padding: 20px;

        }

        .btn-add-skill {

            width: 100%;

        }

    }
</style>



<!-- =========================
     DATA WARGA
========================= -->

<div class="form-section">

    <div class="section-title">

        <i class="bi bi-person-vcard text-primary me-2"></i>

        Data Warga

    </div>

    <div class="section-subtitle">

        Lengkapi informasi identitas warga

    </div>



    <div class="row">

        <div class="col-lg-6 mb-3">

            <label class="form-label">

                NIK

            </label>

            <input type="text" name="nik" class="form-control @error('nik') is-invalid @enderror"
                value="{{ old('nik', $warga->nik ?? '') }}">

            @error('nik')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror

        </div>



        <div class="col-lg-6 mb-3">

            <label class="form-label">

                Nama Lengkap

            </label>

            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                value="{{ old('nama', $warga->nama ?? '') }}">

            @error('nama')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror

        </div>



        <div class="col-lg-6 mb-3">

            <label class="form-label">

                Jenis Kelamin

            </label>

            <select name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror">

                <option value="">
                    -- Pilih --
                </option>

                <option value="Laki-laki"
                    {{ old('jenis_kelamin', $warga->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>

                    Laki-laki

                </option>

                <option value="Perempuan"
                    {{ old('jenis_kelamin', $warga->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>

                    Perempuan

                </option>

            </select>

        </div>



        <div class="col-lg-6 mb-3">

            <label class="form-label">

                Tempat Lahir

            </label>

            <input type="text" name="tempat_lahir" class="form-control"
                value="{{ old('tempat_lahir', $warga->tempat_lahir ?? '') }}">

        </div>



        <div class="col-lg-6 mb-3">

            <label class="form-label">

                Tanggal Lahir

            </label>

            <input type="date" name="tanggal_lahir" class="form-control"
                value="{{ old('tanggal_lahir', $warga->tanggal_lahir ?? '') }}">

        </div>



        <div class="col-lg-6 mb-3">

            <label class="form-label">

                Wilayah RT/RW/Dusun

            </label>

            <select name="rt_id" class="form-select">

                <option value="">
                    -- Pilih Wilayah --
                </option>

                @foreach ($rts as $rt)
                    <option value="{{ $rt->id }}"
                        {{ old('rt_id', $warga->rt_id ?? '') == $rt->id ? 'selected' : '' }}>

                        RT {{ $rt->nomor_rt }}
                        / RW {{ $rt->rw->nomor_rw }}
                        / {{ $rt->rw->dusun->nama_dusun }}

                    </option>
                @endforeach

            </select>

        </div>



        <div class="col-lg-6 mb-2">

            <label class="form-label">

                No HP

            </label>

            <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp', $warga->no_hp ?? '') }}">

        </div>

    </div>

</div>



<!-- =========================
     KETERAMPILAN
========================= -->

<div class="form-section">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

        <div>

            <div class="section-title">

                <i class="bi bi-stars text-primary me-2"></i>

                Informasi Keterampilan

            </div>

            <div class="section-subtitle">

                Tambahkan satu atau lebih keterampilan warga

            </div>

        </div>

        <button type="button" class="btn btn-save px-4" id="btnTambahSkill">

            <i class="fa-solid fa-plus me-2"></i>

            Tambah Skill

        </button>

    </div>



    <div id="skillWrapper">

        @php
            $oldSkills = old(
                'nama_keterampilan',
                isset($warga) ? $warga->keterampilans->pluck('nama_keterampilan')->toArray() : [''],
            );
        @endphp

        @foreach ($oldSkills as $i => $oldSkill)
            <div class="skill-item">

    <div class="row g-3 align-items-start">

   <!-- KIRI -->
<div class="col-lg-5">

    <!-- KATEGORI -->
    <div class="mb-3">

        <label class="form-label">

            Kategori

        </label>

        <select
    name="kategori_keterampilan_id[]"
    class="form-select kategori-select">

    <option value="">
        -- Pilih --
    </option>

    @foreach($kategoris as $kategori)

        <option
            value="{{ $kategori->id }}"

            {{
                old(
                    'kategori_keterampilan_id.'.$i,
                    isset($warga->keterampilans[$i])
                        ? $warga->keterampilans[$i]
                            ->kategori_keterampilan_id
                        : ''
                ) == $kategori->id
                    ? 'selected'
                    : ''
            }}>

            {{ $kategori->nama_kategori }}

        </option>

    @endforeach

    <option value="lainnya">

       Lainnya

    </option>

</select>
<div class="kategori-baru-wrapper d-none mt-2">

    <input
        type="text"
        name="kategori_baru[]"
        class="form-control"
        placeholder="Masukkan kategori baru">

</div>
    </div>



    <!-- KETERAMPILAN -->
    <div>

        <label class="form-label">

            Keterampilan

        </label>

        <input type="text"
            name="nama_keterampilan[]"
            class="form-control"
            placeholder="Contoh: Menjahit"

            value="{{
                old(
                    'nama_keterampilan.'.$i,
                    isset($warga->keterampilans[$i])
                        ? $warga->keterampilans[$i]
                            ->nama_keterampilan
                        : ''
                )
            }}">
    </div>

</div>



<!-- PENGALAMAN -->
<div class="col-lg-6">

    <label class="form-label">

        Pengalaman

    </label>

    <textarea
        name="pengalaman[]"
        rows="5"
        class="form-control"
        placeholder="Contoh: Pengalaman 2 tahun, usaha sendiri, pernah bekerja, dll">{{

        old(
            'pengalaman.'.$i,
            isset($warga->keterampilans[$i])
                ? $warga->keterampilans[$i]
                    ->pengalaman
                : ''
        )

    }}</textarea>

</div>



<!-- HAPUS -->
<div class="col-lg-1">

    <label class="form-label opacity-0">

        Hapus

    </label>

    <button type="button"
        class="btn-remove-skill btnHapusSkill w-100">

        <i class="bi bi-trash"></i>

    </button>

</div>

</div>
        @endforeach

    </div>

</div>

<script>

document.addEventListener(
'change',
function(e){

    if(
        e.target.classList.contains(
            'kategori-select'
        )
    ){

        let wrapper =
        e.target.parentElement
        .querySelector(
            '.kategori-baru-wrapper'
        );

        if(
            e.target.value ==
            'lainnya'
        ){

            wrapper.classList.remove(
                'd-none'
            );

        }else{

            wrapper.classList.add(
                'd-none'
            );

        }

    }

});

</script>
<!-- SCRIPT -->
<script>
    document
        .getElementById('btnTambahSkill')
        .addEventListener('click', function() {

            let wrapper =
                document.getElementById('skillWrapper');

            let item =
                document.querySelector('.skill-item');

            let clone =
                item.cloneNode(true);

            clone.querySelectorAll('input')
                .forEach(el => el.value = '');

            clone.querySelectorAll('select')
                .forEach(el => el.selectedIndex = 0);

            wrapper.appendChild(clone);

        });



    document.addEventListener('click', function(e) {

        if (e.target.closest('.btnHapusSkill')) {

            let items =
                document.querySelectorAll('.skill-item');

            if (items.length > 1) {

                e.target
                    .closest('.skill-item')
                    .remove();

            }

        }

    });
</script>
