<x-sneat-layout title="Cek Resi">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Pengiriman /</span> Cek Resi
        </h4>

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <form method="POST" action="{{ route('cek-resi.cari') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="no_resi" class="form-label">Nomor Resi</label>
                                <input type="text" class="form-control @error('no_resi') is-invalid @enderror"
                                    id="no_resi" name="no_resi" placeholder="Masukkan nomor resi..." required>
                                @error('no_resi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Cek Resi</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-sneat-layout>
