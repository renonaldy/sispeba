<x-sneat-layout>
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <h5 class="card-header">
                    Tambah Pengiriman
                </h5>
                <div class="card-body">
                    <form action="{{ route('pengiriman.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="nama_pengirim" class="form-label">Nama Pengirim</label>
                            <input type="text" name="nama_pengirim" class="form-control"
                                value="{{ old('nama_pengirim') }}">
                        </div>

                        <div class="mb-3">
                            <label for="nama_penerima" class="form-label">Nama Penerima</label>
                            <input type="text" name="nama_penerima" class="form-control"
                                value="{{ old('nama_penerima') }}">
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat Asal (Kelurahan)</label>
                            <select name="alamat" id="alamat" class="form-select">
                                <option value="">Pilih Kelurahan</option>
                                @foreach ($kelurahans as $kelurahan)
                                    <option value="{{ $kelurahan->id }}"
                                        {{ old('alamat') == $kelurahan->id ? 'selected' : '' }}>
                                        {{ $kelurahan->kota }}, {{ $kelurahan->kecamatan }},
                                        {{ $kelurahan->kelurahan }}, {{ $kelurahan->kode_pos }} </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="alamat_tujuan" class="form-label">Alamat Tujuan (Kelurahan)</label>
                            <select name="alamat_tujuan" id="alamat_tujuan" class="form-select">
                                <option value="">Pilih Kelurahan</option>
                                @foreach ($kelurahans as $kelurahan)
                                    <option value="{{ $kelurahan->id }}"
                                        {{ old('alamat_tujuan') == $kelurahan->id ? 'selected' : '' }}>
                                        {{ $kelurahan->kota }}, {{ $kelurahan->kecamatan }},
                                        {{ $kelurahan->kelurahan }}, Kode Pos: {{ $kelurahan->kode_pos }} </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat Lengkap</label>
                            <textarea name="alamat_lengkap" id="alamat_lengkap" class="form-control">{{ old('alamat_lengkap') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="kurir_id" class="form-label">Pilih Kurir</label>
                            <select name="kurir_id" id="kurir_id" class="form-select">
                                <option value="">-- Pilih Kurir --</option>
                                @foreach ($kurirs as $kurir)
                                    <option value="{{ $kurir->id }}"
                                        {{ old('kurir_id') == $kurir->id ? 'selected' : '' }}>
                                        {{ $kurir->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- <div class="mb-3">
                            <label for="berat" class="form-label">Berat (kg)</label>
                            <input type="number" step="0.1" min="0" name="berat" id="berat"
                                class="form-control" value="{{ old('berat') }}">
                        </div> --}}

                        {{-- <div class="mb-3">
                            <label for="ongkir" class="form-label">Ongkir (Rp)</label>
                            <input type="number" name="ongkir" id="ongkir" class="form-control" readonly
                                value="{{ old('ongkir') }}">
                        </div> --}}

                        {{-- <div class="mb-3">
                            <label for="kota" class="form-label">Kota</label>
                            <input type="text" name="kota" class="form-control" value="{{ old('kota') }}">
                        </div>

                        <div class="mb-3">
                            <label for="kode_pos" class="form-label">Kode Pos</label>
                            <input type="text" name="kode_pos" class="form-control" value="{{ old('kode_pos') }}">
                        </div> --}}

                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('pengiriman.index') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const beratInput = document.getElementById('berat');
            const asalSelect = document.getElementById('alamat');
            const tujuanSelect = document.getElementById('alamat_tujuan');
            const ongkirInput = document.getElementById('ongkir');

            function hitungOngkir() {
                const asal = asalSelect.value;
                const tujuan = tujuanSelect.value;
                const berat = parseFloat(beratInput.value) || 0;

                // Cek apakah semua input valid
                if (asal && tujuan && berat > 0) {
                    // Kirim data ke server untuk menghitung ongkir
                    fetch('{{ route('pengiriman.hitungOngkir') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            body: JSON.stringify({
                                alamat: asal,
                                alamat_tujuan: tujuan,
                                berat: berat
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.ongkir !== undefined) {
                                // Update nilai ongkir jika sukses
                                ongkirInput.value = Math.round(data.ongkir);
                            } else {
                                ongkirInput.value = 0;
                                alert(data.error || 'Perhitungan ongkir gagal');
                            }
                        })
                        .catch(err => {
                            ongkirInput.value = 0;
                            console.error(err);
                        });
                } else {
                    ongkirInput.value = 0;
                }
            }

            // Tambahkan event listeners untuk input berat, alamat asal dan alamat tujuan
            beratInput.addEventListener('input', hitungOngkir);
            asalSelect.addEventListener('change', hitungOngkir);
            tujuanSelect.addEventListener('change', hitungOngkir);

            // Panggil hitungOngkir ketika pertama kali halaman dimuat untuk inisialisasi
            hitungOngkir();
        });
    </script> --}}
</x-sneat-layout>
