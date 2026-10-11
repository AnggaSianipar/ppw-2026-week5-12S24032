<x-layout>
    <h1 class="h3 fw-bold mb-4">Edit Buku</h1>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('buku.update', $buku) }}" method="POST">
                @csrf
                @method('PUT')

                @include('buku.form')

                <button type="submit" class="btn btn-del">
                    Perbarui Buku
                </button>

                <a href="{{ route('buku.index') }}" class="btn btn-light">
                    Batal
                </a>
            </form>
        </div>
    </div>
</x-layout>