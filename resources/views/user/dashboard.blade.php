<x-sneat-layout title="Dashboard Pelanggan">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold">Selamat Datang, {{ auth()->user()->name }}</h4>

        <div class="row mt-4">
            <div class="col-md-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Pengiriman Saya</h5>
                        <p class="card-text">Lihat status pengiriman dan detail paket Anda.</p>
                        <a href="{{ route('pengiriman.index') }}" class="btn btn-primary">Lihat Pengiriman</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-sneat-layout>
