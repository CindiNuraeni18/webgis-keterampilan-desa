<div class="row">
    <div class="col-md-6 mb-3">
        <label for="nik" class="form-label">NIK</label>
        <input type="text" name="nik" id="nik" class="form-control @error('nik') is-invalid @enderror"
               value="{{ old('nik', $warga->nik ?? '') }}">
        @error('nik')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="nama" class="form-label">Nama Lengkap</label>
        <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror"
               value="{{ old('nama', $warga->nama ?? '') }}">
        @error('nama')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
        <select name="jenis_kelamin" id="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror">
            <option value="">-- Pilih Jenis Kelamin --</option>
            <option value="Laki-laki" {{ old('jenis_kelamin', $warga->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
            <option value="Perempuan" {{ old('jenis_kelamin', $warga->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
        </select>
        @error('jenis_kelamin')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
        <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror"
               value="{{ old('tempat_lahir', $warga->tempat_lahir ?? '') }}">
        @error('tempat_lahir')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
        <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror"
               value="{{ old('tanggal_lahir', $warga->tanggal_lahir ?? '') }}">
        @error('tanggal_lahir')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="rt_id" class="form-label">Wilayah RT / RW / Dusun</label>
        <select name="rt_id" id="rt_id" class="form-select @error('rt_id') is-invalid @enderror">
            <option value="">-- Pilih Wilayah --</option>
            @foreach($rts as $rt)
                <option value="{{ $rt->id }}" {{ old('rt_id', $warga->rt_id ?? '') == $rt->id ? 'selected' : '' }}>
                    RT {{ $rt->nomor_rt }} / RW {{ $rt->rw->nomor_rw }} / Dusun {{ $rt->rw->dusun->nama_dusun }}
                </option>
            @endforeach
        </select>
        @error('rt_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12 mb-3">
        <label for="alamat" class="form-label">Alamat</label>
        <textarea name="alamat" id="alamat" rows="3" class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat', $warga->alamat ?? '') }}</textarea>
        @error('alamat')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="no_hp" class="form-label">No HP</label>
        <input type="text" name="no_hp" id="no_hp" class="form-control @error('no_hp') is-invalid @enderror"
               value="{{ old('no_hp', $warga->no_hp ?? '') }}">
        @error('no_hp')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="pekerjaan" class="form-label">Pekerjaan</label>
        <input type="text" name="pekerjaan" id="pekerjaan" class="form-control @error('pekerjaan') is-invalid @enderror"
               value="{{ old('pekerjaan', $warga->pekerjaan ?? '') }}">
        @error('pekerjaan')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>