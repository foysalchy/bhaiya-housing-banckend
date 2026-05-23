@extends('layouts.backend')
@section('title', 'Edit Project')
@section('content')

<div class="container mt-2">
    <form action="{{ route('content.update', [$type, $content->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('post')
        <input type="hidden" name="type" value="project">
        <input type="hidden" name="id" value="{{ $content->id }}">

        <div class="card card-success card-outline mb-4">
            <div class="card-header">
                <div class="card-title">Edit Project — {{ $content->title }}</div>
            </div>
            <div class="card-body">

                {{-- Row 1: Basic Info --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Project Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="title" required value="{{ $content->title }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-semibold">Project Type <span class="text-danger">*</span></label>
                        <select name="short" class="form-select" required>
                            <option value="">-- Select --</option>
                            <option value="Residential" {{ $content->short === 'Residential' ? 'selected' : '' }}>Residential</option>
                            <option value="Commercial" {{ $content->short === 'Commercial' ? 'selected' : '' }}>Commercial</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="1" {{ $content->status == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $content->status == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>

                {{-- Location --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Location / Address <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="location" required value="{{ $content->location }}">
                </div>

                {{-- Extra JSON Builder --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Project Details</label>
                    <div class="card bg-light border">
                        <div class="card-body pb-0">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label small">Project Status</label>
                                    <select name="extra_status" id="extraStatus" class="form-select form-select-sm">
                                        <option value="ongoing" {{ ($extra['status'] ?? '') === 'ongoing'  ? 'selected' : '' }}>Ongoing</option>
                                        <option value="upcoming" {{ ($extra['status'] ?? '') === 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                                        <option value="complete" {{ ($extra['status'] ?? '') === 'complete' ? 'selected' : '' }}>Complete</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label small">Size</label>
                                    <input type="text" name="extra_size" id="extraSize" class="form-control form-control-sm"
                                        value="{{ $extra['size'] ?? '' }}" placeholder="2850 sft (Approx)">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label small">Building Height</label>
                                    <input type="text" name="extra_height" id="extraHeight" class="form-control form-control-sm"
                                        value="{{ $extra['building_height'] ?? '' }}" placeholder="G+M+8">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label small">Facing</label>
                                    <select name="extra_facing" id="extraFacing" class="form-select form-select-sm">
                                        <option value="">-- Select --</option>
                                        @foreach(['North','South','East','West','North-East','North-West'] as $dir)
                                        <option value="{{ $dir }}" {{ ($extra['facing'] ?? '') === $dir ? 'selected' : '' }}>{{ $dir }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small">Google Map Embed URL</label>
                                    <input type="text" name="extra_map" id="extraMap" class="form-control form-control-sm"
                                        value="{{ $extra['map_url'] ?? '' }}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label small">Featured?</label>
                                    <select name="extra_featured" id="extraFeatured" class="form-select form-select-sm">
                                        <option value="false" {{ empty($extra['featured']) ? 'selected' : '' }}>No</option>
                                        <option value="true" {{ !empty($extra['featured']) ? 'selected' : '' }}>Yes</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Descriptions --}}
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea class="editor form-control" name="body" rows="4">{!! $content->body !!}</textarea>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-semibold">Description Box 2</label>
                        <textarea class="editor form-control" name="body_2" rows="4">{!! $content->body_2 !!}</textarea>
                    </div>
                </div>

                {{-- Thumbnail --}}
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Thumbnail Image</label>

                        {{-- Existing thumbnail --}}
                        @if($content->img_path)
                        <div class="mb-2 d-flex align-items-center gap-2">
                            <img src="{{ asset($content->img_path) }}" id="thumbCurrent"
                                style="height:80px; border-radius:4px; border:1px solid #dee2e6;">
                            <div>
                                <div class="badge bg-secondary d-block mb-1">Current</div>
                                <div class="form-check mb-0">
                                    <input class="form-check-input border-danger" type="checkbox"
                                        name="delete_img_path" id="deleteThumb" value="1"
                                        onchange="toggleShade('thumbCurrent', this)">
                                    <label class="form-check-label text-danger small" for="deleteThumb">Delete</label>
                                </div>
                            </div>
                        </div>
                        @endif

                        <input type="file" class="form-control" name="img_path" accept="image/*"
                            onchange="previewSingle(this, 'thumbPreview')">
                        <div class="mt-2 d-flex gap-2 flex-wrap" id="thumbPreview"></div>
                    </div>

                    {{-- Video --}}
                 <div class="col-md-4 mb-3">
    <label class="form-label fw-semibold">Video</label>

    {{-- Existing video --}}
    @if($content->video_path)
    <div class="mb-2">
        <div class="d-flex align-items-center gap-2">
            <video id="videoCurrentPreview" controls
                style="height:100px; border-radius:4px; border:1px solid #dee2e6;">
                <source src="{{ asset($content->video_path) }}">
            </video>
            <div>
                <div class="badge bg-secondary d-block mb-1">{{ basename($content->video_path) }}</div>
                <div class="form-check mb-0">
                    <input class="form-check-input border-danger" type="checkbox"
                        name="delete_video" id="deleteVideo" value="1"
                        onchange="toggleShade('videoCurrentPreview', this)">
                    <label class="form-check-label text-danger small" for="deleteVideo">Delete</label>
                </div>
            </div>
        </div>
    </div>
    @endif

    <input type="file" class="form-control" name="video_path" accept="video/mp4"
        onchange="previewVideo(this)">
    <div class="mt-2" id="videoPreview"></div>
    <small class="text-muted">If you don't upload a new file, the previous one will remain.</small>
</div>
                </div>

                {{-- Multiple Images --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Multiple Images</label>

                    {{-- Existing images with delete checkbox --}}
                    @if(!empty($imgPaths) && count($imgPaths) > 0)
                    <div class="d-flex gap-3 flex-wrap mb-2">
                        @foreach($imgPaths as $i => $img)
                        @php
                        $labels = ['1st: At a Glance', '2nd: Gallery Left', '3rd: Gallery Right'];
                        $label = $labels[$i] ?? 'Slider ' . ($i - 2);
                        @endphp
                        <div style="text-align:center;">
                            <img src="{{ asset($img) }}" id="existingImg{{ $i }}"
                                style="height:80px; width:100px; object-fit:cover; border-radius:4px; border:1px solid #dee2e6;">
                            <div class="badge bg-secondary mt-1 d-block" style="font-size:10px; max-width:100px;">{{ $label }}</div>
                            <div class="form-check mt-1">
                                <input class="form-check-input border-danger" type="checkbox"
                                    name="delete_images[]" value="{{ $i }}" id="delImg{{ $i }}"
                                    onchange="toggleShade('existingImg{{ $i }}', this)">
                                <label class="form-check-label text-danger small" for="delImg{{ $i }}">Delete</label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <small class="text-muted d-block mb-2">
                        Check "Delete" to remove specific images. New uploads will be appended.
                    </small>
                    @endif

                    <input type="file" multiple class="form-control" id="multiInput" name="img_paths[]" accept="image/*"
                        onchange="previewMultiple(this)">
                    <div class="mt-1 d-flex gap-2 flex-wrap align-items-start">
                        <span class="badge bg-primary">1st → At a Glance</span>
                        <span class="badge bg-secondary">2nd → Gallery Left</span>
                        <span class="badge bg-secondary">3rd → Gallery Right</span>
                        <span class="badge bg-dark">4th+ → Slider</span>
                    </div>
                    <div class="mt-2 d-flex gap-2 flex-wrap" id="multiPreview"></div>
                </div>

                {{-- SEO --}}
                <div class="card border mt-3">
                    <div class="card-header bg-light py-2 cursor-pointer" data-bs-toggle="collapse" data-bs-target="#seoSection">
                        <small class="fw-semibold"> SEO (optional)</small>
                    </div>
                    <div class="collapse" id="seoSection">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small">Meta Title</label>
                                    <input type="text" class="form-control form-control-sm" name="meta_title" value="{{ $content->meta_title }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small">Meta Keywords</label>
                                    <input type="text" class="form-control form-control-sm" name="meta_keywords" value="{{ $content->meta_keywords }}">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label small">Meta Description</label>
                                    <textarea class="form-control form-control-sm" name="meta_description" rows="4">{{ $content->meta_description }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-success px-5">Update Project</button>
                <a href="{{ url()->previous() }}" class="btn btn-secondary ms-2">Cancel</a>
            </div>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="{{ asset('backend/summernote/summernote.js') }}"></script>
<link rel="stylesheet" href="{{ asset('backend/summernote/summernote.css') }}">

<style>
    .img-shaded {
        opacity: 0.3;
        outline: 2px solid red;
        border-radius: 4px;
    }

    .preview-wrap {
        position: relative;
        text-align: center;
    }

    .preview-wrap .remove-btn {
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
    // ── Shade existing image/video when delete checkbox toggled ──
    function toggleShade(elemId, checkbox) {
        const el = document.getElementById(elemId);
        if (el) el.classList.toggle('img-shaded', checkbox.checked);
    }

    // ── Preview single new image with × remove ───────────────────
    function previewSingle(input, previewId) {
        const preview = document.getElementById(previewId);
        preview.innerHTML = '';
        if (!input.files || !input.files[0]) return;

        const wrap = document.createElement('div');
        wrap.className = 'preview-wrap';

        const img = document.createElement('img');
        img.src = URL.createObjectURL(input.files[0]);
        img.style.cssText = 'height:80px; width:100px; object-fit:cover; border-radius:4px; border:1px solid #dee2e6;';

        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'remove-btn';
        btn.innerHTML = '&times;';
        btn.onclick = () => {
            input.value = '';
            preview.innerHTML = '';
        };

        wrap.appendChild(img);
        wrap.appendChild(btn);
        preview.appendChild(wrap);
    }

    // ── Preview new video with × remove ─────────────────────────
    function previewVideo(input) {
        const preview = document.getElementById('videoPreview');
        preview.innerHTML = '';
        if (!input.files || !input.files[0]) return;

        const wrap = document.createElement('div');
        wrap.className = 'preview-wrap d-inline-block';

        const video = document.createElement('video');
        video.src = URL.createObjectURL(input.files[0]);
        video.controls = true;
        video.style.cssText = 'height:100px; border-radius:4px; border:1px solid #dee2e6;';

        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'remove-btn';
        btn.innerHTML = '&times;';
        btn.onclick = () => {
            input.value = '';
            preview.innerHTML = '';
        };

        wrap.appendChild(video);
        wrap.appendChild(btn);
        preview.appendChild(wrap);
    }

    // ── Multiple new images — each with × remove ─────────────────
    const multiInput = document.getElementById('multiInput');
    let multiFiles = [];

    function previewMultiple(input) {
        multiFiles = Array.from(input.files);
        renderMulti();
    }

    function renderMulti() {
        const preview = document.getElementById('multiPreview');
        preview.innerHTML = '';
        const labels = ['1st: At a Glance', '2nd: Gallery Left', '3rd: Gallery Right'];

        multiFiles.forEach((file, i) => {
            const wrap = document.createElement('div');
            wrap.className = 'preview-wrap';

            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.style.cssText = 'height:80px; width:100px; object-fit:cover; border-radius:4px; border:1px solid #dee2e6;';

            const label = document.createElement('div');
            label.className = 'badge bg-secondary mt-1 d-block';
            label.style.cssText = 'font-size:10px; max-width:100px;';
            label.textContent = labels[i] ?? `Slider ${i - 2}`;

            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'remove-btn';
            btn.innerHTML = '&times;';
            btn.onclick = () => {
                multiFiles.splice(i, 1);
                const dt = new DataTransfer();
                multiFiles.forEach(f => dt.items.add(f));
                multiInput.files = dt.files;
                renderMulti();
            };

            wrap.appendChild(img);
            wrap.appendChild(label);
            wrap.appendChild(btn);
            preview.appendChild(wrap);
        });
    }
</script>
@endpush