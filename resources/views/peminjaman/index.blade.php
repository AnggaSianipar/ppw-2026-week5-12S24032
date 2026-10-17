<x-layout>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold">Transaksi Peminjaman</h1>
        <a href="{{ route('peminjaman.create') }}" class="btn btn-del">+ Catat Peminjaman</a>
    </div>

    <form method="GET" class="mb-3">
        <div class="input-group">
            <select name="status" class="form-select">
                <option value="">Semua status</option>
                <option value="dipinjam" @selected(request('status') === 'dipinjam')>Dipinjam</option>
                <option value="dikembalikan" @selected(request('status') === 'dikembalikan')>Dikembalikan</option>
            </select>
            <button class="btn btn-outline-secondary">Filter</button>
        </div>
    </form>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Kode</th>
                        <th>Buku</th>
                        <th>Peminjam</th>
                        <th>Pinjam</th>
                        <th>Jatuh Tempo</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($peminjamans as $peminjaman)
                        <tr>
                            <td>{{ $peminjaman->kode_pinjam }}</td>
                            <td>{{ $peminjaman->buku->judul }}</td>
                            <td>{{ $peminjaman->nama_peminjam }}<br><small>{{ $peminjaman->nim_peminjam }}</small></td>
                            <td>{{ $peminjaman->tanggal_pinjam->format('d-m-Y') }}</td>
                            <td>{{ $peminjaman->tanggal_jatuh_tempo->format('d-m-Y') }}</td>
                            <td>{{ ucfirst($peminjaman->status) }}</td>
                            <td>
                                @if ($peminjaman->status === 'dipinjam')
                                    <form method="POST" action="{{ route('peminjaman.return', $peminjaman) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn btn-sm btn-outline-success">Kembalikan</button>
                                    </form>
                                @else
                                    {{ $peminjaman->tanggal_kembali?->format('d-m-Y') }}
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center py-4">Belum ada transaksi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $peminjamans->links() }}</div>
</x-layout>
