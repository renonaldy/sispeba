<x-sneat-layout title="Transaksi Penjualan">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold mb-4">Transaksi Penjualan</h4>

        <form method="POST" action="{{ route('penjualan.store') }}">
            @csrf

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Jumlah Beli</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($produks as $produk)
                            <tr>
                                <td>
                                    <input type="hidden" name="produk_id[]" value="{{ $produk->id }}">
                                    {{ $produk->nama }}
                                </td>
                                <td>Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                                <td>{{ $produk->stok }}</td>
                                <td>
                                    <input type="number" name="jumlah[]" class="form-control" min="0"
                                        max="{{ $produk->stok }}">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <button type="submit" class="btn btn-success mt-3">Proses Penjualan</button>
        </form>
    </div>
</x-sneat-layout>
