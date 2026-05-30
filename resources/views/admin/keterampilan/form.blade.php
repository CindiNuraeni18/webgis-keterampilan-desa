<div class="mb-3">
    <label class="form-label">Warga</label>
    <select name="warga_id" class="form-select @error('warga_id') is-invalid @enderror">
        <option value="">-- Pilih Warga --</option>
        @foreach($wargas as $warga)
            <option value="{{ $warga->id }}" {{ old('warga_id', $keterampilan->warga_id ?? '') == $warga->id ? 'selected' : '' }}>
                {{ $warga->nama }} - RT {{ $warga->rt->nomor_rt }} / RW {{ $warga->rt->rw->nomor_rw }} / Dusun {{ $warga->rt->rw->dusun->nama_dusun }}
            </option>
        @endforeach
    </select>
    @error('warga_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Kategori Keterampilan</label>
    <select name="kategori_keterampilan_id" class="form-select @error('kategori_keterampilan_id') is-invalid @enderror">
        <option value="">-- Pilih Kategori --</option>
        @foreach($kategoris as $kategori)
            <option value="{{ $kategori->id }}" {{ old('kategori_keterampilan_id', $keterampilan->kategori_keterampilan_id ?? '') == $kategori->id ? 'selected' : '' }}>
                {{ $kategori->nama_kategori }}
            </option>
        @endforeach
    </select>
    @error('kategori_keterampilan_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Nama Keterampilan</label>
    <input type="text" name="nama_keterampilan" class="form-control @error('nama_keterampilan') is-invalid @enderror"
           value="{{ old('nama_keterampilan', $keterampilan->nama_keterampilan ?? '') }}">
    @error('nama_keterampilan')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label">Pengalaman</label>
    <input type="text" name="pengalaman" class="form-control @error('pengalaman') is-invalid @enderror"
           value="{{ old('pengalaman', $keterampilan->pengalaman ?? '') }}" placeholder="Contoh: 3 tahun">
    @error('pengalaman')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
