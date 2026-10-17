<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Database\Seeder;

class PeminjamanSeeder extends Seeder
{
    public function run(): void
    {
        $bukuStokNol = Buku::query()->orderBy('id')->firstOrFail();
        $bukuStokNol->update(['stok' => 0]);

        $bukuStokSatu = Buku::query()->where('id', '<>', $bukuStokNol->id)->orderBy('id')->firstOrFail();
        $bukuStokSatu->update(['stok' => 1]);

        $bukuDenganTransaksi = Buku::query()
            ->where('id', '<>', $bukuStokNol->id)
            ->where('id', '<>', $bukuStokSatu->id)
            ->orderBy('id')
            ->firstOrFail();

        $peminjaman = Peminjaman::firstOrCreate(
            ['kode_pinjam' => 'PJ-SEED-001'],
            [
                'buku_id' => $bukuDenganTransaksi->id,
                'nim_peminjam' => '12S24032',
                'nama_peminjam' => 'Angga Sianipar',
                'tanggal_pinjam' => now()->subDays(2)->toDateString(),
                'tanggal_jatuh_tempo' => now()->addDays(5)->toDateString(),
                'tanggal_kembali' => null,
                'status' => 'dipinjam',
            ]
        );

        if ($peminjaman->wasRecentlyCreated) {
            $bukuDenganTransaksi->decrement('stok');
        }
    }
}
