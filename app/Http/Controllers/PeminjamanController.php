<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PeminjamanController extends Controller
{
    public function index(Request $request): View
    {
        $peminjamans = Peminjaman::with('buku')
            ->when($request->filled('status'), function ($query) use ($request): void {
                $query->where('status', $request->string('status')->toString());
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('peminjaman.index', compact('peminjamans'));
    }

    public function create(): View
    {
        $bukus = Buku::where('stok', '>', 0)->orderBy('judul')->get();

        return view('peminjaman.create', compact('bukus'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'buku_id' => ['required', 'integer', 'exists:bukus,id'],
            'nim_peminjam' => ['required', 'string', 'max:30'],
            'nama_peminjam' => ['required', 'string', 'max:150'],
            'tanggal_jatuh_tempo' => ['required', 'date', 'after_or_equal:today'],
        ]);

        try {
            DB::transaction(function () use ($validated, $request): void {
                $buku = Buku::where('id', $validated['buku_id'])->lockForUpdate()->firstOrFail();

                if ($buku->stok < 1) {
                    throw new \RuntimeException('Stok buku sedang habis.');
                }

                $hasActiveLoan = Peminjaman::where('buku_id', $buku->id)
                    ->where('nim_peminjam', $validated['nim_peminjam'])
                    ->where('status', 'dipinjam')
                    ->exists();

                if ($hasActiveLoan) {
                    throw new \RuntimeException('NIM tersebut masih meminjam buku yang sama.');
                }

                $buku->decrement('stok');

                Peminjaman::create([
                    'kode_pinjam' => 'PJ-' . now()->format('YmdHis') . '-' . Str::upper(Str::random(4)),
                    'buku_id' => $buku->id,
                    'nim_peminjam' => $validated['nim_peminjam'],
                    'nama_peminjam' => $validated['nama_peminjam'],
                    'tanggal_pinjam' => today(),
                    'tanggal_jatuh_tempo' => $validated['tanggal_jatuh_tempo'],
                    'status' => 'dipinjam',
                ]);

                $request->session()->put('peminjam_terakhir', [
                    'nim' => $validated['nim_peminjam'],
                    'nama' => $validated['nama_peminjam'],
                ]);
            });
        } catch (QueryException $exception) {
            Log::error('Gagal menyimpan transaksi peminjaman.', [
                'message' => $exception->getMessage(),
                'buku_id' => $validated['buku_id'],
                'nim_peminjam' => $validated['nim_peminjam'],
            ]);

            return back()->withInput()->with('error', 'Transaksi gagal disimpan. Silakan coba lagi.');
        } catch (\RuntimeException $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil dicatat.');
    }

    public function return(Peminjaman $peminjaman): RedirectResponse
    {
        try {
            DB::transaction(function () use ($peminjaman): void {
                $loan = Peminjaman::whereKey($peminjaman->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($loan->status === 'dikembalikan') {
                    throw new \RuntimeException('Buku tersebut sudah dikembalikan.');
                }

                $buku = Buku::where('id', $loan->buku_id)->lockForUpdate()->firstOrFail();
                $loan->update([
                    'status' => 'dikembalikan',
                    'tanggal_kembali' => today(),
                ]);
                $buku->increment('stok');
            });
        } catch (QueryException $exception) {
            Log::error('Gagal menyimpan transaksi pengembalian.', [
                'message' => $exception->getMessage(),
                'peminjaman_id' => $peminjaman->id,
            ]);

            return back()->with('error', 'Pengembalian gagal disimpan. Silakan coba lagi.');
        } catch (\RuntimeException $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return back()->with('success', 'Buku berhasil dikembalikan.');
    }
}
