<div class="mb-3">
    <label class="form-label">Dusun</label>
    <select name="dusun_id" class="form-select @error('dusun_id') is-invalid @enderror">
        <option value="">-- Pilih Dusun --</option>
        @foreach($dusuns as $dusun)
            <option value="{{ $dusun->id }}" {{ old('dusun_id', $rw->dusun_id ?? '') == $dusun->id ? 'selected' : '' }}>
                {{ $dusun->nama_dusun }}
            </option>
        @endforeach
    </select>
    @error('dusun_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Nomor RW</label>
    <input type="text" name="nomor_rw" class="form-control @error('nomor_rw') is-invalid @enderror"
           value="{{ old('nomor_rw', $rw->nomor_rw ?? '') }}">
    @error('nomor_rw')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>