<x-sneat-layout title="Laporan Pembelian Saya">
    <div class="container-xxl container-p-y">
        <h4 class="fw-bold mb-4">📦 Riwayat Pembelian Anda</h4>

        <div class="card shadow-sm rounded-2">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered mb-0">
                        <thead class="table-light text-center">
                            <tr>
                                <th>No Resi</th>
                                <th>Nama Penerima</th>
                                <th>Alamat</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($laporan as $item)
                                @foreach ($item->details as $detail)
                                    <tr>
                                        <td>
                                            <span class="badge bg-label-primary">
                                                {{ optional($item->pengiriman)->no_resi ?? 'Belum Dikirim' }}
                                            </span>
                                        </td>
                                        <td>{{ $item->nama_penerima }}</td>
                                        {{-- <td class="text-nowrap"> --}}

                                        {{-- {{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td> --}}
                                        <td>{{ $item->alamat }}</td>
                                        <td>Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                        <td class="text-center">{{ $item->status }}</td>
                                    </tr>
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Belum ada pembelian.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-sneat-layout>
