@foreach ($pengirimans as $pengiriman)
    <tr>
        <td>{{ $pengiriman->id }}</td>
        <td>{{ $pengiriman->nama_pengirim }}</td>
        <td>{{ $pengiriman->alamat_tujuan }}</td>
        <td>
            <span class="badge bg-label-{{ $pengiriman->status == 'selesai' ? 'success' : 'warning' }}">
                {{ ucfirst($pengiriman->status) }}
            </span>
        </td>
        <td>{{ $pengiriman->created_at->format('Y-m-d') }}</td>
        <td>
            <!-- tombol aksi -->
        </td>
    </tr>
@endforeach
