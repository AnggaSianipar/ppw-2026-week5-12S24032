<x-layout>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold mb-0">Tambah Mahasiswa</h1>
        <a href="{{ route('mahasiswa.index') }}" class="btn btn-outline-secondary">Kembali</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <p class="mb-2 fw-semibold">Periksa kembali data yang diisi:</p>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('mahasiswa.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="nim" class="form-label">NIM</label>
                    <input type="text" id="nim" name="nim" value="{{ old('nim') }}"
                        class="form-control @error('nim') is-invalid @enderror"
                        maxlength="8" inputmode="numeric" required>
                    @error('nim')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" id="nama" name="nama" value="{{ old('nama') }}"
                        class="form-control @error('nama') is-invalid @enderror"
                        maxlength="150" required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                        class="form-control @error('email') is-invalid @enderror"
                        maxlength="100" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="program_studi_id" class="form-label">Program Studi</label>
                    <select id="program_studi_id" name="program_studi_id"
                        class="form-select @error('program_studi_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Program Studi --</option>
                        @foreach ($programStudis as $programStudi)
                            <option value="{{ $programStudi->id }}"
                                @selected(old('program_studi_id') == $programStudi->id)>
                                {{ $programStudi->nama }} ({{ $programStudi->jenjang }})
                            </option>
                        @endforeach
                    </select>
                    @error('program_studi_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="ipk" class="form-label">IPK</label>
                    <input type="number" id="ipk" name="ipk" value="{{ old('ipk') }}"
                        class="form-control @error('ipk') is-invalid @enderror"
                        min="0" max="4" step="0.01" required>
                    @error('ipk')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-del">Simpan Mahasiswa</button>
                <a href="{{ route('mahasiswa.index') }}" class="btn btn-light">Batal</a>
            </form>
        </div>
    </div>
</x-layout>
