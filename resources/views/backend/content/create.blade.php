@extends('layouts.backend')
@section('title', 'Create'.' '.ucwords(str_replace(['-', '_'], ' ', $type)))
@section('content')

<div class="container mt-2">
    <form action="{{ route('content.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="type" value="{{ $type }}">

        <div class="card card-success card-outline mb-4">
            <div class="card-header">
                <div class="card-title">Create New {{ ucwords(str_replace(['-', '_'], ' ', $type)) }}</div>
            </div>
            <div class="card-body">

                @foreach($contents[$type] as $field => $data)
                    <div class="mb-3">
                        <label for="{{ $field }}" class="form-label">{{ $data['label'] }}</label>
                        @php $isRequired = $data['required'] ? 'required' : ''; @endphp

                        @if($field == 'img_path')
                            <input type="file" class="form-control" id="{{ $field }}" name="{{ $field }}" {{ $isRequired }}>

                        @elseif($field == 'img_paths')
                            <input type="file" multiple class="form-control" id="{{ $field }}" name="{{ $field }}[]" {{ $isRequired }}>

                        @elseif($field == 'video_path')
                            <input type="file" class="form-control" id="{{ $field }}" name="{{ $field }}" {{ $isRequired }}>

                        @elseif($field == 'parent')
                            <select name="parent_id" id="parent_id" class="form-select" {{ $isRequired }}>
                                <option value="">-- Select --</option>
                                @if($type == 'gallery')
                                    @foreach(App\Models\Content::where('type', 'albums')->get() as $alb)
                                        <option {{ (isset($_GET['parent']) && $_GET['parent'] == $alb->id) ? 'selected' : '' }} value="{{ $alb->id }}">{{ $alb->title }}</option>
                                    @endforeach
                                @elseif($type == 'doctors')
                                    @foreach(App\Models\Content::where('type', 'department-sliders')->where('status', 1)->get() as $dept)
                                        <option {{ (isset($_GET['parent']) && $_GET['parent'] == $dept->id) ? 'selected' : '' }} value="{{ $dept->id }}">{{ $dept->title }}</option>
                                    @endforeach
                                @endif
                            </select>

                        @elseif($field == 'short')
                            <textarea class="form-control" id="{{ $field }}" name="{{ $field }}" {{ $isRequired }}></textarea>

                        @elseif($field == 'status')
                            <select name="{{ $field }}" id="{{ $field }}" class="form-select" {{ $isRequired }}>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>

                        @elseif($field == 'start_date' || $field == 'end_date')
                            <input type="datetime-local" class="form-control" id="{{ $field }}" name="{{ $field }}" {{ $isRequired }}>

                        @elseif($field == 'url')
                            <textarea class="form-control" id="{{ $field }}" name="{{ $field }}" rows="3" {{ $isRequired }}></textarea>

                        @elseif($field == 'body' || $field == 'body_2' || $field == 'body_3' || $field == 'body_4' || $field == 'meta_description')
                            <textarea class="editor form-control" name="{{ $field }}" id="{{ $field }}" rows="4" {{ $isRequired }}></textarea>

                        @else
                            <input type="text" class="form-control" id="{{ $field }}" name="{{ $field }}" {{ $isRequired }}>
                        @endif
                    </div>
                @endforeach

            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
<script src="{{ asset('backend/summernote/summernote.js') }}"></script>
<link rel="stylesheet" href="{{ asset('backend/summernote/summernote.css') }}">
<script>
    $(document).ready(function() {
        $('.editor').summernote();
    });
</script>
@endpush