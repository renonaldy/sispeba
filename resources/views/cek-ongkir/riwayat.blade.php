<x-sneat-layout>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">Riwayat Ongkir</h4>

        <div class="card">
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Asal</th>
                            <th>Tujuan</th>
                            <th>Berat (kg)</th>
                            <th>Jarak (km)</th>
                            <th>Ongkir (Rp)</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($riwayat as $row)
                            <tr>
                                <td>{{ $row->asal }}</td>
                                <td>{{ $row->tujuan }}</td>
                                <td>{{ $row->berat }}</td>
                                <td>{{ $row->jarak }}</td>
                                <td>{{ number_format($row->ongkir, 0, ',', '.') }}</td>
                                <td>{{ $row->created_at->format('d-m-Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="m-3">
                    {{ $riwayat->links() }}
                </div>
            </div>
        </div>
    </div>
</x-sneat-layout>
