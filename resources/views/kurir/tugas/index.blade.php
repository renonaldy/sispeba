<x-sneat-layout title="Tugas Kurir">
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold mb-4">Tugas Pengiriman Anda</h4>

        <div class="card">
            <div class="table-responsive text-nowrap">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No Resi</th>
                            <th>Nama Penerima</th>
                            <th>Alamat</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pengiriman as $item)
                            <tr>
                                <td>{{ $item->no_resi }}</td>
                                <td>{{ $item->nama_penerima }}</td>
                                <td>{{ $item->alamat }}</td>
                                <td><span class="badge bg-info">{{ ucfirst($item->status) }}</span></td>
                                <td>
                                    @if ($item->status !== 'selesai')
                                        <form action="{{ route('pengiriman.updateStatus', $item->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="selesai">
                                            <button class="btn btn-sm btn-success"
                                                onclick="return confirm('Tandai pengiriman ini sebagai selesai?')">Selesai</button>
                                        </form>
                                    @else
                                        <span class="badge bg-success">Selesai</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada tugas pengiriman.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-sneat-layout>
