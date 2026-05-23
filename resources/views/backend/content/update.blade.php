@extends('layouts.backend')
@section('title', 'Edit'.' '.ucwords(str_replace(['-', '_'], ' ', $type)))
@section('content')

<div class="container mt-2">
<form action="{{ route('content.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" value="{{ $content->id }}">
    <input type="hidden" name="type" value="{{ $type }}">

    <div class="card card-success card-outline mb-4">
        <div class="card-header">
            <div class="card-title">Edit {{ ucwords(str_replace(['-', '_'], ' ', $type)) }}</div>
        </div>
        <div class="card-body">

            @foreach($contents[$type] as $field => $data)
                <div class="mb-3">
                    <label for="{{ $field }}" class="form-label">{{ $data['label'] }}</label>
                    @php $isRequired = $data['required'] ? 'required' : ''; @endphp

                    @if($field == 'img_path')
                        @if($content->$field)
                            <div class="mb-2 d-flex align-items-center gap-2" id="thumbWrapper">
                                <img width="100px" src="{{ asset('/') }}{{ $content->$field }}"
                                    class="border rounded p-1" id="thumbCurrent">
                                <div class="form-check mb-0">
                                    <input class="form-check-input border-danger" type="checkbox"
                                        name="delete_img_path" id="deleteThumb" value="1"
                                        onchange="toggleDeleteShade('thumbCurrent', this)">
                                    <label class="form-check-label text-danger small" for="deleteThumb">Delete</label>
                                </div>
                            </div>
                        @endif
                        <input type="file" class="form-control" id="{{ $field }}" name="{{ $field }}"
                            onchange="previewNewImage(this, 'thumbNewPreview')">
                        <div id="thumbNewPreview" class="mt-2 d-flex gap-2 flex-wrap"></div>

                    @elseif($field == 'video_path')
                        @if($content->$field)
                            <div class="mb-2" id="videoWrapper">
                                <video width="150px" controls id="videoCurrent" class="border rounded p-1">
                                    <source src="{{ asset('/') }}{{ $content->$field }}">
                                </video>
                                <div class="form-check mt-1">
                                    <input class="form-check-input border-danger" type="checkbox"
                                        name="delete_video" id="deleteVideo" value="1"
                                        onchange="toggleDeleteShade('videoCurrent', this)">
                                    <label class="form-check-label text-danger small" for="deleteVideo">Delete Video</label>
                                </div>
                            </div>
                        @endif
                        <input type="file" class="form-control" id="{{ $field }}" name="{{ $field }}"
                            onchange="previewNewVideo(this)">
                        <div id="videoNewPreview" class="mt-2"></div>

                    @elseif($field == 'img_paths')
                        @if($content->$field)
                            @php
                                $images = is_array($content->$field)
                                    ? $content->$field
                                    : json_decode($content->$field, true) ?? [];
                            @endphp
                            <div class="mb-2 d-flex gap-2 flex-wrap" id="multiImgWrapper">
                                @foreach($images as $i => $img)
                                <div class="text-center" id="imgItem{{ $i }}">
                                    <img width="100px" src="{{ asset('/') }}{{ $img }}"
                                        class="border rounded p-1" id="existingImg{{ $i }}">
                                    <div class="form-check mt-1">
                                        <input class="form-check-input border-danger" type="checkbox"
                                            name="delete_images[]" value="{{ $i }}" id="delImg{{ $i }}"
                                            onchange="toggleDeleteShade('existingImg{{ $i }}', this)">
                                        <label class="form-check-label text-danger small" for="delImg{{ $i }}">Delete</label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <small class="text-muted d-block mb-2">New uploads will be appended to remaining images.</small>
                        @endif
                        <input type="file" multiple class="form-control" id="{{ $field }}"
                            name="{{ $field }}[]" {{ $isRequired }}
                            onchange="previewMultiNew(this)">
                        <div id="multiNewPreview" class="mt-2 d-flex gap-2 flex-wrap"></div>

                    @elseif($field == 'parent')
                        <select name="parent_id" id="parent_id" class="form-select" {{ $isRequired }}>
                            <option value="">-- Select --</option>
                            @if($type == 'gallery')
                                @foreach(App\Models\Content::where('type', 'albums')->get() as $alb)
                                    <option {{ $content->parent_id == $alb->id ? 'selected' : '' }} value="{{ $alb->id }}">{{ $alb->title }}</option>
                                @endforeach
                            @elseif($type == 'doctors')
                                @foreach(App\Models\Content::where('type', 'department-sliders')->where('status', 1)->get() as $dept)
                                    <option {{ $content->parent_id == $dept->id ? 'selected' : '' }} value="{{ $dept->id }}">{{ $dept->title }}</option>
                                @endforeach
                            @endif
                        </select>

                    @elseif($field == 'short')
                        <textarea class="form-control" id="{{ $field }}" name="{{ $field }}" {{ $isRequired }}>{{ $content->$field }}</textarea>

                    @elseif($field == 'status')
                        <select name="{{ $field }}" id="{{ $field }}" class="form-select" {{ $isRequired }}>
                            <option {{ $content->$field == 1 ? 'selected' : '' }} value="1">Active</option>
                            <option {{ $content->$field == 0 ? 'selected' : '' }} value="0">Inactive</option>
                        </select>

                    @elseif($field == 'start_date' || $field == 'end_date')
                        <input type="datetime-local" class="form-control" id="{{ $field }}"
                            name="{{ $field }}" value="{{ $content->$field }}" {{ $isRequired }}>

                    @elseif($field == 'url')
                        <textarea class="form-control" id="{{ $field }}" name="{{ $field }}" rows="3" {{ $isRequired }}>{{ $content->$field }}</textarea>

                    @elseif($field == 'body' || $field == 'body_2' || $field == 'body_3' || $field == 'body_4' || $field == 'meta_description')
                        <textarea class="editor form-control" name="{{ $field }}" id="{{ $field }}" rows="4" {{ $isRequired }}>{!! $content->$field !!}</textarea>

                    @else
                        <input type="text" class="form-control" value="{{ $content->$field }}"
                            id="{{ $field }}" name="{{ $field }}" {{ $isRequired }}>
                    @endif
                </div>
            @endforeach

        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-success">Update</button>
        </div>
    </div>
