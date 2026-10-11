<x-layout>
    <h1 class="h3 fw-bold mb-4">Tambah Kategori</h1>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('kategori.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="kode_kategori" class="form-label">
                        Kode Kategori
                    </label>

                    <input type="text"
                        name="kode_kategori"
                        id="kode_kategori"
                        value="{{ old('kode_kategori') }}"
                        class="form-control @error('kode_kategori') is-invalid @enderror"
                        required>

                    @error('kode_kategori')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="nama_kategori" class="form-label">
                        Nama Kategori
                    </label>

                    <input type="text"
                        name="nama_kategori"
                        id="nama_kategori"
                        value="{{ old('nama_kategori') }}"
                        class="form-control @error('nama_kategori') is-invalid @enderror"
                        required>

                    @error('nama_kategori')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-del">
                    Simpan
                </button>

                <a href="{{ route('kategori.index') }}" class="btn btn-light">
                    Batal
                </a>
            </form>
        </div>
    </div>
</x-layout>