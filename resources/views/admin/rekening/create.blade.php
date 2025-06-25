<x-sneat-layout title="Tambah Rekening">
    <div class="container-xxl container-p-y">
        <h4 class="fw-bold mb-3">Tambah Rekening Pembayaran</h4>

        <form method="POST" action="{{ route('admin.rekening.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Jenis</label>
                <select name="jenis" class="form-select" required>
                    <option value="">-- Pilih Jenis --</option>
                    <option value="bank">Bank</option>
                    <option value="e-wallet">E-Wallet</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Bank / E-Wallet</label>
                <input type="text" name="nama_bank" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nomor Rekening</label>
                <input type="text" name="nomor_rekening" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Atas Nama</label>
                <input type="text" name="atas_nama" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.rekening.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</x-sneat-layout>
