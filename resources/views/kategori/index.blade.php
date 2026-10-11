<x-layout>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold">Daftar Kategori</h1>

        @auth
            @if (auth()->user()->role === 'admin')
                <a href="{{ route('kategori.create') }}" class="btn btn-del">
                    + Tambah Kategori
                </a>
            @endif
        @endauth
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
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Kode</th>
                    <th>Nama Kategori</th>
                    <th>Jumlah Buku</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($kategoris as $kategori)
                    <tr>
                        <td>{{ $kategori->kode_kategori }}</td>
                        <td>{{ $kategori->nama_kategori }}</td>
                        <td>{{ $kategori->bukus_count }}</td>
                        <td>
                            <div class="dropdown">
                                <button type="button"
                                    class="action-menu-button"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false"
                                    aria-label="Aksi kategori {{ $kategori->nama_kategori }}">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </button>

                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ route('kategori.show', $kategori) }}">
                                            Detail
                                        </a>
                                    </li>

                                    @auth
                                        @if (auth()->user()->role === 'admin')
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('kategori.edit', $kategori) }}">
                                                    Edit
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <button type="button"
                                                    class="dropdown-item text-danger"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal"
                                                    data-delete-action="{{ route('kategori.destroy', $kategori) }}"
                                                    data-delete-name="{{ $kategori->nama_kategori }}">
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
                        <td colspan="4" class="text-center py-4">
                            Belum ada data kategori.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $kategoris->links() }}
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
                    Apakah Anda yakin ingin menghapus kategori
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