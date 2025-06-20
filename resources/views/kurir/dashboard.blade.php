<x-sneat-layout title="Dashboard Kurir">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold">Selamat Datang, {{ auth()->user()->name }}</h4>

        <div class="row mt-4">
            <div class="col-md-6 col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Tugas Hari Ini</h5>
                        <p class="card-text">Lihat daftar pengiriman yang harus Anda antar hari ini.</p>
                        <a href="{{ route('pengiriman.kurir') }}" class="btn btn-success">Lihat Tugas</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-sneat-layout>
