<x-sneat-layout title="Belanja Produk">
    <div class="container-xxl container-p-y">
        <h4 class="fw-bold py-3 mb-4">Belanja Produk</h4>

        {{-- @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif --}}

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-4">
            @forelse ($produks as $produk)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        @if ($produk->gambar)
                            <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama }}"
                                class="card-img-top"
                                style="height: 180px; object-fit: cover; border-top-left-radius: .5rem; border-top-right-radius: .5rem;">
                        @else
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                                style="height: 180px;">
                                <span class="text-muted">Tidak ada gambar</span>
                            </div>
                        @endif
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $produk->nama }}</h5>
                            <p class="card-text mb-1">Harga: <strong>Rp{{ number_format($produk->harga) }}</strong></p>
                            <p class="card-text text-muted mb-2">Stok: {{ $produk->stok }}</p>

                            <form method="POST" action="{{ route('keranjang.tambah') }}" class="mt-auto">
                                @csrf
                                <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                                <div class="input-group">
                                    <input type="number" name="jumlah" class="form-control" placeholder="Jumlah"
                                        min="1" max="{{ $produk->stok }}" required>
                                    <button type="submit" class="btn btn-primary">+</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-warning text-center">Belum ada produk tersedia.</div>
                </div>
            @endforelse
        </div>

        <div class="mt-4 text-center">
            <a href="{{ route('keranjang.index') }}" class="btn btn-outline-primary">🛒 Lihat Keranjang</a>
        </div>
    </div>
</x-sneat-layout>
