<x-sneat-layout title="Laporan Pembelian Saya">
    <div class="container-xxl container-p-y">
        <h4 class="fw-bold mb-4">Laporan Pembelian Anda</h4>

        <div class="card p-3">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                            <th>No Resi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($laporan as $item)
                            @foreach ($item->details as $detail)
                                <tr>
                                    <td>{{ $item->tanggal->format('d-m-Y') }}</td>
                                    <td>{{ $detail->produk->nama }}</td>
                                    <td>{{ $detail->jumlah }}</td>
                                    <td>Rp{{ number_format($detail->subtotal) }}</td>
                                    <td>{{ optional($item->pengiriman)->no_resi ?? '-' }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-sneat-layout>
