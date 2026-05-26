<div class="row align-items-start g-4">

    <!-- FORM INPUT -->
    <div class="col-lg-4">

        <div class="card border-0 shadow-sm rounded-4 h-100 form-card">

            <div class="card-body p-4">

                <!-- RW -->
                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        RW / Dusun
                    </label>

                    <select name="rw_id" class="form-select custom-input @error('rw_id') is-invalid @enderror">

                        <option value="">
                            -- Pilih RW --
                        </option>

                        @foreach ($rws as $rw)
                            <option value="{{ $rw->id }}"
                                {{ old('rw_id', $rt->rw_id ?? '') == $rw->id ? 'selected' : '' }}>

                                RW {{ $rw->nomor_rw }}
                                / Dusun {{ $rw->dusun->nama_dusun }}

                            </option>
                        @endforeach

                    </select>

                    @error('rw_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>



                <!-- NOMOR RT -->
                <div class="mb-4">

                    <label class="form-label fw-semibold">
                        Nomor RT
                    </label>

                    <input type="text" name="nomor_rt"
                        class="form-control custom-input @error('nomor_rt') is-invalid @enderror"
                        placeholder="Contoh: 01" value="{{ old('nomor_rt', $rt->nomor_rt ?? '') }}">

                    @error('nomor_rt')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>



                <!-- KOORDINAT -->
                <div class="coordinate-box">

                    <div class="d-flex align-items-center mb-3">

                        <div>

                            <h6 class="fw-bold mb-0">
                                Titik Koordinat
                            </h6>

                            <small class="text-muted">
                                Otomatis terisi saat klik peta
                            </small>

                        </div>

                    </div>



                    <div class="mb-3">

                        <label class="form-label">
                            Latitude
                        </label>

                        <input type="text" id="latitude" name="latitude" class="form-control custom-input"
                            value="{{ old('latitude', $rt->latitude ?? '') }}" readonly>

                    </div>



                    <div>

                        <label class="form-label">
                            Longitude
                        </label>

                        <input type="text" id="longitude" name="longitude" class="form-control custom-input"
                            value="{{ old('longitude', $rt->longitude ?? '') }}" readonly>

                    </div>

                </div>

            </div>

        </div>

    </div>



    <!-- PETA -->
    <div class="col-lg-8">

        <div class="card border-0 shadow-sm rounded-4 map-card">

            <div class="card-body p-3">

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <div>

                        <h5 class="fw-bold mb-1">
                            Pilih Titik Lokasi RT
                        </h5>

                        <small class="text-muted">
                            Klik area peta untuk menentukan lokasi RT
                        </small>

                    </div>

                </div>



                <div id="map"
                    style="
                        height: 390px;
                        border-radius: 18px;
                        overflow: hidden;
                    ">
                </div>

            </div>

        </div>

    </div>

</div>



<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">



<style>
    .form-card {
        transition: 0.3s ease;
    }

    .form-card:hover {
        transform: translateY(-3px);
    }

    .map-card {
        transition: 0.3s ease;
    }

    .map-card:hover {
        transform: translateY(-3px);
    }

    .custom-input {
        border-radius: 12px;
        padding: 12px 14px;
        border: 1px solid #dbe2ef;
        transition: all .3s ease;
    }

    .custom-input:focus {
        border-color: #4f8cff;
        box-shadow: 0 0 0 0.15rem rgba(79, 140, 255, .15);
    }

    .coordinate-box {
        background: #f8fbff;
        border-radius: 18px;
        padding: 18px;
        border: 1px solid #edf2ff;
    }

    .coordinate-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: linear-gradient(135deg,
                #4f8cff,
                #2563eb);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        margin-right: 12px;
        font-size: 18px;
    }

    @media(max-width: 991px) {

        #map {
            height: 320px !important;
        }

    }
</style>
