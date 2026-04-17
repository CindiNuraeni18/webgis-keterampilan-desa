<div class="mb-3">
    <label class="form-label">Nama Dusun</label>
    <input type="text" name="nama_dusun" class="form-control @error('nama_dusun') is-invalid @enderror"
           value="{{ old('nama_dusun', $dusun->nama_dusun ?? '') }}">
    @error('nama_dusun')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Latitude</label>
    <input type="text" name="latitude"
        class="form-control @error('latitude') is-invalid @enderror"
        value="{{ old('latitude', $dusun->latitude ?? '') }}"
        placeholder="-6.41085">
    @error('latitude')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Longitude</label>
    <input type="text" name="longitude"
        class="form-control @error('longitude') is-invalid @enderror"
        value="{{ old('longitude', $dusun->longitude ?? '') }}"
        placeholder="108.10235">
    @error('longitude')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>