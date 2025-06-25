<x-sneat-layout title="Pembayaran Transfer">
    <div class="container-xxl container-p-y">
        <h4 class="fw-bold mb-4">Pembayaran via Transfer / E-Wallet</h4>

        @php
            $rekeningList = \App\Models\RekeningBank::all();
        @endphp

        <div class="alert alert-info">
            <strong>Silakan transfer ke rekening berikut:</strong><br><br>
            <ul>
                @forelse ($rekeningList as $rekening)
                    <li>
                        <strong>{{ $rekening->nama }}</strong> ({{ ucfirst($rekening->jenis) }}) –
                        a.n. <strong>{{ $rekening->atas_nama }}</strong> –
                        <code>{{ $rekening->nomor_rekening }}</code>
                    </li>
                @empty
                    <li>Tidak ada data rekening tersedia.</li>
                @endforelse
            </ul>
            <p class="mt-2">Upload bukti pembayaran sesuai dengan rekening yang dipilih.</p>
        </div>

        <form method="POST" action="{{ route('keranjang.pembayaran.proses') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Pilih Rekening Tujuan</label>
                <select name="bank" class="form-select" required>
                    <option value="">-- Pilih Rekening --</option>
                    @foreach ($rekeningList as $rekening)
                        <option value="{{ $rekening->nama }}">{{ $rekening->nama }} ({{ ucfirst($rekening->jenis) }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Upload Bukti Pembayaran</label>
                <input type="file" name="bukti_pembayaran" class="form-control" accept="image/*" required>
            </div>

            <button type="submit" class="btn btn-success">Proses Pembelian</button>
        </form>
    </div>
</x-sneat-layout>
