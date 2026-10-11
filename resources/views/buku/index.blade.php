<x-layout>
    <style>
        .buku-table {
            table-layout: fixed;
            min-width: 980px;
        }

        .buku-table th,
        .buku-table td {
            vertical-align: middle;
        }

        .buku-table .col-isbn {
            width: 13%;
        }

        .buku-table .col-judul {
            width: 38%;
        }

        .buku-table .col-penulis {
            width: 15%;
        }

        .buku-table .col-kategori {
            width: 10%;
        }

        .buku-table .col-tahun {
            width: 6%;
        }

        .buku-table .col-stok {
            width: 5%;
        }

        .buku-table .col-aksi {
            width: 13%;
        }

        .buku-table .isbn,
        .buku-table .aksi {
            white-space: nowrap;
        }

        .buku-table .aksi .dropdown {
            display: inline-block;
        }

        .buku-table .judul,
        .buku-table .penulis,
        .buku-table .kategori {
            overflow-wrap: anywhere;
        }
    </style>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold">Daftar Buku</h1>

        <div>
            @auth
                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('kategori.index') }}" class="btn btn-outline-secondary">
                        Kelola Kategori
                    </a>
                    <a href="{{ route('buku.create') }}" class="btn btn-del">
                        + Tambah Buku
                    </a>
                @endif
            @endauth
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0 buku-table">
                <thead class="table-light">
                    <tr>
                        <th class="col-isbn">ISBN</th>
                        <th class="col-judul">Judul</th>
                        <th class="col-penulis">Penulis</th>
                        <th class="col-kategori">Kategori</th>
                        <th class="col-tahun">Tahun</th>
                        <th class="col-stok">Stok</th>
                        <th class="col-aksi">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($bukus as $buku)
                        <tr>
                            <td class="isbn">{{ $buku->isbn }}</td>
                            <td class="judul">{{ $buku->judul }}</td>
                            <td class="penulis">{{ $buku->penulis }}</td>
                            <td class="kategori">{{ $buku->kategori->nama_kategori }}</td>
                            <td>{{ $buku->tahun_terbit }}</td>
                            <td>{{ $buku->stok }}</td>
                            <td class="aksi">
                                <div class="dropdown">
                                    <button type="button"
                                        class="action-menu-button"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false"
                                        aria-label="Aksi buku {{ $buku->judul }}">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </button>

                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('buku.show', $buku) }}">
                                                Detail
                                            </a>
                                        </li>

                                        @auth
                                            @if (auth()->user()->role === 'admin')
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('buku.edit', $buku) }}">
                                                        Edit
                                                    </a>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <button type="button"
                                                        class="dropdown-item text-danger"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal"
                                                        data-delete-action="{{ route('buku.destroy', $buku) }}"
                                                        data-delete-name="{{ $buku->judul }}">
                                                        Hapus
                                                    </button>
                                                </li>
                                            @endif
                                        @endauth
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                Belum ada data buku.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $bukus->links() }}
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1"
        aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Penghapusan</h5>
                    <button type="button" class="btn-close"
                        data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus buku
                    <strong id="deleteItemName"></strong>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">
                        Batal
                    </button>
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('deleteModal').addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const form = document.getElementById('deleteForm');
            const itemName = document.getElementById('deleteItemName');

            form.action = button.getAttribute('data-delete-action');
            itemName.textContent = button.getAttribute('data-delete-name');
        });
    </script>
</x-layout>