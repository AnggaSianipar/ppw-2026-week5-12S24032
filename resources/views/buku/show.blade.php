<x-layout>
    <div class="d-flex justify-content-between mb-4">
        <h1 class="h3 fw-bold">Detail Buku</h1>

        <a href="{{ route('buku.index') }}" class="btn btn-light">
            Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">ISBN</dt>
                <dd class="col-sm-9">{{ $buku->isbn }}</dd>

                <dt class="col-sm-3">Judul</dt>
                <dd class="col-sm-9">{{ $buku->judul }}</dd>

                <dt class="col-sm-3">Penulis</dt>
                <dd class="col-sm-9">{{ $buku->penulis }}</dd>

                <dt class="col-sm-3">Penerbit</dt>
                <dd class="col-sm-9">{{ $buku->penerbit }}</dd>

                <dt class="col-sm-3">Tahun Terbit</dt>
                <dd class="col-sm-9">{{ $buku->tahun_terbit }}</dd>

                <dt class="col-sm-3">Kategori</dt>
                <dd class="col-sm-9">{{ $buku->kategori->nama_kategori }}</dd>

                <dt class="col-sm-3">Stok</dt>
                <dd class="col-sm-9">{{ $buku->stok }}</dd>

                <dt class="col-sm-3">Sinopsis</dt>
                <dd class="col-sm-9">{{ $buku->sinopsis ?: '-' }}</dd>
            </dl>
        </div>
    </div>
</x-layout>