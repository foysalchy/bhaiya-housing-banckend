@extends('layouts.backend')
@section('content')

<style>
       .table td{
              border-bottom:1px solid #ccc !important;
       }
</style>

    <div class="container mt-2">
        <div class="card card-success card-outline mb-4">

            <div class="card-body">
                <table class="table table-bordered datatable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone Code</th>
                            <th>Phone</th>
                            <th>Message</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contacts as $contact)
                            <tr>
                                <td>{{ $contact->name }}</td>
                                <td>{{ $contact->email }}</td>
                                <td>{{ $contact->phone_code }}</td>
                                <td>{{ $contact->phone }}</td>
                                <td>{{ $contact->message }}</td>

                                <td>
                                <form action="{{ route('contacts.toggle-read', $contact->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    @if($contact->is_read)
                                        <button type="submit" class="btn btn-sm btn-outline-secondary" title="Mark as Unread">
                                            Read
                                        </button>
                                    @else
                                        <button type="submit" class="btn btn-sm btn-info" title="Mark as Read">
                                            Mark Read
                                        </button>
                                    @endif
                                </form>

                                <form action="{{ route('contacts.destroy', $contact->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
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
