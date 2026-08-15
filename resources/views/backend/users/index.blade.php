@extends('layouts.backend')
@section('title', 'User List')
@section('content')

    <style>
        .table td {
            border-bottom: 1px solid #ccc !important;
        }
    </style>

    <div class="container-fluid mt-4">
        <div class="card card-success card-outline mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="card-title">List of Registered Users</div>
                    <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-plus-circle"></i> Add New User
                    </a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered datatable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Verification Status</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $key => $user)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->email_verified_at)
                                        <span class="badge bg-success">Verified</span>
                                    @else
                                        <span class="badge bg-danger">Not Verified</span>
                                    @endif
                                </td>
                                <td>{{ optional($user->created_at)->format('d M, Y') ?: 'N/A' }}</td>
                                <td>
                                    <!-- View Button -->
                                    <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-info"
                                        title="View">
                                        <i class="bi bi-eye text-white"></i>
                                    </a>

                                    <!-- Edit Button -->
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-primary"
                                        title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <!-- Delete Button -->
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to delete this user?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.datatable').DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "lengthChange": true,
                "language": {
                    "search": "Filter Users:"
                }
            });
        });
    </script>
@endpush
