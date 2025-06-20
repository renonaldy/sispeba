<x-sneat-layout title="Laporan Pengiriman">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Laporan /</span> Pengiriman
        </h4>

        <div class="card p-3 mb-4">
            <form method="GET" action="{{ route('laporan.pengiriman') }}" class="row g-3 mb-3">
                <div class="col-md-2">
                    <label>Dari Tanggal</label>
                    <input type="date" name="from" class="form-control" value="{{ request('from') }}">
                </div>
                <div class="col-md-2">
                    <label>Sampai Tanggal</label>
                    <input type="date" name="to" class="form-control" value="{{ request('to') }}">
                </div>
                <div class="col-md-2">
                    <label>User ID</label>
                    <input type="text" name="user_id" class="form-control" placeholder="User ID"
                        value="{{ request('user_id') }}">
                </div>
                <div class="col-md-2">
                    <label>Pengiriman ID</label>
                    <input type="text" name="pengiriman_id" class="form-control" placeholder="Pengiriman ID"
                        value="{{ request('pengiriman_id') }}">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">Filter</button>
                    <a href="{{ route('laporan.pengiriman.pdf', request()->all()) }}" target="_blank"
                        class="btn btn-danger">Cetak PDF</a>
                </div>
            </form>
        </div>

        <div class="card">
            <div class="table-responsive text-nowrap">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No. Resi</th>
                            <th>Nama Penerima</th>
                            <th>Alamat Tujuan</th>
                            <th>Status Terakhir</th>
                            <th>Tanggal Kirim</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengiriman as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->no_resi }}</td>
                                <td>{{ $item->nama_penerima }}</td>
                                <td>{{ $item->alamat_tujuan }}</td>
                                <td>{{ optional($item->statuses->first())->status ?? '-' }}</td>
                                <td>{{ $item->created_at->format('d-m-Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-sneat-layout>
