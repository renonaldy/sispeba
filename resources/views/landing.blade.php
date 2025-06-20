<x-sneat-layout>
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Hero Section -->
        <div class="row align-items-center my-5">
            <div class="col-md-6" data-aos="fade-right">
                <h1 class="display-4 fw-bold">Kirim Barang Lebih Mudah dan Cepat</h1>
                <p class="lead">SISPEBA adalah solusi layanan pengiriman terpercaya untuk menjangkau seluruh wilayah
                    Riau dan sekitarnya.</p>
                <a href="{{ route('register') }}" class="btn btn-primary btn-lg mt-3">Daftar Sekarang</a>
                <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-lg mt-3 ms-2">Masuk</a>
            </div>
            <div class="col-md-6 text-center" data-aos="fade-left">
                <img src="{{ asset('assets/img/illustrations/shipping.svg') }}" alt="Layanan Pengiriman"
                    class="img-fluid" style="max-height: 300px;">
            </div>
        </div>

        <!-- Features Section -->
        <div class="row text-center my-5">
            <div class="col-md-4" data-aos="zoom-in">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <i class="bx bx-timer fs-1 text-primary"></i>
                        <h5 class="mt-3">Cepat & Tepat</h5>
                        <p>Pengiriman diselesaikan dengan estimasi waktu terukur dan sesuai jadwal.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mt-4 mt-md-0" data-aos="zoom-in" data-aos-delay="100">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <i class="bx bx-shield fs-1 text-success"></i>
                        <h5 class="mt-3">Keamanan Terjamin</h5>
                        <p>Paket Anda dijamin aman dengan sistem pelacakan dan verifikasi kurir.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mt-4 mt-md-0" data-aos="zoom-in" data-aos-delay="200">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <i class="bx bx-search-alt fs-1 text-warning"></i>
                        <h5 class="mt-3">Lacak Kiriman</h5>
                        <p>Gunakan fitur pelacakan resi untuk mengetahui status pengiriman Anda secara real-time.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Call To Action -->
        <div class="text-center my-5" data-aos="fade-up">
            <h2 class="fw-bold mb-3">Gabung Sekarang dan Nikmati Kemudahan Mengirim Barang</h2>
            <p class="lead">Tanpa antri, tanpa ribet. Semuanya bisa kamu lakukan langsung dari dashboard SISPEBA.</p>
            <a href="{{ route('register') }}" class="btn btn-primary btn-lg">Daftar Sekarang</a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center py-4 mt-5 border-top">
        <small>© {{ date('Y') }} SISPEBA – Sistem Pengiriman Barang. All rights reserved.</small>
    </footer>

    @push('scripts')
        <!-- Optional AOS Animation -->
        <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
        <script>
            AOS.init();
        </script>
    @endpush
</x-sneat-layout>
