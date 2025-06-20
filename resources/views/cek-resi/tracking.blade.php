<x-sneat-layout title="Tracking Pengiriman">
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Pengiriman /</span> Tracking
        </h4>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Nomor Resi: {{ $pengiriman->no_resi }}</h5>
                <p><strong>Nama Penerima:</strong> {{ $pengiriman->nama_penerima }}</p>
                <p><strong>Alamat:</strong> {{ $pengiriman->alamat_tujuan }}</p>

                <hr>

                <h6 class="fw-semibold mb-3">Status Pengiriman</h6>

                <ul class="timeline" id="timeline">
                    @foreach ($statuses as $status)
                        <li class="timeline-item {{ $loop->last ? 'timeline-item-success' : '' }}">
                            <span class="timeline-point {{ $loop->last ? 'timeline-point-success' : '' }}"></span>
                            <div class="timeline-event">
                                <h6 class="timeline-title text-capitalize">{{ $status->status }}</h6>
                                <small
                                    class="text-muted">{{ \Carbon\Carbon::parse($status->waktu_status)->format('d-m-Y H:i') }}</small>
                            </div>
                        </li>
                    @endforeach
                </ul>

                {{-- ✅ Tambahan Form Update Status untuk Admin & Kurir --}}
                @role(['admin', 'kurir'])
                    <hr>
                    <h6 class="fw-semibold mb-3">Ubah Status Pengiriman</h6>
                    <form method="POST" action="{{ route('pengiriman.updateStatus', $pengiriman->id) }}">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label for="status" class="form-label">Ubah Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="pickup" {{ $pengiriman->status == 'pickup' ? 'selected' : '' }}>Pickup
                                </option>
                                <option value="transit" {{ $pengiriman->status == 'transit' ? 'selected' : '' }}>Transit
                                </option>
                                <option value="delivered" {{ $pengiriman->status == 'delivered' ? 'selected' : '' }}>
                                    Delivered</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="lokasi_terakhir" class="form-label">Lokasi Terakhir</label>
                            <input type="text" name="lokasi_terakhir" class="form-control" required
                                value="{{ $pengiriman->lokasi_terakhir }}">
                        </div>

                        <button class="btn btn-primary" type="submit">Update Status</button>
                    </form>
                @endrole

                <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
                <script>
                    Pusher.logToConsole = true;

                    const resi = "{{ $pengiriman->no_resi }}";

                    const pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
                        cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
                        forceTLS: true
                    });

                    const channel = pusher.subscribe('tracking.' + resi);
                    channel.bind('App\\Events\\TrackingUpdated', function(data) {
                        const timeline = document.getElementById('timeline');
                        const item = document.createElement('li');
                        item.className = 'timeline-item timeline-item-success';
                        item.innerHTML = `
                            <span class="timeline-point timeline-point-success"></span>
                            <div class="timeline-event">
                                <h6 class="timeline-title text-capitalize">${data.status}</h6>
                                <small class="text-muted">${formatWaktu(data.waktu_status)}</small>
                            </div>
                        `;
                        timeline.appendChild(item);
                    });

                    function formatWaktu(datetimeStr) {
                        const date = new Date(datetimeStr);
                        return `${String(date.getDate()).padStart(2, '0')}-${String(date.getMonth() + 1).padStart(2, '0')}-${date.getFullYear()} ${String(date.getHours()).padStart(2, '0')}:${String(date.getMinutes()).padStart(2, '0')}`;
                    }
                </script>

                <a href="{{ route('cek-resi.index') }}" class="btn btn-outline-secondary mt-4">Cek Resi Lain</a>
            </div>
        </div>

    </div>
</x-sneat-layout>
