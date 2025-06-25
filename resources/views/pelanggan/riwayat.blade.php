<x-sneat-layout title="Riwayat Pembelian">
    <div class="container-xxl container-p-y">
        <h4 class="fw-bold mb-4">Riwayat Pembelian</h4>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @forelse ($riwayat as $penjualan)
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($penjualan->tanggal)->format('d M Y') }}
                        <strong>Metode:</strong> {{ ucfirst($penjualan->metode_pembayaran) }}
                    </div>
                    <div>
                        <strong>Total:</strong> Rp{{ number_format($penjualan->total) }}
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>No Resi</th>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($penjualan->details as $detail)
                                <tr>
                                    <td>
                                        {{ optional($penjualan->pengiriman)->no_resi ?? '-' }}
                                    </td>

                                    <td>{{ $detail->produk->nama }}</td>
                                    <td>Rp{{ number_format($detail->harga_satuan) }}</td>
                                    <td>{{ $detail->jumlah }}</td>
                                    <td>Rp{{ number_format($detail->subtotal) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @empty
            <div class="alert alert-warning">Belum ada riwayat pembelian.</div>
        @endforelse
    </div>
</x-sneat-layout>
