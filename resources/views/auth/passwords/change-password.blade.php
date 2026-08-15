@extends('layouts.backend')
@section('title', 'Change Password')
@section('content')

<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            {{-- সাকসেস মেসেজ দেখানোর জন্য --}}
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('user.password.update_logged_in') }}" method="POST">
                @csrf
                <div class="card card-success card-outline mb-4 shadow-sm">
                    <div class="card-header">
                        <div class="card-title">Change Your Password</div>
                    </div>
                    <div class="card-body p-4">

                        <!-- Current Password -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Current Password</label>
                            <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" placeholder="Enter current password" required>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <!-- New Password -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">New Password</label>
                            <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror" placeholder="Enter new password (min 8 chars)" required>
                            @error('new_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirm New Password -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Confirm New Password</label>
                            <input type="password" name="new_password_confirmation" class="form-control" placeholder="Re-type new password" required>
                        </div>

                    </div>
                    <div class="card-footer bg-light text-end py-3">
                        <a href="{{ route('home') }}" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-success px-4">Update Password</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
