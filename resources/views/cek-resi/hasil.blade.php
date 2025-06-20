<x-sneat-layout title="Hasil Cek Resi">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Pengiriman /</span> Hasil Cek Resi
        </h4>
        <div>
            <a href="{{ route('cek-resi.tracking', $pengiriman->no_resi) }}" class="btn btn-info mt-2">
                Lihat Tracking
            </a>

        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Detail Pengiriman</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Nomor Resi</th>
                                    <td>{{ $pengiriman->no_resi }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Penerima</th>
                                    <td>{{ $pengiriman->nama_penerima }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat Tujuan</th>
                                    <td>{{ $pengiriman->alamat_tujuan }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge bg-label-info">{{ ucfirst($pengiriman->status) }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tanggal Kirim</th>
                                    <td>{{ $pengiriman->created_at->format('d-m-Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                        <a href="{{ route('cek-resi.index') }}" class="btn btn-secondary mt-3">Cek Resi Lain</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-sneat-layout>
