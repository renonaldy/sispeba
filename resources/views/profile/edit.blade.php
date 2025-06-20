<x-sneat-layout>
    <div class="container-xxl flex-grow-1 container-p-y">

        {{-- Notifikasi berhasil update profile --}}
        {{-- @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif --}}

        <div class="row">
            <div class="col-md-12">
                <!-- konten form profil, password, dll tetap sama -->
                {{-- <div class="nav-align-top mb-6">
                    <ul class="nav nav-pills flex-column flex-md-row gap-md-0 gap-2">
                        <li class="nav-item">
                            <a class="nav-link active" href="javascript:void(0);">
                                <i class="icon-base bx bx-user icon-sm me-1_5"></i> Account
                            </a>
                        </li>
                    </ul>
                </div> --}}

                <!-- Account Settings Form -->
                <div class="card mb-6">
                    <div class="card-body pt-4">
                        <form id="formAccountSettings" method="POST" action="{{ route('profile.update') }}">
                            @csrf
                            @method('PATCH')
                            <div class="row g-6">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Name</label>
                                    <input class="form-control" type="text" id="name" name="name"
                                        value="{{ old('name', Auth::user()->name) }}" autofocus />
                                    @error('name')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">E-mail</label>
                                    <input class="form-control" type="email" id="email" name="email"
                                        value="{{ old('email', Auth::user()->email) }}" />
                                    @error('email')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mt-6">
                                <button type="submit" class="btn btn-primary me-3">Save changes</button>
                                <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Update Password Section -->

                <div class="card mb-6">
                    <div class="card-body p-6">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">{{ __('Update Password') }}
                        </h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                            {{ __('Ensure your account is using a long, random password to stay secure.') }}
                        </p>

                        {{-- Notifikasi berhasil update password --}}
                        @if (session('password_success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('password_success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
                            @csrf
                            @method('PUT')

                            <div>
                                <label for="current_password" class="form-label">{{ __('Current Password') }}</label>
                                <input id="current_password" name="current_password" type="password"
                                    class="form-control mt-1 block w-full" autocomplete="current-password" />
                                @error('current_password')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="password" class="form-label">{{ __('New Password') }}</label>
                                <input id="password" name="password" type="password"
                                    class="form-control mt-1 block w-full" autocomplete="new-password" />
                                @error('password')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="password_confirmation"
                                    class="form-label">{{ __('Confirm Password') }}</label>
                                <input id="password_confirmation" name="password_confirmation" type="password"
                                    class="form-control mt-1 block w-full" autocomplete="new-password" />
                                @error('password_confirmation')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="flex items-center gap-4 mt-4">
                                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Delete Account Section -->
                <div class="card">
                    <h5 class="card-header">Delete Account</h5>
                    <div class="card-body">
                        <div class="alert alert-warning mb-4">
                            <h5 class="alert-heading mb-1">Are you sure you want to delete your account?</h5>
                            <p class="mb-0">Once you delete your account, there is no going back. Please be certain.
                            </p>
                        </div>
                        <form method="POST" action="{{ route('profile.destroy') }}">
                            @csrf
                            @method('DELETE')
                            <div class="form-check my-3 ms-2">
                                <input class="form-check-input" type="checkbox" name="confirm_delete"
                                    id="confirm_delete" required />
                                <label class="form-check-label" for="confirm_delete">
                                    I confirm my account deletion
                                </label>
                            </div>
                            <button type="submit" class="btn btn-danger deactivate-account"
                                onclick="return confirm('This action is irreversible. Are you sure?')">
                                Delete Account
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-sneat-layout>