</form>

<style>
    .img-delete-shade {
        opacity: 0.3;
        outline: 2px solid red;
        border-radius: 4px;
    }
    .new-preview-wrap {
        position: relative;
        text-align: center;
    }
    .new-preview-wrap .remove-btn {
        position: absolute;
        top: -6px;
        right: -6px;
        background: red;
        color: white;
        border: none;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        font-size: 12px;
        line-height: 18px;
        cursor: pointer;
        padding: 0;
    }
</style>


</div>

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
<script src="{{ asset('backend/summernote/summernote.js') }}"></script>
<link rel="stylesheet" href="{{ asset('backend/summernote/summernote.css') }}">
<script>
 $(document).ready(function() {
        $('.editor').summernote({
            height: 300,
            resizeable: true, // summernote built-in resize
            callbacks: {
                onKeyup: function(e) {
                    updateTagInfo(e);
                },
                onMouseup: function(e) {
                    updateTagInfo(e);
                },
            }
        });
    });

         const $tooltip = $('<div id="tag-tooltip" style="' +
            'position:fixed;' +
            'background:#333;' +
            'color:#fff;' +
            'padding:3px 8px;' +
            'border-radius:4px;' +
            'font-size:11px;' +
            'font-family:monospace;' +
            'pointer-events:none;' +
            'z-index:99999;' +
            'display:none;' +
            '"></div>');
        $('body').append($tooltip);

        function updateTagInfo(e) {
            const selection = window.getSelection();
            if (!selection || selection.rangeCount === 0) return;

            let node = selection.anchorNode;
            if (node && node.nodeType === Node.TEXT_NODE) {
                node = node.parentNode;
            }

            let tagName = null;
            let current = node;

            while (current && current !== document) {
                const tag = current.tagName ? current.tagName.toLowerCase() : '';
                if (['h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p', 'blockquote', 'li'].includes(tag)) {
                    tagName = tag.toUpperCase();
                    break;
                }
                current = current.parentNode;
            }

            if (!tagName) {
                $tooltip.hide();
                return;
            }

            const x = e.clientX + 10;
            const y = e.clientY - 30;

            $tooltip
                .html(`&lt;${tagName}&gt;`)
                .css({
                    left: x + 'px',
                    top: y + 'px'
                })
                .show();

            clearTimeout(window._tagTooltipTimer);
            window._tagTooltipTimer = setTimeout(() => $tooltip.hide(), 2000);
        }
