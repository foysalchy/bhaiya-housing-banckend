@extends('layouts.backend')
@section('title', 'List of Job Applications')
@section('content')

<style>
    .table td {
        vertical-align: middle !important;
        border-bottom: 1px solid #ccc !important;
    }
</style>

<div class="container mt-2">
    <!-- Success Message Alert -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
    </div>
    @endif

    <div class="card card-success card-outline mb-4">
        <div class="card-header">
            <div class="card-title">List of Job Applications</div>
        </div>
        <div class="card-body">
            <table class="table table-bordered datatable">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Job Title / Role</th>
                        <th>Applicant Name</th>
                        <th>Mobile Number</th>
                        <th>Email Address</th>
                        <th>Subject</th>
                        <th>Resume (PDF)</th>
                        <th>Applied Date</th>
                        <th style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($datas as $key => $item)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <!-- Job Title (Content relationship থেকে) -->
                        <td>
                            <strong>{{ $item->content?->title ?? 'N/A' }}</strong>
                        </td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->phone }}</td>
                        <td>
                            <a href="mailto:{{ $item->email }}">{{ $item->email }}</a>
                        </td>
                        <td>{{ Str::limit($item->subject, 40) }}</td>
                        <!-- Resume Link -->
                        <td>
                            @if($item->resume)
                            <a href="{{ asset($item->resume) }}" target="_blank" class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-file-pdf"></i> View PDF
                            </a>
                            @else
                            <span class="text-muted">No Resume</span>
                            @endif
                        </td>
                        <!-- Applied Time -->
                        <td>{{ $item->created_at?->format('d M, Y h:i A') ?? 'N/A' }}</td>
                        <!-- Delete Action -->
                        <td>
                            <!-- Route টি আপনার web.php রুট নাম অনুযায়ী পরিবর্তন করে নিবেন -->
                            <form action="{{ route('job.applications.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this application?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
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
    $(document).ready(function() {
        $('.datatable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "lengthChange": true,
        });
    });
</script>
@endpush