<x-layout>
    <h1 class="h3 fw-bold mb-4">Edit Kategori</h1>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('kategori.update', $kategori) }}" method="POST">
                @csrf
                @method('PUT')

                @include('kategori.form')

                <button type="submit" class="btn btn-del">Perbarui</button>
                <a href="{{ route('kategori.index') }}" class="btn btn-light">Batal</a>
            </form>
        </div>
    </div>
</x-layout>