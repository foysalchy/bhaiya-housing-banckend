@extends('layouts.backend')
@section('title', 'List' . ' ' . ucwords(str_replace(['-', '_'], ' ', $type)))
@section('content')

    <style>
        .table td {
            border-bottom: 1px solid #ccc !important;
        }
    </style>

    <div class="container mt-2">
        <div class="card card-success card-outline mb-4">
            <div class="card-header">
                <div class="card-title">List of {{ ucwords(str_replace(['-', '_'], ' ', $type)) }}</div>
            </div>
            <div class="card-body">
                <table class="table table-bordered datatable">
                    <thead>
                        <tr>
                            <th style="width: 30px;"></th>
                            <th>#</th>
                            @foreach($contents[$type] as $field => $data)
                                @if(!in_array($field, ['body', 'body_2', 'body_3', 'body_4', 'img_paths', 'extra', 'video_path', 'extra_title_body_4', 'status_body_4']))
                                    <th>{{ $data['label'] }}</th>
                                @endif
                            @endforeach
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="sortable-rows">
                        @foreach($datas as $key => $item)
                            <tr data-id="{{ $item->id }}">
                                <td class="drag-handle text-center" style="cursor: grab;">
                                    <i class="bi bi-grip-vertical"></i>
                                </td>
                                <td>{{ ++$key }}</td>
                                @foreach($contents[$type] as $field => $data)
                                    @if(!in_array($field, ['body', 'body_2', 'body_3', 'body_4', 'img_paths', 'extra', 'video_path', 'extra_title_body_4', 'status_body_4']))

                                        @if($field == 'img_path')
                                            <td><img width="100px" src="{{ asset('/') }}{{ $item->$field }}" alt=""></td>

                                        @elseif($field == 'video_path')
                                            <td>
                                                @if($item->$field)
                                                    <video width="150px" controls>
                                                        <source src="{{ asset('/') }}{{ $item->$field }}">
                                                    </video>
                                                @else
                                                    <span class="text-muted">No video</span>
                                                @endif
                                            </td>

                                        @elseif($field == 'parent')
                                            <td>
                                                @if($type == 'doctors')
                                                    {{ App\Models\Content::find($item->parent_id)?->title ?? 'N/A' }}
                                                @elseif($type == 'gallery')
                                                    {{ App\Models\Content::find($item->parent_id)?->title ?? 'N/A' }}
                                                @else
                                                    {{ $item->$field }}
                                                @endif
                                            </td>

                                        @elseif($field == 'status')
                                            <td>
                                                @if($item->status == 1)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-danger">Inactive</span>
                                                @endif
                                            </td>

                                        @else
                                        <td>{{ Str::limit($item->$field, 50) }}</td> @endif

                                    @endif
                                @endforeach

                                <td>
                                    @if($type == 'albums')
                                        <a href="{{ route('content.create', 'gallery') }}?parent={{ $item->id }}"
                                            class="btn btn-sm btn-success">Add</a>
                                    @endif
                                    @if($type == 'department-sliders')
                                        <a href="{{ route('content.create', 'doctors') }}?parent={{ $item->id }}"
                                            class="btn btn-sm btn-success">Add Doctor</a>
                                    @endif
                                    <a href="{{ route('content.edit', [$type, $item->id]) }}"
                                        class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ route('content.destroy', [$type, $item->id]) }}" method="POST"
                                        class="d-inline">
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
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
    <script>
    $(document).ready(function() {
        // DataTable Initialization
        $('.datatable').DataTable({
            "paging": false,
            "ordering": false, // এটি অবশ্যই false হতে হবে
            "searching": true
        });

        // Sortable logic
        const tbody = document.getElementById('sortable-rows');
        new Sortable(tbody, {
            handle: '.drag-handle',
            animation: 150,
            onEnd: function() {
                let order = [];
                $('#sortable-rows tr').each(function() {
                    order.push($(this).attr('data-id'));
                });

                $.ajax({
                    url: "{{ route('content.reorder') }}",
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        order: order
                    },
                    success: function(response) {
                        console.log('Order updated!');
                    }
                });
            }
        });
    });
</script>

@endpush
