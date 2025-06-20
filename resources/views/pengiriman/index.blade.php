<x-sneat-layout>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Data Pengiriman</h5>
            <a href="{{ route('pengiriman.create') }}" class="btn btn-primary">+ Tambah Pengiriman</a>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No Resi</th>
                        <th>Nama Penerima</th>
                        <th>Nama Pengirim</th>
                        <th>Alamat</th>
                        {{-- <th>Kota</th> --}}
                        {{-- <th>Kode Pos</th> --}}
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($pengirimans as $pengiriman)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $pengiriman->no_resi }}</td>
                            <td>{{ $pengiriman->nama_penerima }}</td>
                            <td>{{ $pengiriman->nama_pengirim }}</td>
                            <td>{{ $pengiriman->alamat_lengkap }}</td>
                            {{-- <td>{{ $pengiriman->kota }}</td> --}}
                            {{-- <td>{{ $pengiriman->kode_pos }}</td> --}}
                            <td>
                                @php
                                    $badgeClass = match ($pengiriman->status) {
                                        'proses' => 'bg-warning',
                                        'dikirim' => 'bg-info',
                                        'selesai' => 'bg-success',
                                        default => 'bg-secondary',
                                    };
                                @endphp

                                @if (in_array(auth()->user()->role, ['admin', 'kurir']))
                                    <div class="dropdown">
                                        <span class="badge {{ $badgeClass }} dropdown-toggle" role="button"
                                            id="statusDropdown{{ $pengiriman->id }}" data-bs-toggle="dropdown"
                                            aria-expanded="false" style="cursor:pointer;">
                                            {{ ucfirst($pengiriman->status) }}
                                        </span>
                                        <ul class="dropdown-menu"
                                            aria-labelledby="statusDropdown{{ $pengiriman->id }}">
                                            <form action="{{ route('pengiriman.updateStatus', $pengiriman->id) }}"
                                                method="POST" id="formStatus{{ $pengiriman->id }}">
                                                @csrf
                                                @method('PATCH')
                                                <li>
                                                    <button type="submit" name="status" value="proses"
                                                        class="dropdown-item {{ $pengiriman->status == 'proses' ? 'active' : '' }}">Proses</button>
                                                </li>
                                                <li>
                                                    <button type="submit" name="status" value="dikirim"
                                                        class="dropdown-item {{ $pengiriman->status == 'dikirim' ? 'active' : '' }}">Dikirim</button>
                                                </li>
                                                <li>
                                                    <button type="submit" name="status" value="selesai"
                                                        class="dropdown-item {{ $pengiriman->status == 'selesai' ? 'active' : '' }}">Selesai</button>
                                                </li>
                                            </form>
                                        </ul>
                                    </div>
                                @else
                                    <span class="badge {{ $badgeClass }}">
                                        {{ ucfirst($pengiriman->status) }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if (auth()->user()->role === 'admin')
                                    <a href="{{ route('pengiriman.edit', $pengiriman->id) }}"
                                        class="btn btn-sm btn-warning">Edit</a>

                                    <form action="{{ route('pengiriman.destroy', $pengiriman->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                @else
                                    <span>-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data pengiriman.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-sneat-layout>
