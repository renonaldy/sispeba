<x-sneat-layout title="Edit Rekening">
    <div class="container-xxl container-p-y">
        <h4 class="fw-bold mb-3">Edit Rekening Pembayaran</h4>

        <form method="POST" action="{{ route('admin.rekening.update', $rekening->id) }}">
            @csrf @method('PUT')

            <div class="mb-3">
                <label class="form-label">Jenis</label>
                <select name="jenis" class="form-select" required>
                    <option value="bank" {{ $rekening->jenis == 'bank' ? 'selected' : '' }}>Bank</option>
                    <option value="e-wallet" {{ $rekening->jenis == 'e-wallet' ? 'selected' : '' }}>E-Wallet</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Bank / E-Wallet</label>
                <input type="text" name="nama" class="form-control" value="{{ $rekening->nama_bank }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nomor Rekening</label>
                <input type="text" name="nomor_rekening" class="form-control" value="{{ $rekening->nomor_rekening }}"
                    required>
            </div>

            <div class="mb-3">
                <label class="form-label">Atas Nama</label>
                <input type="text" name="atas_nama" class="form-control" value="{{ $rekening->atas_nama }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.rekening.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</x-sneat-layout>
