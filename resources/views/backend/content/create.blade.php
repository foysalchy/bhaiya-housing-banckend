@extends('layouts.backend')
@section('title', 'Create' . ' ' . ucwords(str_replace(['-', '_'], ' ', $type)))
@section('content')

    <div class="container mt-2">
        <form action="{{ route('content.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="type" value="{{ $type }}">

            <div class="card card-success card-outline mb-4">
                <div class="card-header">
                    <h3 class="card-title">Create New {{ ucwords(str_replace(['-', '_'], ' ', $type)) }}</h3>
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
                    @foreach ($contents[$type] as $field => $data)
                        <div class="mb-3">
                            <div class="d-flex align-items-center justify-content-between mb-1">
                                <label for="{{ $field }}" class="form-label mb-0 fw-semibold">{{ $data['label'] }}</label>
                                @if(!empty($data['recommended_size']))
                                    <span class="badge bg-light text-primary border" style="font-size: 11px; font-weight: 600;" title="Recommended aspect ratio and dimensions">
                                        <i class="bi bi-aspect-ratio me-1"></i>{{ $data['recommended_size'] }}
                                    </span>
                                @endif
                            </div>
                            @php $isRequired = $data['required'] ? 'required' : ''; @endphp

                            @if ($field == 'title')
                                <div class="{{ in_array($type, $slugTypes) ? 'input-group' : '' }}">
                                    <input type="text" class="form-control" id="title" name="title"
                                        {{ $isRequired }} placeholder="Enter {{ $data['label'] }}">

                                    @if (in_array($type, $slugTypes))
                                        <button type="button" class="btn btn-outline-secondary" onclick="generateSlug()">
                                            <i class="bi bi-link-45deg"></i> Generate Slug
                                        </button>
                                    @endif
                                </div>
                            @elseif($field == 'name')
                                <input type="text" class="form-control" id="name" name="name" {{ $isRequired }}
                                    placeholder="{{ in_array($type, $slugTypes) ? 'url-friendly-slug' : 'Enter ' . $data['label'] }}">

                                @if (in_array($type, $slugTypes))
                                    <small class="text-muted">This will be used as the URL slug.</small>
                                @endif
                            @elseif ($field == 'img_path')
                                <input type="file" class="form-control" id="{{ $field }}"
                                    name="{{ $field }}" accept="image/*" {{ $isRequired }} onchange="measureLiveImage(this, 'createSinglePreview')">
                                <div id="createSinglePreview" class="mt-2 d-flex gap-2 flex-wrap"></div>
                            @elseif($field == 'img_paths')
                                <input type="file" multiple class="form-control" id="{{ $field }}"
                                    name="{{ $field }}[]" accept="image/*" {{ $isRequired }} onchange="measureLiveMultiImages(this, 'createMultiPreview')">
                                <div id="createMultiPreview" class="mt-2 d-flex gap-2 flex-wrap"></div>
                            @elseif($field == 'video_path')
                                <input type="file" class="form-control" id="{{ $field }}"
                                    name="{{ $field }}" {{ $isRequired }}>
                            @elseif($field == 'parent')
                                <select name="parent_id" id="parent_id" class="form-select" {{ $isRequired }}>
                                    <option value="">-- Select --</option>
                                    @if ($type == 'gallery')
                                        @foreach (App\Models\Content::where('type', 'albums')->get() as $alb)
                                            <option
                                                {{ isset($_GET['parent']) && $_GET['parent'] == $alb->id ? 'selected' : '' }}
                                                value="{{ $alb->id }}">{{ $alb->title }}</option>
                                        @endforeach
                                    @elseif($type == 'doctors')
                                        @foreach (App\Models\Content::where('type', 'department-sliders')->where('status', 1)->get() as $dept)
                                            <option
                                                {{ isset($_GET['parent']) && $_GET['parent'] == $dept->id ? 'selected' : '' }}
                                                value="{{ $dept->id }}">{{ $dept->title }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            @elseif($field == 'short')
                                <textarea class="form-control" id="{{ $field }}" name="{{ $field }}" {{ $isRequired }}></textarea>
                            @elseif($field == 'status')
                                <select name="{{ $field }}" id="{{ $field }}" class="form-select"
                                    {{ $isRequired }}>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            @elseif($field == 'start_date' || $field == 'end_date')
                                <input type="datetime-local" class="form-control" id="{{ $field }}"
                                    name="{{ $field }}" {{ $isRequired }}>
                            @elseif($field == 'url')
                                <textarea class="form-control" id="{{ $field }}" name="{{ $field }}" rows="3"
                                    {{ $isRequired }}></textarea>
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
                                <input type="text" class="form-control" id="{{ $field }}"
                                    name="{{ $field }}" {{ $isRequired }}>
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
                    'table', 'help', 'wordcount'
                ],
                // 👇 এখানে image কে backcolor এর ঠিক পরে নিয়ে আসা হয়েছে
                toolbar: 'undo redo | blocks fontsize | bold italic backcolor image | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link media code removeformat',
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

        // Live Dimension Measurement
        function measureLiveImage(input, previewContainerId) {
            const container = document.getElementById(previewContainerId);
            if (!container) return;
            container.innerHTML = '';
            if (!input.files || !input.files[0]) return;

            const file = input.files[0];
            const sizeFormatted = file.size > 1024 * 1024
                ? (file.size / (1024 * 1024)).toFixed(2) + ' MB'
                : (file.size / 1024).toFixed(1) + ' KB';

            const reader = new FileReader();
            reader.onload = function(e) {
                const img = new Image();
                img.onload = function() {
                    container.innerHTML = `
                        <div class="card p-2 border shadow-sm position-relative" style="max-width: 220px; background: #fff;">
                            <img src="${e.target.result}" style="width: 100%; height: 110px; object-fit: cover; border-radius: 4px;" class="border">
                            <div class="mt-2 text-center">
                                <span class="badge bg-primary text-white p-1 px-2 mb-1 d-inline-block" style="font-size: 11px;">
                                    <i class="bi bi-arrows-fullscreen me-1"></i>${this.naturalWidth} × ${this.naturalHeight} px
                                </span>
                                <div class="text-muted small" style="font-size: 11px;">${file.name.substring(0, 20)} (${sizeFormatted})</div>
                            </div>
                        </div>
                    `;
                };
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }

        function measureLiveMultiImages(input, previewContainerId) {
            const container = document.getElementById(previewContainerId);
            if (!container) return;
            container.innerHTML = '';
            if (!input.files || input.files.length === 0) return;

            Array.from(input.files).forEach(file => {
                const sizeFormatted = file.size > 1024 * 1024
                    ? (file.size / (1024 * 1024)).toFixed(2) + ' MB'
                    : (file.size / 1024).toFixed(1) + ' KB';

                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = new Image();
                    img.onload = function() {
                        const item = document.createElement('div');
                        item.className = 'card p-1 border shadow-sm position-relative mb-2';
                        item.style.width = '140px';
                        item.style.background = '#fff';
                        item.innerHTML = `
                            <div style="position: relative;">
                                <img src="${e.target.result}" style="width: 100%; height: 85px; object-fit: cover; border-radius: 4px;" class="border">
                                <span class="badge bg-dark bg-opacity-75 text-white position-absolute bottom-0 start-0 m-1" style="font-size: 9px; font-weight: 500;">
                                    ${this.naturalWidth} × ${this.naturalHeight}
                                </span>
                            </div>
                            <div class="text-muted text-truncate text-center mt-1" style="font-size: 10px;" title="${file.name}">
                                ${file.name} (${sizeFormatted})
                            </div>
                        `;
                        container.appendChild(item);
                    };
                    img.src = e.target.result;
                };
                reader.readAsDataURL(file);
            });
        }
    </script>
@endpush




