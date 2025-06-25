<x-sneat-layout title="Rekening Pembayaran">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Rekening Pembayaran</h5>
            <a href="{{ route('admin.rekening.create') }}" class="btn btn-primary">+ Tambah Rekening</a>
        </div>

        <div class="card-body">
            <form method="GET" class="mb-3">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama / nomor / jenis..."
                        value="{{ request('search') }}">
                    <button class="btn btn-outline-primary" type="submit">Cari</button>
                </div>
            </form>

            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Atas Nama</th>
                            <th>No Rekening</th>
                            <th>Jenis Bank</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rekening as $r)
                            <tr>
                                <td>{{ $r->id }}</td>
                                <td>{{ $r->atas_nama }}</td>
                                <td>{{ $r->nomor_rekening }}</td>
                                <td>{{ ucfirst($r->nama_bank) }}</td>
                                <td>
                                    <a href="{{ route('admin.rekening.edit', $r) }}"
                                        class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('admin.rekening.destroy', $r) }}" method="POST"
                                        class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Hapus rekening ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Data tidak ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $rekening->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</x-sneat-layout>
