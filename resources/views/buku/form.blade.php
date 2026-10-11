<div class="mb-3">
    <label for="isbn" class="form-label">ISBN</label>
    <input type="text"
        name="isbn"
        id="isbn"
        value="{{ old('isbn', $buku->isbn ?? '') }}"
        class="form-control @error('isbn') is-invalid @enderror"
        maxlength="20"
        required>
    @error('isbn')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="judul" class="form-label">Judul</label>
    <input type="text"
        name="judul"
        id="judul"
        value="{{ old('judul', $buku->judul ?? '') }}"
        class="form-control @error('judul') is-invalid @enderror"
        minlength="5"
        maxlength="200"
        required>
    @error('judul')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="penulis" class="form-label">Penulis</label>
    <input type="text"
        name="penulis"
        id="penulis"
        value="{{ old('penulis', $buku->penulis ?? '') }}"
        class="form-control @error('penulis') is-invalid @enderror"
        maxlength="150"
        required>
    @error('penulis')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="penerbit" class="form-label">Penerbit</label>
    <input type="text"
        name="penerbit"
        id="penerbit"
        value="{{ old('penerbit', $buku->penerbit ?? '') }}"
        class="form-control @error('penerbit') is-invalid @enderror"
        maxlength="150"
        required>
    @error('penerbit')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
    <input type="number"
        name="tahun_terbit"
        id="tahun_terbit"
        value="{{ old('tahun_terbit', $buku->tahun_terbit ?? '') }}"
        class="form-control @error('tahun_terbit') is-invalid @enderror"
        min="1000"
        max="2100"
        required>
    @error('tahun_terbit')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="kategori_id" class="form-label">Kategori</label>
    <select name="kategori_id"
        id="kategori_id"
        class="form-select @error('kategori_id') is-invalid @enderror"
        required>
        <option value="">-- Pilih Kategori --</option>
        @foreach ($kategoris as $kategori)
            <option value="{{ $kategori->id }}"
                @selected(old('kategori_id', $buku->kategori_id ?? '') == $kategori->id)>
                {{ $kategori->nama_kategori }}
            </option>
        @endforeach
    </select>
    @error('kategori_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="stok" class="form-label">Stok</label>
    <input type="number"
        name="stok"
        id="stok"
        value="{{ old('stok', $buku->stok ?? 0) }}"
        class="form-control @error('stok') is-invalid @enderror"
        min="0"
        required>
    @error('stok')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="sinopsis" class="form-label">Sinopsis</label>
    <textarea name="sinopsis"
        id="sinopsis"
        rows="5"
        class="form-control @error('sinopsis') is-invalid @enderror">{{ old('sinopsis', $buku->sinopsis ?? '') }}</textarea>
    @error('sinopsis')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
