<x-sneat-layout title="Konfirmasi Pengiriman">
    <div class="container-xxl container-p-y">
        <h4 class="fw-bold mb-4">Konfirmasi Pengiriman</h4>

        <div class="card mb-4">
            <div class="card-body">
                <p><strong>Nama Pembeli:</strong> {{ $pembelian->user->name }}</p>
                <p><strong>Total:</strong> Rp{{ number_format($pembelian->total) }}</p>
                <p><strong>Alamat Pengiriman:</strong> {{ $pembelian->alamat }}</p>
            </div>
        </div>

        <form action="{{ route('admin.laporan_pembelian.simpan-pengiriman', $pembelian->id) }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Kurir</label>
                <select name="kurir" class="form-select" required>
                    <option value="">-- Pilih Kurir --</option>
                    @foreach ($kurirs as $kurir)
                        <option value="{{ $kurir->name }}">{{ $kurir->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">No Resi</label>
                <input type="text" name="no_resi" class="form-control" value="{{ $resi }}" readonly required>
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal Kirim</label>
                <input type="date" name="tanggal_kirim" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success">Simpan & Kirim</button>
            <a href="{{ route('admin.laporan_pembelian.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</x-sneat-layout>
