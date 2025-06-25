<x-sneat-layout>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">Cek Ongkir</h4>


        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Terjadi Kesalahan:</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <div class="card mb-4">
            <div class="card-body">
                <form method="POST" action="{{ route('ongkir.calculate') }}">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Asal</label>

                            <select id="asal-provinsi" class="form-select mb-2" required>
                                <option value="">Pilih Provinsi</option>
                                @foreach ($provinsi as $p)
                                    <option value="{{ $p->provinsi }}">{{ $p->provinsi }}</option>
                                @endforeach
                            </select>

                            <select id="asal-kota" class="form-select mb-2" disabled required>
                                <option value="">Pilih Kota</option>
                            </select>

                            <select id="asal-kecamatan" class="form-select mb-2" disabled required>
                                <option value="">Pilih Kecamatan</option>
                            </select>

                            <select id="asal-kelurahan" name="asal_kelurahan" class="form-select mb-2" disabled
                                required>
                                <option value="">Pilih Kelurahan</option>
                            </select>

                            <input id="asal-kodepos" type="text" class="form-control" placeholder="Kode Pos"
                                readonly>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tujuan</label>

                            <select id="tujuan-provinsi" class="form-select mb-2" required>
                                <option value="">Pilih Provinsi</option>
                                @foreach ($provinsi as $p)
                                    <option value="{{ $p->provinsi }}">{{ $p->provinsi }}</option>
                                @endforeach
                            </select>

                            <select id="tujuan-kota" class="form-select mb-2" disabled required>
                                <option value="">Pilih Kota</option>
                            </select>

                            <select id="tujuan-kecamatan" class="form-select mb-2" disabled required>
                                <option value="">Pilih Kecamatan</option>
                            </select>

                            <select id="tujuan-kelurahan" name="tujuan_kelurahan" class="form-select mb-2" disabled
                                required>
                                <option value="">Pilih Kelurahan</option>
                            </select>

                            <input id="tujuan-kodepos" type="text" class="form-control" placeholder="Kode Pos"
                                readonly>
                        </div>

                        <div class="col-md-12 mt-3">
                            <label class="form-label">Berat (kg)</label>
                            <input type="number" name="berat" min="1" class="form-control" required>
                        </div>
                    </div>
                    <button class="btn btn-primary mt-3" type="submit">Hitung Ongkir</button>
                </form>
            </div>
        </div>

        @if (session('ongkir'))
            <div class="card">
                <div class="card-body">
                    <h5>Hasil Perhitungan</h5>
                    <p>Asal: <strong>{{ session('asal') }}</strong></p>
                    <p>Tujuan: <strong>{{ session('tujuan') }}</strong></p>
                    <p>Berat: <strong>{{ session('berat') }} kg</strong></p>
                    {{-- <p>Jarak: <strong>{{ session('jarak') }} km</strong></p> --}}
                    <p>Ongkir: <strong>Rp {{ number_format(session('ongkir'), 0, ',', '.') }}</strong></p>
                </div>
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function fetchOptions(url, params = {}) {
                let query = new URLSearchParams(params).toString();
                return fetch(url + (query ? '?' + query : ''))
                    .then(res => res.json());
            }

            function setupDropdown(parentId, childId, apiUrl, paramName) {
                const parent = document.getElementById(parentId);
                const child = document.getElementById(childId);

                parent.addEventListener('change', function() {
                    const val = parent.value;
                    child.innerHTML = '<option value="">Loading...</option>';
                    child.disabled = true;
                    if (!val) {
                        child.innerHTML =
                            `<option value="">Pilih ${child.getAttribute('data-label')}</option>`;
                        child.disabled = true;
                        return;
                    }
                    fetchOptions(apiUrl, {
                        [paramName]: val
                    }).then(data => {
                        let options =
                            `<option value="">Pilih ${child.getAttribute('data-label')}</option>`;
                        data.forEach(item => {
                            let key = Object.values(item)[0];
                            options += `<option value="${key}">${key}</option>`;
                        });
                        child.innerHTML = options;
                        child.disabled = false;
                    });
                });
            }

            // Setup asal dropdowns
            setupDropdown('asal-provinsi', 'asal-kota', '/get-kota', 'provinsi');
            setupDropdown('asal-kota', 'asal-kecamatan', '/get-kecamatan', 'kota');
            setupDropdown('asal-kecamatan', 'asal-kelurahan', '/get-kelurahan', 'kecamatan');

            document.getElementById('asal-kelurahan').addEventListener('change', function() {
                let kel = this.value;
                if (!kel) {
                    document.getElementById('asal-kodepos').value = '';
                    return;
                }
                fetch(`/get-kodepos?kelurahan=${kel}`)
                    .then(res => res.text())
                    .then(data => {
                        document.getElementById('asal-kodepos').value = data;
                    });
            });

            // Setup tujuan dropdowns
            setupDropdown('tujuan-provinsi', 'tujuan-kota', '/get-kota', 'provinsi');
            setupDropdown('tujuan-kota', 'tujuan-kecamatan', '/get-kecamatan', 'kota');
            setupDropdown('tujuan-kecamatan', 'tujuan-kelurahan', '/get-kelurahan', 'kecamatan');

            document.getElementById('tujuan-kelurahan').addEventListener('change', function() {
                let kel = this.value;
                if (!kel) {
                    document.getElementById('tujuan-kodepos').value = '';
                    return;
                }
                fetch(`/get-kodepos?kelurahan=${kel}`)
                    .then(res => res.text())
                    .then(data => {
                        document.getElementById('tujuan-kodepos').value = data;
                    });
            });
        });
    </script>
</x-sneat-layout>
