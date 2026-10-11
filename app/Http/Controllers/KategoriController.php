<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KategoriController extends Controller
{
    public function index(): View
    {
        $kategoris = Kategori::withCount('bukus')
            ->orderBy('nama_kategori')
            ->paginate(10);

        return view('kategori.index', compact('kategoris'));
    }

    public function create(): View
    {
        return view('kategori.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kode_kategori' => [
                'required',
                'string',
                'max:20',
                'unique:kategoris,kode_kategori',
            ],
            'nama_kategori' => [
                'required',
                'string',
                'min:3',
                'max:100',
            ],
        ]);

        Kategori::create($validated);

        return redirect()
            ->route('kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function show(Kategori $kategori): View
    {
        $kategori->load('bukus');

        return view('kategori.show', compact('kategori'));
    }

    public function edit(Kategori $kategori): View
    {
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori): RedirectResponse
    {
        $validated = $request->validate([
            'kode_kategori' => [
                'required',
                'string',
                'max:20',
                'unique:kategoris,kode_kategori,' . $kategori->id,
            ],
            'nama_kategori' => [
                'required',
                'string',
                'min:3',
                'max:100',
            ],
        ]);

        $kategori->update($validated);

        return redirect()
            ->route('kategori.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Kategori $kategori): RedirectResponse
    {
        if ($kategori->bukus()->exists()) {
            return redirect()
                ->route('kategori.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh buku.');
        }

        $kategori->delete();

        return redirect()
            ->route('kategori.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}