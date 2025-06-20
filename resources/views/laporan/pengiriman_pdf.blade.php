<!DOCTYPE html>
<html>

<head>
    <title>Laporan Pengiriman</title>
    <style>
        body {
            font-family: sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        h2 {
            text-align: center;
        }
    </style>
</head>

<body>
    <h2>Laporan Pengiriman</h2>
    <table>
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
            @foreach ($pengiriman as $i => $p)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $p->no_resi }}</td>
                    <td>{{ $p->nama_penerima }}</td>
                    <td>{{ $p->alamat_tujuan }}</td>
                    <td>{{ optional($p->statuses->first())->status ?? '-' }}</td>
                    <td>{{ $p->created_at->format('d-m-Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
