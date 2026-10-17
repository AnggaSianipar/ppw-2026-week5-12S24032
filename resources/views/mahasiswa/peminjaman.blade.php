<x-layout>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Riwayat Peminjaman</h1>
            <p class="text-muted mb-0">{{ $mahasiswa->nama }} ({{ $mahasiswa->nim }})</p>
        </div>
        <a href="{{ route('mahasiswa.index') }}" class="btn btn-outline-secondary">Kembali</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Kode Pinjam</th>
                        <th>Judul Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Jatuh Tempo</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($peminjamans as $peminjaman)
                        <tr>
                            <td>{{ $peminjaman->kode_pinjam }}</td>
                            <td>{{ $peminjaman->buku->judul }}</td>
                            <td>{{ $peminjaman->tanggal_pinjam->format('d-m-Y') }}</td>
                            <td>{{ $peminjaman->tanggal_jatuh_tempo->format('d-m-Y') }}</td>
                            <td>{{ $peminjaman->tanggal_kembali?->format('d-m-Y') ?? '-' }}</td>
                            <td>{{ ucfirst($peminjaman->status) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                Mahasiswa ini belum memiliki transaksi peminjaman.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $peminjamans->links() }}</div>
</x-layout>
