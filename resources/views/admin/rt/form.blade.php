<div class="mb-3">
    <label class="form-label">RW / Dusun</label>
    <select name="rw_id" class="form-select @error('rw_id') is-invalid @enderror">
        <option value="">-- Pilih RW --</option>
        @foreach($rws as $rw)
            <option value="{{ $rw->id }}" {{ old('rw_id', $rt->rw_id ?? '') == $rw->id ? 'selected' : '' }}>
                RW {{ $rw->nomor_rw }} / Dusun {{ $rw->dusun->nama_dusun }}
            </option>
        @endforeach
    </select>
    @error('rw_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Nomor RT</label>
    <input type="text" name="nomor_rt" class="form-control @error('nomor_rt') is-invalid @enderror"
           value="{{ old('nomor_rt', $rt->nomor_rt ?? '') }}">
    @error('nomor_rt')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>