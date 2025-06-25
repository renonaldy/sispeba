<x-sneat-layout title="Manajemen Produk">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">Produk Dijual</h4>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Daftar Produk</h5>
                <a href="{{ route('produk.create') }}" class="btn btn-primary">+ Tambah Produk</a>
            </div>

            <div class="table-responsive text-nowrap">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($produks as $produk)
                            <tr>
                                <td>{{ $produk->nama }}</td>
                                <td>{{ $produk->kategori->nama }}</td>
                                <td>Rp{{ number_format($produk->harga, 0, ',', '.') }}</td>
                                <td>{{ $produk->stok }}</td>
                                <td>
                                    @if ($produk->gambar)
                                        <img src="{{ asset('storage/' . $produk->gambar) }}" alt="Gambar"
                                            width="60">
                                    @else
                                        <span class="text-muted">Tidak ada</span>
                                    @endif
                                </td>

                                <td>
                                    <a href="{{ route('produk.edit', $produk) }}"
                                        class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('produk.destroy', $produk) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Hapus produk ini?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada produk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-sneat-layout>
