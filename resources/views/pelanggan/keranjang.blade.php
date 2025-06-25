<x-sneat-layout title="Keranjang Belanja">
    <div class="container-xxl container-p-y">
        <h4 class="fw-bold">Keranjang Belanja</h4>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @php $rekeningList = \App\Models\RekeningBank::all(); @endphp

        @if (count($keranjang) > 0)
            <form method="POST" action="{{ route('keranjang.pembayaran.proses') }}" enctype="multipart/form-data">
                @csrf

                {{-- TABEL KERANJANG --}}
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach ($keranjang as $item)
                            @php
                                $subtotal = $item['harga'] * $item['jumlah'];
                                $total += $subtotal;
                            @endphp
                            <tr>
                                <td>{{ $item['nama'] }}</td>
                                <td>Rp{{ number_format($item['harga']) }}</td>
                                <td>{{ $item['jumlah'] }}</td>
                                <td>Rp{{ number_format($subtotal) }}</td>
                                <td>
                                    <form method="POST" action="{{ route('keranjang.hapus') }}"
                                        id="hapus-{{ $item['id'] }}">
                                        @csrf
                                        <input type="hidden" name="produk_id" value="{{ $item['id'] }}">
                                    </form>
                                    <button type="submit" form="hapus-{{ $item['id'] }}"
                                        class="btn btn-danger btn-sm">Hapus</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3">Total</th>
                            <th>Rp{{ number_format($total) }}</th>
                            <th></th>
                        </tr>
                        <tr>
                            <th colspan="3">Ongkir</th>
                            <th id="ongkir-display">Rp0</th>
                            <th></th>
                        </tr>
                        <tr>
                            <th colspan="3">Asuransi (1%)</th>
                            <th id="asuransi-display">Rp0</th>
                            <th></th>
                        </tr>
                        <tr>
                            <th colspan="3">Grand Total</th>
                            <th id="grandtotal-display">Rp{{ number_format($total) }}</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>

                {{-- FORM PENGIRIMAN & PEMBAYARAN --}}
                <div class="row">
                    <div class="col-md-6">
                        <h5>Informasi Pengiriman</h5>
                        <div class="mb-3">
                            <label class="form-label">Nama Penerima</label>
                            <input type="text" name="nama_penerima" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kota</label>
                            <select name="kota" class="form-select" required>
                                <option value="">-- Pilih Kota --</option>
                                @foreach ($kotaList as $kota)
                                    <option value="{{ $kota->nama }}">{{ $kota->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kecamatan</label>
                            <select name="kecamatan" class="form-select" required>
                                <option value="">-- Pilih Kecamatan --</option>
                                @foreach ($kecamatanList as $kecamatan)
                                    <option value="{{ $kecamatan->nama }}">{{ $kecamatan->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kelurahan</label>
                            <select name="kelurahan" id="kelurahan" class="form-select" required>
                                <option value="">-- Pilih Kelurahan --</option>
                                @foreach ($kelurahanList as $kelurahan)
                                    <option value="{{ $kelurahan->kelurahan }}">{{ $kelurahan->kelurahan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kode Pos</label>
                            <input type="text" name="kode_pos" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No. HP Penerima</label>
                            <input type="text" name="no_hp" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h5>Metode Pembayaran</h5>

                        <div class="mb-3">
                            <label class="form-label">Metode Pembayaran</label>
                            <select name="metode_pembayaran" class="form-select" required>
                                <option value="">-- Pilih Metode --</option>
                                @foreach ($rekeningList as $rekening)
                                    <option value="transfer:{{ $rekening->nama }}">
                                        Transfer ke {{ $rekening->nama }} ({{ ucfirst($rekening->jenis) }}) a.n.
                                        {{ $rekening->atas_nama }} - {{ $rekening->nomor_rekening }}
                                    </option>
                                @endforeach
                                <option value="cod">Bayar di Tempat (COD)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Upload Bukti Pembayaran</label>
                            <input type="file" name="bukti_pembayaran"
                                class="form-control @error('bukti_pembayaran') is-invalid @enderror" accept="image/*">
                            @error('bukti_pembayaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-success w-100">Proses Pembayaran</button>
                        </div>
                    </div>
                </div>
            </form>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const kelurahanSelect = document.getElementById('kelurahan');

                    if (kelurahanSelect) {
                        kelurahanSelect.addEventListener('change', function() {
                            const kelurahan = this.value;
                            const totalBelanja = {{ $total }};

                            if (kelurahan) {
                                fetch(`/get-ongkir/${kelurahan}`)
                                    .then(response => response.json())
                                    .then(data => {
                                        const ongkir = parseInt(data.ongkir || 0);
                                        const asuransi = Math.round(totalBelanja * 0.01);
                                        const grandTotal = totalBelanja + ongkir + asuransi;

                                        document.getElementById('ongkir-display').textContent = 'Rp' + ongkir
                                            .toLocaleString();
                                        document.getElementById('asuransi-display').textContent = 'Rp' +
                                            asuransi.toLocaleString();
                                        document.getElementById('grandtotal-display').textContent = 'Rp' +
                                            grandTotal.toLocaleString();
                                    })
                                    .catch(error => {
                                        console.error('Gagal ambil ongkir:', error);
                                    });
                            }
                        });
                    }
                });
            </script>
        @else
            <div class="alert alert-warning">Keranjang belanja Anda kosong.</div>
        @endif
    </div>

</x-sneat-layout>
