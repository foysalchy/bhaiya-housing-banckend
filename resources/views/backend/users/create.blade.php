@extends('layouts.backend')

@section('title', ucfirst($mode) . ' User')

@section('content')

<div class="container mt-2">
    <form action="{{ $mode == 'edit' ? route('admin.users.update', $user->id) : route('admin.users.store') }}" method="POST">
        @csrf
        @if($mode == 'edit') @method('PUT') @endif

        <div class="card card-success card-outline mb-4">
            <div class="card-header">
                <div class="card-title">
                    {{ $mode == 'view' ? 'User Profile' : ($mode == 'edit' ? 'Edit Profile' : 'Create New User Account') }}
                </div>
            </div>

            <div class="card-body">
                @php
                    $disabled = ($mode == 'view') ? 'disabled' : '';
                @endphp

                {{-- Name Field --}}
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="name" name="name"
                           value="{{ old('name', $user->name) }}" {{ $disabled }}
                           placeholder="Enter full name" required>
                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                {{-- Email Field --}}
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email"
                           value="{{ old('email', $user->email) }}" {{ $disabled }}
                           placeholder="Enter email address" required>
                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                @if($mode != 'view')
                    <div class="mb-3">
                        <label for="password" class="form-label">
                            Password {{ $mode == 'edit' ? '(Leave blank to keep current)' : '' }}
                        </label>
                        <input type="password" class="form-control" id="password" name="password"
                               placeholder="Minimum 8 characters" {{ $mode == 'create' ? 'required' : '' }}>
                        @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation"
                               name="password_confirmation" placeholder="Re-type password"
                               {{ $mode == 'create' ? 'required' : '' }}>
                    </div>
                @endif

                @if($mode == 'view')
                    <div class="mt-4 p-3 bg-light border rounded">
                        <p class="mb-1"><strong>Created At:</strong> {{ $user->created_at?->format('d M, Y H:i A') }}</p>
                        <p class="mb-0"><strong>Status:</strong>
                            @if($user->email_verified_at)
                                <span class="badge bg-success">Verified</span>
                            @else
                                <span class="badge bg-danger">Pending Verification</span>
                            @endif
                        </p>
                    </div>
                @endif

            </div>

            <div class="card-footer text-end">
                @if(auth()->user()->email === 'system@gmail.com')
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Back to List</a>
                @else
                    <a href="{{ route('home') }}" class="btn btn-secondary">Back to Dashboard</a>
                @endif

                @if($mode != 'view')
                    <button type="submit" class="btn btn-success">
                        {{ $mode == 'edit' ? 'Update User' : 'Create User' }}
                    </button>
                @endif
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
@endpush
