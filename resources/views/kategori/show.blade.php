<x-layout>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold">Detail Kategori</h1>
        <a href="{{ route('kategori.index') }}" class="btn btn-light">Kembali</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-sm-3">Kode Kategori</dt>
                <dd class="col-sm-9">{{ $kategori->kode_kategori }}</dd>

                <dt class="col-sm-3">Nama Kategori</dt>
                <dd class="col-sm-9">{{ $kategori->nama_kategori }}</dd>

                <dt class="col-sm-3">Daftar Buku</dt>
                <dd class="col-sm-9">
                    @forelse ($kategori->bukus as $buku)
                        <div>{{ $buku->judul }}</div>
                    @empty
                        <span class="text-muted">Belum ada buku dalam kategori ini.</span>
                    @endforelse
                </dd>
            </dl>
        </div>
    </div>
</x-layout>