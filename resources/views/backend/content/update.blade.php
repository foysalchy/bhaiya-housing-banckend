@extends('layouts.backend')
@section('title', 'Edit' . ' ' . ucwords(str_replace(['-', '_'], ' ', $type)))
@section('content')

    <div class="container mt-2">
        <form action="{{ route('content.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $content->id }}">
            <input type="hidden" name="type" value="{{ $type }}">

            <div class="card card-success card-outline mb-4">
                <div class="card-header">
                    <h3 class="card-title">Edit {{ ucwords(str_replace(['-', '_'], ' ', $type)) }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('content.index', $type) }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">

                    @php
                        $slugTypes = ['project', 'news', 'events', 'blogs', 'meta_info'];
                    @endphp
                    @php
                        $extraData = json_decode($content->extra, true) ?? [];
                    @endphp
                    @foreach ($contents[$type] as $field => $data)
                        <div class="mb-3">
                            <label for="{{ $field }}" class="form-label">{{ $data['label'] }}</label>
                            @php $isRequired = $data['required'] ? 'required' : ''; @endphp
                            @if ($field == 'title')
                                <div class="{{ in_array($type, $slugTypes) ? 'input-group' : '' }}">
                                    <input type="text" class="form-control" id="title" name="title"
                                        value="{{ $content->title }}" {{ $isRequired }}>

                                    @if (in_array($type, $slugTypes))
                                        <button type="button" class="btn btn-outline-secondary" onclick="generateSlug()">
                                            <i class="bi bi-link-45deg"></i> Generate Slug
                                        </button>
                                    @endif
                                </div>
                            @elseif($field == 'name')
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ $content->name }}" {{ $isRequired }}
                                    placeholder="{{ in_array($type, $slugTypes) ? 'url-friendly-slug' : 'Enter ' . $data['label'] }}">

                                @if (in_array($type, $slugTypes))
                                    <small class="text-muted">This is the URL slug. Changing this will change the page
                                        link.</small>
                                @endif
                            @elseif($field == 'img_path')
                                @if ($content->$field)
                                    <div class="mb-2 d-flex align-items-center gap-2" id="thumbWrapper">
                                        <img width="100px" src="{{ asset('/') }}{{ $content->$field }}"
                                            class="border rounded p-1" id="thumbCurrent">
                                        <div class="form-check mb-0">
                                            <input class="form-check-input border-danger" type="checkbox"
                                                name="delete_img_path" id="deleteThumb" value="1"
                                                onchange="toggleDeleteShade('thumbCurrent', this)">
                                            <label class="form-check-label text-danger small"
                                                for="deleteThumb">Delete</label>
                                        </div>
                                    </div>
                                @endif
                                <input type="file" class="form-control" id="{{ $field }}"
                                    name="{{ $field }}" onchange="previewNewImage(this, 'thumbNewPreview')">
                                <div id="thumbNewPreview" class="mt-2 d-flex gap-2 flex-wrap"></div>
                            @elseif($field == 'video_path')
                                @if ($content->$field)
                                    <div class="mb-2" id="videoWrapper">
                                        <video width="150px" controls id="videoCurrent" class="border rounded p-1">
                                            <source src="{{ asset('/') }}{{ $content->$field }}">
                                        </video>
                                        <div class="form-check mt-1">
                                            <input class="form-check-input border-danger" type="checkbox"
                                                name="delete_video" id="deleteVideo" value="1"
                                                onchange="toggleDeleteShade('videoCurrent', this)">
                                            <label class="form-check-label text-danger small" for="deleteVideo">Delete
                                                Video</label>
                                        </div>
                                    </div>
                                @endif
                                <input type="file" class="form-control" id="{{ $field }}"
                                    name="{{ $field }}" onchange="previewNewVideo(this)">
                                <div id="videoNewPreview" class="mt-2"></div>
                            @elseif($field == 'img_paths')
                                @if ($content->$field)
                                    @php
                                        $images = is_array($content->$field)
                                            ? $content->$field
                                            : json_decode($content->$field, true) ?? [];
                                    @endphp
                                    <div class="mb-2 d-flex gap-2 flex-wrap" id="multiImgWrapper">
                                        @foreach ($images as $i => $img)
                                            <div class="text-center" id="imgItem{{ $i }}">
                                                <img width="100px" src="{{ asset('/') }}{{ $img }}"
                                                    class="border rounded p-1" id="existingImg{{ $i }}">
                                                <div class="form-check mt-1">
                                                    <input class="form-check-input border-danger" type="checkbox"
                                                        name="delete_images[]" value="{{ $i }}"
                                                        id="delImg{{ $i }}"
                                                        onchange="toggleDeleteShade('existingImg{{ $i }}', this)">
                                                    <label class="form-check-label text-danger small"
                                                        for="delImg{{ $i }}">Delete</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <small class="text-muted d-block mb-2">New uploads will be appended to remaining
                                        images.</small>
                                @endif
                                <input type="file" multiple class="form-control" id="{{ $field }}"
                                    name="{{ $field }}[]" {{ $isRequired }} onchange="previewMultiNew(this)">
                                <div id="multiNewPreview" class="mt-2 d-flex gap-2 flex-wrap"></div>
                            @elseif($field == 'parent')
                                <select name="parent_id" id="parent_id" class="form-select" {{ $isRequired }}>
                                    <option value="">-- Select --</option>
                                    @if ($type == 'gallery')
                                        @foreach (App\Models\Content::where('type', 'albums')->get() as $alb)
                                            <option {{ $content->parent_id == $alb->id ? 'selected' : '' }}
                                                value="{{ $alb->id }}">{{ $alb->title }}</option>
                                        @endforeach
                                    @elseif($type == 'doctors')
                                        @foreach (App\Models\Content::where('type', 'department-sliders')->where('status', 1)->get() as $dept)
                                            <option {{ $content->parent_id == $dept->id ? 'selected' : '' }}
                                                value="{{ $dept->id }}">{{ $dept->title }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            @elseif($field == 'short')
                                <textarea class="form-control" id="{{ $field }}" name="{{ $field }}" {{ $isRequired }}>{{ $content->$field }}</textarea>
                            @elseif($field == 'status')
                                <select name="{{ $field }}" id="{{ $field }}" class="form-select"
                                    {{ $isRequired }}>
                                    <option {{ $content->$field == 1 ? 'selected' : '' }} value="1">Active</option>
                                    <option {{ $content->$field == 0 ? 'selected' : '' }} value="0">Inactive</option>
                                </select>
                            @elseif($field == 'start_date' || $field == 'end_date')
                                <input type="datetime-local" class="form-control" id="{{ $field }}"
                                    name="{{ $field }}" value="{{ $content->$field }}" {{ $isRequired }}>
                            @elseif($field == 'url')
                                <textarea class="form-control" id="{{ $field }}" name="{{ $field }}" rows="3"
                                    {{ $isRequired }}>{{ $content->$field }}</textarea>
                            @elseif(in_array($field, ['body', 'body_2', 'body_3', 'body_4']) && ($data['type'] ?? '') !== 'text')
                                @php
                                    $collapsibleTypes = [
                                        'project',
                                        'news',
                                        'events',
                                        'blogs',
                                        'job-position',
                                        'meta_info',
                                    ];
                                    $isCollapsible = in_array($type, $collapsibleTypes);
                                @endphp

                                <div class="row bg-light p-3 border rounded mb-4 mx-0 shadow-sm">
                                    @if ($isCollapsible)
                                        <div class="col-md-8 mb-3">
                                            <label class="form-label fw-bold text-primary">{{ $data['label'] }} Title
                                                (Collapse Trigger)</label>
                                            <input type="text" name="extra_title_{{ $field }}"
                                                class="form-control" value="{{ $extraData['title_' . $field] ?? '' }}"
                                                placeholder="Enter heading for this section">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label fw-bold">Visibility Status</label>
                                            <select name="extra_status_{{ $field }}" class="form-select">
                                                <option value="1"
                                                    {{ ($extraData['status_' . $field] ?? '1') == '1' ? 'selected' : '' }}>
                                                    Active</option>
                                                <option value="0"
                                                    {{ ($extraData['status_' . $field] ?? '1') == '0' ? 'selected' : '' }}>
                                                    Inactive</option>
                                            </select>
                                        </div>
                                    @else
                                        {{-- ৩. সাধারণ পেজ হলে শুধু স্ট্যাটাস দেখাবে (টাইটেল ইনপুট থাকবে না) --}}
                                        <div class="col-md-12 mb-2 d-flex justify-content-between align-items-center">
                                            <label class="form-label fw-bold">{{ $data['label'] }}</label>
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="small fw-bold text-muted">Status:</span>
                                                <select name="extra_status_{{ $field }}"
                                                    class="form-select form-select-sm" style="width: 120px;">
                                                    <option value="1"
                                                        {{ ($extraData['status_' . $field] ?? '1') == '1' ? 'selected' : '' }}>
                                                        Active</option>
                                                    <option value="0"
                                                        {{ ($extraData['status_' . $field] ?? '1') == '0' ? 'selected' : '' }}>
                                                        Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="col-md-12">
                                        <textarea class="form-control ckeditor" name="{{ $field }}" id="{{ $field }}" rows="6"
                                            {{ $isRequired }}>{!! $content->$field ?? '' !!}</textarea>
                                    </div>
                                </div>
                            @elseif($field == 'meta_description')
                                <textarea class="form-control" name="{{ $field }}" id="{{ $field }}" rows="4"
                                    placeholder="Enter SEO description here...">{{ $content->$field ?? '' }}</textarea>
                            @else
                                <input type="text" class="form-control" value="{{ $content->$field }}"
                                    id="{{ $field }}" name="{{ $field }}" {{ $isRequired }}>
                            @endif
                        </div>
                    @endforeach

                </div>
                @php
                    $slug = $content->name ?? $content->id;
                    $type = strtolower($content->type ?? '');
                    $viewUrl = null;

                    switch ($type) {
                        case 'news':
                            $viewUrl = route('news.show', $slug);
                            break;

                        case 'event':
                        case 'events':
                            $viewUrl = route('events.show', $slug);
                            break;

                        case 'blog':
                        case 'blogs':
                            $viewUrl = route('blog.details', $slug);
                            break;

                        case 'project':
                        case 'projects':
                            $viewUrl = url('/project/' . $slug);
                            break;

                        case 'meta_info':
                            if ($slug === 'home') {
                                $viewUrl = url('/');
                            } elseif ($slug === 'about') {
                                $viewUrl = route('front.about');
                            } elseif ($slug === 'career') {
                                $viewUrl = route('career');
                            } elseif ($slug === 'event') {
                                $viewUrl = route('events');
                            } elseif ($slug === 'projects') {
                                $viewUrl = route('projects');
                            } elseif ($slug === 'concerns') {
                                $viewUrl = route('concerns');
                            } elseif ($slug === 'blog') {
                                $viewUrl = route('blog.index');
                            } else {
                                $viewUrl = route('page.show', $slug);
                            }
                            break;
                    }
                    if ($viewUrl) {
                        $connector = strpos($viewUrl, '?') !== false ? '&' : '?';
                        $viewUrl .= $connector . 'preview=true';
                    }
                @endphp

                <div class="card-footer">
                    <button type="submit" class="btn btn-success px-4">Update</button>

                    {{-- 4. Only show the button if a URL was actually generated --}}
                    @if ($viewUrl)
                        <a href="{{ $viewUrl }}" target="_blank" class="btn btn-dark text-white ms-2">
                            <i class="fa-solid fa-eye me-1"></i> View Content
                        </a>
                    @endif

                    <a href="{{ url()->previous() }}" class="btn btn-secondary ms-2">Cancel</a>
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
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"
        integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
    <script src="{{ asset('backend/summernote/summernote.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('backend/summernote/summernote.css') }}">
    <script src="{{ asset('backend/tinymce/js/tinymce/tinymce.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            tinymce.init({
                selector: '.ckeditor',
                license_key: 'gpl',
                height: 380,
                menubar: false,
                plugins: ['advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview', 'anchor',
                    'searchreplace', 'visualblocks', 'code', 'fullscreen', 'insertdatetime', 'media',
                    'table', 'help', 'wordcount',
                ],
                // 👇 এখানে image কে backcolor এর ঠিক পরে নিয়ে আসা হয়েছে
                toolbar: 'undo redo | blocks fontsize | bold italic forecolor backcolor image | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link media code removeformat',
                color_map: [
                    "000000", "Black",
                    "66267b", "Purple (Brand)",
                    "ce9131", "Gold",
                    "FF0000", "Red",
                    "008000", "Green",
                    "0000FF", "Blue",
                    "808080", "Gray",
                    "ffffff", "White"
                ],
                content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px; color: #333; }',
                paste_data_images: true,
                automatic_uploads: false,
                file_picker_types: 'image',
                file_picker_callback: function(cb) {
                    var inp = document.createElement('input');
                    inp.setAttribute('type', 'file');
                    inp.setAttribute('accept', 'image/*');
                    inp.onchange = function() {
                        var reader = new FileReader();
                        reader.onload = function() {
                            cb(reader.result, {
                                title: inp.files[0].name
                            });
                        };
                        reader.readAsDataURL(inp.files[0]);
                    };
                    inp.click();
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
                    img.style.cssText =
                        'height:80px; width:100px; object-fit:cover; border-radius:4px; border:1px solid #dee2e6;';

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
    <script>
        function generateSlug() {
            const titleInput = document.getElementById('title');
            const nameInput = document.getElementById('name');

            if (!titleInput || !nameInput) return;

            const slug = titleInput.value.toLowerCase()
                .trim()
                .replace(/[^\w\s-]/g, '')
                .replace(/[\s_-]+/g, '-')
                .replace(/^-+|-+$/g, '');

            nameInput.value = slug;
        }

        document.addEventListener('DOMContentLoaded', function() {
            const titleInput = document.getElementById('title');

            const slugTypes = @json($slugTypes);
            const currentType = "{{ $type }}";

            if (titleInput && slugTypes.includes(currentType)) {
                titleInput.addEventListener('input', function() {
                    generateSlug();
                });
            }
        });
    </script>
@endpush




