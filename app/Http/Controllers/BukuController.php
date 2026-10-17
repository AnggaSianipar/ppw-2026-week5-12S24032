<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BukuController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->only(['search', 'kategori_id']);
        $bukus = Buku::with('kategori')
            ->withCount('peminjamans')
            ->when($request->filled('search'), function ($query) use ($request): void {
                $search = $request->string('search')->toString();
                $query->where(function ($query) use ($search): void {
                    $query->where('judul', 'like', "%{$search}%")
                        ->orWhere('penulis', 'like', "%{$search}%")
                        ->orWhere('isbn', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('kategori_id'), function ($query) use ($request): void {
                $query->where('kategori_id', $request->integer('kategori_id'));
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $kategoris = Kategori::orderBy('nama_kategori')->get();
        $stats = [
            'judul' => DB::table('bukus')->count(),
            'stok' => DB::table('bukus')->sum('stok'),
            'dipinjam' => DB::table('peminjamans')->where('status', 'dipinjam')->count(),
            'dikembalikan' => DB::table('peminjamans')->where('status', 'dikembalikan')->count(),
        ];

        if ($request->filled('search')) {
            $history = $request->session()->get('riwayat_pencarian', []);
            array_unshift($history, $request->string('search')->toString());
            $request->session()->put('riwayat_pencarian', array_slice(array_unique($history), 0, 5));
            Cookie::queue('sipus_last_search', $request->string('search')->toString(), 60, '/', null, false, true, false, 'lax');
        }

        return view('buku.index', compact('bukus', 'kategoris', 'stats', 'filters'));
    }

    public function create(): View
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view('buku.create', compact('kategoris'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'isbn' => [
                'required',
                'string',
                'max:20',
                'unique:bukus,isbn',
            ],
            'judul' => [
                'required',
                'string',
                'min:5',
                'max:200',
            ],
            'penulis' => [
                'required',
                'string',
                'max:150',
            ],
            'penerbit' => [
                'required',
                'string',
                'max:150',
            ],
            'tahun_terbit' => [
                'required',
                'integer',
                'between:1000,2100',
            ],
            'kategori_id' => [
                'required',
                'integer',
                'exists:kategoris,id',
            ],
            'stok' => [
                'required',
                'integer',
                'min:0',
            ],
            'sinopsis' => [
                'nullable',
                'string',
            ],
        ]);

        Buku::create($validated);

        return redirect()
            ->route('buku.index')
            ->with('success', 'Buku berhasil ditambahkan.');
    }

    public function show(Buku $buku): View
    {
        $buku->load('kategori');

        return view('buku.show', compact('buku'));
    }

    public function edit(Buku $buku): View
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view('buku.edit', compact('buku', 'kategoris'));
    }

    public function update(Request $request, Buku $buku): RedirectResponse
    {
        $validated = $request->validate([
            'isbn' => [
                'required',
                'string',
                'max:20',
                'unique:bukus,isbn,' . $buku->id,
            ],
            'judul' => [
                'required',
                'string',
                'min:5',
                'max:200',
            ],
            'penulis' => [
                'required',
                'string',
                'max:150',
            ],
            'penerbit' => [
                'required',
                'string',
                'max:150',
            ],
            'tahun_terbit' => [
                'required',
                'integer',
                'between:1000,2100',
            ],
            'kategori_id' => [
                'required',
                'integer',
                'exists:kategoris,id',
            ],
            'stok' => [
                'required',
                'integer',
                'min:0',
            ],
            'sinopsis' => [
                'nullable',
                'string',
            ],
        ]);

        $buku->update($validated);

        return redirect()
            ->route('buku.index')
            ->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Buku $buku): RedirectResponse
    {
        $buku->delete();

        return redirect()
            ->route('buku.index')
            ->with('success', 'Buku berhasil dihapus.');
    }
}