<div class="mb-3">
    <label class="form-label">Nama Dusun</label>
    <input type="text" name="nama_dusun" class="form-control @error('nama_dusun') is-invalid @enderror"
        value="{{ old('nama_dusun', $dusun->nama_dusun ?? '') }}">
    @error('nama_dusun')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
