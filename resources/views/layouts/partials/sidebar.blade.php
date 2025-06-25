<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('dashboard') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                {{-- <img src="{{ asset('assets/img/logo/logojne.jpeg') }}" alt="Logo" width="30" /> --}}
            </span>
            <span class="app-brand-text demo menu-text fw-bold ms-2">Sispeba</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="bx bx-chevron-left d-block d-xl-none align-middle"></i>
        </a>
    </div>

    <div class="menu-divider mt-0"></div>
    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Menu Umum -->
        <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-smile"></i>
                <div class="text-truncate">Dashboard</div>
            </a>
        </li>

        @auth
            {{-- Menu untuk Admin --}}
            @if (auth()->user()->role === 'admin')
                <li
                    class="menu-item {{ request()->routeIs('users.*') || request()->routeIs('pengiriman.*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx bx-cog"></i>
                        <div class="text-truncate">Manajemen</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                            <a href="{{ route('users.index') }}" class="menu-link">
                                <div class="text-truncate">Manajemen User</div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="menu-item {{ request()->routeIs('pengiriman.*') ? 'active' : '' }}">
                    <a href="{{ route('pengiriman.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-package"></i>
                        <div class="text-truncate">Data Pengiriman</div>
                    </a>
                </li>
                {{-- Produk --}}
                <li class="menu-item {{ request()->routeIs('produk.*') ? 'active' : '' }}">
                    <a href="{{ route('produk.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-package"></i>
                        <div class="text-truncate">Produk</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.rekening.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.rekening.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-credit-card"></i>
                        <div data-i18n="Rekening Pembayaran">Rekening Pembayaran</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.laporan_pembelian.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.laporan_pembelian.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-list-check"></i>
                        <div>Laporan Pembelian</div>
                    </a>
                </li>
            @endif

            {{-- Menu untuk Kurir --}}
            @if (auth()->user()->role === 'kurir')
                <li class="menu-item {{ request()->routeIs('pengiriman.kurir') ? 'active' : '' }}">
                    <a href="{{ route('pengiriman.kurir') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-send"></i>
                        <div class="text-truncate">Tugas Pengiriman</div>
                    </a>
                </li>
                <!-- Tugas Pengiriman -->
                <li class="menu-item {{ request()->routeIs('kurir.tugas.index') ? 'active' : '' }}">
                    <a href="{{ route('kurir.tugas.index') }}" class="menu-link">
                        <i class="menu-icon bx bx-task"></i>
                        <div>Tugas Pengiriman</div>
                    </a>
                </li>
            @endif

            {{-- Menu untuk User --}}
            @if (auth()->user()->role === 'user')
                <li
                    class="menu-item {{ request()->routeIs('pengiriman.create') || request()->routeIs('resi.cek') ? 'active open' : '' }}">
                    {{-- <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx bx-box"></i>
                        <div class="text-truncate">Layanan Pengiriman</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ request()->routeIs('pengiriman.create') ? 'active' : '' }}">
                            <a href="{{ route('pengiriman.create') }}" class="menu-link">
                                <div class="text-truncate">Kirim Paket</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('resi.cek') ? 'active' : '' }}">
                            <a href="{{ route('cek-resi.index') }}" class="menu-link">
                                <div class="text-truncate">Cek Resi</div>
                            </a>
                        </li>
                    </ul> --}}
                <li class="menu-item {{ request()->routeIs('belanja.index') ? 'active' : '' }}">
                    <a href="{{ route('belanja.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-cart"></i>
                        <div>Belanja Produk</div>
                    </a>
                </li>

                <li class="menu-item {{ request()->routeIs('keranjang.*') ? 'active' : '' }}">
                    <a href="{{ route('keranjang.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-basket"></i>
                        <div>Keranjang</div>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="{{ route('pelanggan.riwayat') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-history"></i>
                        <div>Riwayat Pembelian</div>
                    </a>
                </li>
                {{-- <li class="menu-item {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                    <a href="{{ route('laporan.pengiriman') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-wallet"></i>
                        <div class="text-truncate">Data Laporan</div>
                    </a>
                </li> --}}
                <li class="menu-item {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                    <a href="{{ route('laporan.user') }}" class="menu-link">
                        <i class="menu-icon tf-icons bx bx-wallet"></i>
                        <div class="text-truncate">Data Laporan</div>
                    </a>
                </li>


                </li>
            @endif

            {{-- Menu Umum Untuk Semua Role --}}
            <li class="menu-item {{ request()->routeIs('cek-ongkir.*') ? 'active' : '' }}">
                <a href="{{ route('cek-ongkir.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-search"></i>
                    <div class="text-truncate">Cek Ongkir</div>
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('cek-resi.*') ? 'active' : '' }}">
                <a href="{{ route('cek-resi.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-search-alt"></i>
                    <div class="text-truncate">Cek Resi</div>
                </a>
            </li>
            {{-- Ganti Password --}}
            <li class="menu-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                <a href="{{ route('profile.edit') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-lock"></i>
                    <div class="text-truncate">Ganti Password</div>
                </a>
            </li>
        @endauth
    </ul>
</aside>
