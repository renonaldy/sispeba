<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SISPEBA - Sistem Informasi Pelacakan Barang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Public Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">

    <header class="bg-white shadow-sm relative z-10">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="text-xl font-bold text-blue-700">SISPEBA</div>
            @if (Route::has('login'))
                <div class="flex gap-4 items-center">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 hover:text-blue-700">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-blue-700">Login</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-sm text-gray-700 hover:text-blue-700">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </header>

    <!-- Hero Slider -->
    <section x-data="{
        slides: [{
                title: 'Cek Ongkir dan Lacak Paket',
                desc: 'Kelola pengiriman Anda dengan efisien dan cepat menggunakan platform SISPEBA.',
                img: 'https://cdn-icons-png.flaticon.com/512/2901/2901160.png'
            },
            {
                title: 'Tracking Real-Time & Notifikasi',
                desc: 'Pantau status barang Anda dengan pembaruan otomatis dan pemberitahuan pelanggan.',
                img: 'https://cdn-icons-png.flaticon.com/512/1533/1533802.png'
            },
            {
                title: 'Estimasi Ongkir Akurat',
                desc: 'Gunakan fitur kalkulasi ongkir berdasarkan jarak dan berat secara otomatis.',
                img: 'https://cdn-icons-png.flaticon.com/512/3406/3406862.png'
            }
        ],
        active: 0,
        prevActive: 0,
        next() {
            this.prevActive = this.active;
            this.active = (this.active + 1) % this.slides.length;
        },
        prev() {
            this.prevActive = this.active;
            this.active = (this.active - 1 + this.slides.length) % this.slides.length;
        },
        go(i) {
            this.prevActive = this.active;
            this.active = i;
        },
        init() {
            {{-- setInterval(() => this.next(), 7000); --}}
        }
    }" x-init="init()"
        class="relative overflow-hidden bg-gradient-to-r from-blue-700 to-blue-500 text-white min-h-screen flex items-center justify-center">

        <div class="container mx-auto px-6 py-16 relative overflow-hidden" style="min-height: 400px">
            <template x-for="(slide, index) in slides" :key="index">
                <div x-show="active === index" x-transition:enter="transition duration-700 ease-out transform"
                    x-transition:enter-start="opacity-0 translate-x-60"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    x-transition:leave="transition duration-700 ease-in transform"
                    x-transition:leave-start="opacity-100 translate-x-0"
                    x-transition:leave-end="opacity-0 -translate-x-60"
                    class="absolute inset-0 grid md:grid-cols-2 gap-10 items-center w-full h-full px-4 md:px-8">

                    <!-- Text -->
                    <div class="space-y-6 text-center md:text-left">
                        <h1 class="text-4xl sm:text-5xl font-bold" x-text="slide.title"></h1>
                        <p class="text-lg text-blue-100" x-text="slide.desc"></p>
                        <div class="space-x-4 mt-6">
                            <a href="{{ route('login') }}"
                                class="inline-block bg-white text-blue-700 px-6 py-3 rounded font-semibold hover:bg-gray-100 transition">
                                Mulai Sekarang
                            </a>
                        </div>
                    </div>

                    <!-- Image -->
                    <div class="text-center">
                        <img :src="slide.img" alt="Ilustrasi" class="w-72 h-72 mx-auto drop-shadow-xl">
                    </div>
                </div>
            </template>
        </div>

        <!-- Navigation Arrows -->
        <div class="absolute top-1/2 left-4 transform -translate-y-1/2 z-10">
            <button @click="prev" class="bg-white text-blue-700 rounded-full p-2 shadow hover:bg-blue-100 transition">
                &#8592;
            </button>
        </div>
        <div class="absolute top-1/2 right-4 transform -translate-y-1/2 z-10">
            <button @click="next" class="bg-white text-blue-700 rounded-full p-2 shadow hover:bg-blue-100 transition">
                &#8594;
            </button>
        </div>

        <!-- Pagination Dots -->
        <div class="absolute bottom-6 left-0 right-0 flex justify-center gap-2">
            <template x-for="(slide, index) in slides" :key="'dot' + index">
                <button @click="go(index)" :class="active === index ? 'bg-white scale-125' : 'bg-white opacity-40'"
                    class="w-3 h-3 rounded-full transition-transform duration-300"></button>
            </template>
        </div>
    </section>

    <footer class="bg-gray-100 text-center text-sm py-6">
        &copy; {{ date('Y') }} SISPEBA - Sistem Informasi Pelacakan Barang
    </footer>

</body>

</html>
