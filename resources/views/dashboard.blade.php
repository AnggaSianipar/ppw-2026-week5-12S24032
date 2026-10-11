<x-layout>
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h1 class="h3 fw-bold">Dashboard</h1>
            <p class="mb-0">
                Selamat datang, {{ auth()->user()->name }}.
                Anda login sebagai {{ auth()->user()->role }}.
            </p>
        </div>
    </div>
</x-layout>