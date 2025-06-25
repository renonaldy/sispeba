<x-sneat-layout title="Laporan Pembelian">
    <div class="container-xxl container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Laporan Pembelian Pengguna</h4>
                <div class="d-flex gap-2">
                    <form action="{{ route('admin.laporan_pembelian.index') }}" method="GET" class="d-flex">
                        <select name="status" class="form-select me-2" onchange="this.form.submit()">
                            <option value="">Semua Status</option>
                            <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu
                            </option>
                            <option value="dikirim" {{ request('status') == 'dikirim' ? 'selected' : '' }}>Dikirim
                            </option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai
                            </option>
                        </select>
                    </form>
                    <a href="{{ route('laporan.pengiriman.pdf') }}" class="btn btn-sm btn-outline-danger"
                        target="_blank">
                        <i class="bx bx-download"></i> PDF
                    </a>
                </div>
            </div>

            <div class="table-responsive text-nowrap">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Nama Pengguna</th>
                            <th>Total</th>
                            <th>Metode</th>
                            <th>Status</th>
                            <th>Detail</th>
                            <th>Bukti</th>
                            <th>Proses Pengiriman</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pembelian as $p)
                            <tr>
                                <td>{{ $p->created_at->format('d M Y') }}</td>
                                <td>{{ $p->user->name ?? '-' }}</td>
                                <td>Rp{{ number_format($p->total) }}</td>
                                <td>{{ strtoupper($p->metode_pembayaran) }}</td>
                                <td>
                                    @if ($p->status === 'menunggu')
                                        <a href="{{ route('admin.laporan_pembelian.form-pengiriman', $p->id) }}"
                                            class="btn btn-sm btn-primary">Proses Pengiriman</a>
                                    @elseif ($p->status === 'diproses')
                                        <span class="badge bg-warning text-dark">Sedang Diproses</span>
                                    @elseif ($p->status === 'dikirim')
                                        <span class="badge bg-success">Sudah Dikirim</span>
                                    @else
                                        <span class="badge bg-secondary">Status Tidak Diketahui</span>
                                    @endif
                                </td>
                                <td>
                                    <ul class="mb-0">
                                        @foreach ($p->details as $d)
                                            <li>{{ $d->produk->nama ?? '[Produk Dihapus]' }} - {{ $d->jumlah }} x
                                                Rp{{ number_format($d->harga) }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                            <td>
                                    @if ($p->bukti_pembayaran)
                                        <a href="{{ asset('storage/bukti_pembayaran/' . $p->bukti_pembayaran) }}"
                                            target="_blank" class="btn btn-sm btn-outline-info">
                                            <i class="bx bx-show"></i> Lihat Bukti
                                        </a>
                                    @else
                                        <em>Belum ada</em>
                                    @endif
                                </td>
                                <td>
                                    @if ($p->status !== 'dikirim')
                                        <a href="{{ route('admin.laporan_pembelian.form-pengiriman', $p->id) }}"
                                            class="btn btn-sm btn-primary">Proses Pengiriman</a>
                                    @else
                                        <span class="badge bg-success">Sudah Dikirim</span>
                                    @endif

                                    <form action="{{ route('admin.laporan_pembelian.destroy', $p->id) }}"
                                        method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?');"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            <i class="bx bx-trash"></i>Hapus
                                        </button>
                                    </form>
                                </td>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">Belum ada data pembelian.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $pembelian->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</x-sneat-layout>
