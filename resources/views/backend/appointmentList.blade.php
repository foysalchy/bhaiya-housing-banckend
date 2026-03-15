@extends('layouts.backend')
@section('content')

<style>
    .table td { border-bottom: 1px solid #ccc !important; }
</style>

<div class="container mt-2">
    <div class="card card-success card-outline mb-4">
        <div class="card-body">
            <table class="table table-bordered datatable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Department</th>
                        <th>Doctor</th>
                        <th>Date</th>
                        <th>Message</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($appointments as $appt)
                        <tr>
                            <td>{{ $appt->full_name }}</td>
                            <td>{{ $appt->email }}</td>
                            <td>{{ $appt->mobile_number }}</td>
                            <td>{{ \App\Models\Content::find($appt->department_id)?->title ?? 'N/A' }}</td>
                            <td>{{ \App\Models\Content::find($appt->doctor_id)?->name ?? 'N/A' }}</td>
                            <td>{{ $appt->appointment_date }}</td>
                            <td>{{ $appt->message }}</td>
                            <td>
                                <form action="{{ route('appointments.destroy', $appt->id) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('Are you sure?')">
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
            "paging": true, "searching": true, "ordering": true, "info": true, "lengthChange": true,
        });
    });
</script>
@endpush