</script>
<script>
    // Shade existing image/video when delete checkbox is checked
    function toggleDeleteShade(elemId, checkbox) {
        const el = document.getElementById(elemId);
        if (!el) return;
        el.classList.toggle('img-delete-shade', checkbox.checked);
    }

    // Preview single new image with remove button
    function previewNewImage(input, previewId) {
        const preview = document.getElementById(previewId);
        preview.innerHTML = '';
        if (!input.files || !input.files[0]) return;

        const wrap = document.createElement('div');
        wrap.className = 'new-preview-wrap';

        const img = document.createElement('img');
        img.src = URL.createObjectURL(input.files[0]);
        img.style.cssText = 'height:80px; width:100px; object-fit:cover; border-radius:4px; border:1px solid #dee2e6;';

        const btn = document.createElement('button');
        btn.className = 'remove-btn';
        btn.type = 'button';
        btn.innerHTML = '&times;';
        btn.onclick = () => {
            input.value = '';
            preview.innerHTML = '';
        };

        wrap.appendChild(img);
        wrap.appendChild(btn);
        preview.appendChild(wrap);
    }

    // Preview new video with remove button
    function previewNewVideo(input) {
        const preview = document.getElementById('videoNewPreview');
        preview.innerHTML = '';
        if (!input.files || !input.files[0]) return;

        const wrap = document.createElement('div');
        wrap.className = 'new-preview-wrap d-inline-block';

        const video = document.createElement('video');
        video.src = URL.createObjectURL(input.files[0]);
        video.controls = true;
        video.style.cssText = 'height:100px; border-radius:4px; border:1px solid #dee2e6;';

        const btn = document.createElement('button');
        btn.className = 'remove-btn';
        btn.type = 'button';
        btn.innerHTML = '&times;';
        btn.onclick = () => {
            input.value = '';
            preview.innerHTML = '';
        };

        wrap.appendChild(video);
        wrap.appendChild(btn);
        preview.appendChild(wrap);
    }

    // Preview multiple new images — each with individual remove button
    function previewMultiNew(input) {
        const preview = document.getElementById('multiNewPreview');
        preview.innerHTML = '';

        // Convert FileList to mutable array
        let files = Array.from(input.files);

        function render() {
            preview.innerHTML = '';
            files.forEach((file, i) => {
                const wrap = document.createElement('div');
                wrap.className = 'new-preview-wrap';

                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.style.cssText = 'height:80px; width:100px; object-fit:cover; border-radius:4px; border:1px solid #dee2e6;';

                const btn = document.createElement('button');
                btn.className = 'remove-btn';
                btn.type = 'button';
                btn.innerHTML = '&times;';
                btn.onclick = () => {
                    files.splice(i, 1);

                    // Rebuild DataTransfer to update input.files
                    const dt = new DataTransfer();
                    files.forEach(f => dt.items.add(f));
                    input.files = dt.files;

                    render();
                };

                wrap.appendChild(img);
                wrap.appendChild(btn);
                preview.appendChild(wrap);
            });
        }

        render();
    }
</script>
@endpush
