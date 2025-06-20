<x-sneat-layout>
    <div class="container">
        <h4 class="fw-bold py-3 mb-4">Manajemen Profil</h4>

        {{-- Alert sukses --}}
        @if (session('status') === 'profile-updated')
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Profil berhasil diperbarui.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @elseif (session('status') === 'password-updated')
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Password berhasil diperbarui.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            {{-- Informasi Profil --}}
            <div class="col-md-6">
                <div class="card mb-4">
                    <h5 class="card-header">Informasi Profil</h5>
                    <div class="card-body">
                        <form method="POST" action="{{ route('profile.update') }}">
                            @csrf
                            @method('patch')

                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ old('name', $user->name) }}" required autofocus>
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control"
                                    value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                                <div class="mb-3">
                                    <p class="text-warning">
                                        Email Anda belum diverifikasi.
                                        <button form="send-verification" class="btn btn-sm btn-outline-primary">
                                            Klik di sini untuk verifikasi ulang.
                                        </button>
                                    </p>
                                </div>
                            @endif

                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Ganti Password --}}
            <div class="col-md-6">
                <div class="card mb-4">
                    <h5 class="card-header">Ganti Password</h5>
                    <div class="card-body">
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            @method('put')

                            <div class="mb-3">
                                <label for="current_password" class="form-label">Password Saat Ini</label>
                                <input type="password" name="current_password" id="current_password"
                                    class="form-control">
                                @error('current_password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password Baru</label>
                                <input type="password" name="password" id="password" class="form-control">
                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control">
                                @error('password_confirmation')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Update Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Hapus Akun --}}
        <div class="card">
            <h5 class="card-header text-danger">Hapus Akun</h5>
            <div class="card-body">
                <p class="mb-3">Setelah akun dihapus, semua data akan hilang secara permanen.</p>

                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                    Hapus Akun
                </button>
            </div>
        </div>

        {{-- Modal Konfirmasi --}}
        <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" action="{{ route('profile.destroy') }}" class="modal-content">
                    @csrf
                    @method('delete')
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteAccountModalLabel">Konfirmasi Hapus Akun</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Masukkan password untuk mengonfirmasi penghapusan akun.</p>
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                        @error('password')
                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus Permanen</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-sneat-layout>
