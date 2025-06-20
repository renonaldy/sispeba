<x-sneat-layout title="Lupa Password">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Lupa Password</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-4 text-muted">
                            Masukkan alamat email Anda dan kami akan mengirimkan tautan untuk mengatur ulang password.
                        </p>

                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autofocus>

                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">
                                    Kirim Link Reset Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <a href="{{ route('login') }}" class="text-decoration-none">
                        ← Kembali ke Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-sneat-layout>
