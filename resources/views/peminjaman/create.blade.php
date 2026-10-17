<x-layout>
    <style>
        .book-picker { position: relative; }
        .book-options {
            position: absolute;
            z-index: 10;
            top: 100%;
            right: 0;
            left: 0;
            display: none;
            max-height: 280px;
            overflow-y: auto;
            background: #fff;
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        .book-option {
            display: block;
            width: 100%;
            padding: 0.55rem 0.75rem;
            border: 0;
            background: #fff;
            text-align: left;
        }
        .book-option:hover,
        .book-option:focus { background: #f1eaff; }
        .book-option[hidden] { display: none; }
    </style>

    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h1 class="h3 fw-bold mb-4">Catat Peminjaman</h1>
                    <form method="POST" action="{{ route('peminjaman.store') }}" id="peminjaman-form">
                        @csrf
                        <div class="mb-3">
                            <label for="buku_search" class="form-label">Buku</label>
                            <input type="hidden" name="buku_id" id="buku_id" value="{{ old('buku_id') }}">
                            <div class="book-picker">
                                <input type="search" id="buku_search" class="form-control"
                                    placeholder="Pilih atau ketik nama buku..."
                                    autocomplete="off" value="{{ old('buku_search') }}" required>
                                <div id="daftar-buku" class="book-options">
                                @foreach ($bukus as $buku)
                                    <button type="button" class="book-option"
                                        data-buku-id="{{ $buku->id }}"
                                        data-book-label="{{ $buku->judul }} (stok: {{ $buku->stok }})">
                                        {{ $buku->judul }} (stok: {{ $buku->stok }})
                                    </button>
                                @endforeach
                                </div>
                            </div>
                            <div class="form-text">Ketik untuk mencari atau pilih buku dari daftar.</div>
                        </div>
                        <div class="mb-3">
                            <label for="nim_peminjam" class="form-label">NIM Peminjam</label>
                            <input name="nim_peminjam" id="nim_peminjam" class="form-control"
                                value="{{ old('nim_peminjam', session('peminjam_terakhir.nim')) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama_peminjam" class="form-label">Nama Peminjam</label>
                            <input name="nama_peminjam" id="nama_peminjam" class="form-control"
                                value="{{ old('nama_peminjam', session('peminjam_terakhir.nama')) }}" required>
                        </div>
                        <div class="mb-4">
                            <label for="tanggal_jatuh_tempo" class="form-label">Tanggal Jatuh Tempo</label>
                            <input type="date" name="tanggal_jatuh_tempo" id="tanggal_jatuh_tempo"
                                class="form-control" value="{{ old('tanggal_jatuh_tempo', now()->addDays(7)->toDateString()) }}" required>
                        </div>
                        <button class="btn btn-del">Simpan Peminjaman</button>
                        <a href="{{ route('peminjaman.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const bukuSearch = document.getElementById('buku_search');
        const bukuId = document.getElementById('buku_id');
        const daftarBuku = document.getElementById('daftar-buku');
        const peminjamanForm = document.getElementById('peminjaman-form');

        const pilihanBuku = Array.from(daftarBuku.querySelectorAll('.book-option'));

        function tampilkanPilihanBuku() {
            const kataKunci = bukuSearch.value.trim().toLowerCase();
            let jumlahPilihan = 0;

            pilihanBuku.forEach((pilihan) => {
                const cocok = pilihan.textContent.toLowerCase().includes(kataKunci);
                pilihan.hidden = !cocok;
                if (cocok) {
                    jumlahPilihan++;
                }
            });

            daftarBuku.style.display = jumlahPilihan > 0 ? 'block' : 'none';
        }

        pilihanBuku.forEach((pilihan) => {
            pilihan.addEventListener('click', () => {
                bukuId.value = pilihan.dataset.bukuId;
                bukuSearch.value = pilihan.dataset.bookLabel;
                bukuSearch.setCustomValidity('');
                daftarBuku.style.display = 'none';
            });
        });

        bukuSearch.addEventListener('focus', tampilkanPilihanBuku);
        bukuSearch.addEventListener('input', () => {
            bukuId.value = '';
            bukuSearch.setCustomValidity('');
            tampilkanPilihanBuku();
        });

        document.addEventListener('click', (event) => {
            if (!event.target.closest('.book-picker')) {
                daftarBuku.style.display = 'none';
            }
        });

        peminjamanForm.addEventListener('submit', (event) => {
            if (!bukuId.value) {
                event.preventDefault();
                bukuSearch.setCustomValidity('Pilih buku dari daftar yang tersedia.');
                bukuSearch.reportValidity();
            }
        });
    </script>
</x-layout>
