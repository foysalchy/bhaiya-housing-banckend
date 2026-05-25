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
                            <option value="Commercial" {{ $content->short === 'Commercial'  ? 'selected' : '' }}>Commercial</option>
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
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small">Size / Apartment Types</label>
                                    <div id="sizeRows">
                                        @php
                                        $sizes = isset($extra['size'])
                                        ? (is_array($extra['size']) ? $extra['size'] : [$extra['size']])
                                        : [''];
                                        @endphp
                                        @foreach($sizes as $sz)
                                        <div class="size-row d-flex gap-2 mb-2 align-items-center">
                                            <input type="text" name="extra_size[]" class="form-control form-control-sm"
                                                value="{{ $sz }}" placeholder="e.g. Type A - 1558 Sq. ft.">
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeSizeRow(this)" title="Remove">−</button>
                                        </div>
                                        @endforeach
                                        <div class="size-row d-flex gap-2 mb-2 align-items-center">
                                            <button type="button" class="btn btn-sm btn-outline-success w-100" onclick="addSizeRow()">+ Add Type</button>
                                        </div>
                                    </div>
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
                        <label class="form-label fw-semibold">Short Description</label>
                        <textarea class=" form-control" name="body_3" rows="4">{!! $content->body !!}</textarea>
                    </div>
                   
                </div>
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
                        <small class="text-muted">নতুন file upload না করলে আগেরটা থাকবে।</small>
                    </div>
                </div>

                {{-- ═══════════════════════════════════════════════════════════
                     Multiple Images — existing reorder/delete + new drag-drop
                ════════════════════════════════════════════════════════════ --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Multiple Images</label>

                    {{-- ── Existing images ── --}}
                    @if(!empty($imgPaths) && count($imgPaths) > 0)
                    <p class="text-muted small mb-1">
                        <i class="bi bi-arrows-move"></i>
                        Drag করে existing images reorder করুন। নতুন order submit এ save হবে।
                    </p>
                    {{-- Hidden: stores final order of existing image indexes --}}
                    <input type="hidden" name="existing_order" id="existingOrderInput"
                        value="{{ implode(',', array_keys($imgPaths)) }}">

                    <div class="d-flex gap-2 flex-wrap mb-2" id="existingGrid">
                        @foreach($imgPaths as $i => $img)
                        @php
                        $exLabels = ['1st: Cover', '2nd: At a Glance', '3rd: Gallery Left', '4th: Gallery Right'];
                        $exLabel = $exLabels[$i] ?? 'Slider ' . ($i - 3);
                        @endphp
                        <div class="existing-card" data-idx="{{ $i }}" draggable="true"
                            style="position:relative; width:110px; text-align:center; cursor:grab;
                                   border:1px solid #dee2e6; border-radius:6px; background:#fff; overflow:visible;">

                            <img src="{{ asset($img) }}" id="existingImg{{ $i }}"
                                style="width:110px; height:80px; object-fit:cover;
                                       border-radius:5px 5px 0 0; display:block; pointer-events:none;">

                            <div class="existing-label badge bg-{{ $i === 0 ? 'primary' : ($i < 3 ? 'secondary' : 'dark') }} mt-1 mb-1 d-block mx-1"
                                style="font-size:9px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                {{ $exLabel }}
                            </div>

                            <div class="form-check mb-1 d-flex justify-content-center gap-1 align-items-center">
                                <input class="form-check-input border-danger" type="checkbox"
                                    name="delete_images[]" value="{{ $i }}" id="delImg{{ $i }}"
                                    onchange="toggleExistingDelete(this, {{ $i }})">
                                <label class="form-check-label text-danger"
                                    style="font-size:11px;" for="delImg{{ $i }}">Delete</label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <small class="text-muted d-block mb-2">
                        New uploads will be appended after existing images.
                    </small>
                    @endif

                    {{-- ── New images drop zone ── --}}
                    <input type="file" id="multiInput" name="img_paths[]" multiple accept="image/*" style="display:none">

                    <div id="newDropZone" onclick="triggerMultiFile()"
                        style="border:1.5px dashed #ced4da; border-radius:8px; padding:1.2rem;
                               text-align:center; cursor:pointer; background:#f8f9fa; transition:.2s;">
                        <i class="bi bi-cloud-upload fs-4 text-muted"></i>
                        <p class="text-muted small mb-2 mt-1">
                            New image add করতে drag &amp; drop করুন বা click করুন
                        </p>
                        <button type="button" class="btn btn-outline-secondary btn-sm"
                            onclick="event.stopPropagation(); triggerMultiFile()">
                            Choose files
                        </button>
                    </div>

                    <div class="mt-1 d-flex gap-2 flex-wrap align-items-center">
                        <span class="badge bg-primary">1st → Cover</span>
                        <span class="badge bg-secondary">2nd → At a Glance</span>
                        <span class="badge bg-secondary">3rd → Gallery Left</span>
                        <span class="badge bg-secondary">4th → Gallery Right</span>
                        <span class="badge bg-dark">5th+ → Slider</span>
                        <span class="text-muted small ms-auto" id="newImgCount"></span>
                    </div>

                    <div id="newMultiPreview" class="mt-2 d-flex gap-2 flex-wrap align-items-start"></div>
                </div>

                {{-- SEO --}}
                <div class="card border mt-3">
                    <div class="card-header bg-light py-2 cursor-pointer"
                        data-bs-toggle="collapse" data-bs-target="#seoSection">
                        <small class="fw-semibold">⚙ SEO (optional)</small>
                    </div>
                    <div class="collapse" id="seoSection">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small">Meta Title</label>
                                    <input type="text" class="form-control form-control-sm"
                                        name="meta_title" value="{{ $content->meta_title }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small">Meta Keywords</label>
                                    <input type="text" class="form-control form-control-sm"
                                        name="meta_keywords" value="{{ $content->meta_keywords }}">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label small">Meta Description</label>
                                    <textarea class="form-control form-control-sm"
                                        name="meta_description" rows="4">{{ $content->meta_description }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>{{-- /card-body --}}
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
        opacity: .25;
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
        color: #fff;
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
    // ════════════════════════════════════════════════════════
    // Summernote editors
    // ════════════════════════════════════════════════════════
    $(document).ready(function() {
        $('.editor').summernote({
            height: 300,
            resizeable: true,
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

    // Floating tag tooltip inside Summernote
    const $tooltip = $('<div id="tag-tooltip" style="position:fixed;background:#333;color:#fff;padding:3px 8px;border-radius:4px;font-size:11px;font-family:monospace;pointer-events:none;z-index:99999;display:none;"></div>');
    $('body').append($tooltip);

    function updateTagInfo(e) {
        const selection = window.getSelection();
        if (!selection || selection.rangeCount === 0) return;
        let node = selection.anchorNode;
        if (node && node.nodeType === Node.TEXT_NODE) node = node.parentNode;
        let tagName = null,
            current = node;
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
        $tooltip.html(`&lt;${tagName}&gt;`).css({
            left: (e.clientX + 10) + 'px',
            top: (e.clientY - 30) + 'px'
        }).show();
        clearTimeout(window._tagTooltipTimer);
        window._tagTooltipTimer = setTimeout(() => $tooltip.hide(), 2000);
    }

    // ════════════════════════════════════════════════════════
    // Shade helper — thumbnail / video delete checkbox
    // ════════════════════════════════════════════════════════
    function toggleShade(elemId, checkbox) {
        const el = document.getElementById(elemId);
        if (el) el.classList.toggle('img-shaded', checkbox.checked);
    }

    // ════════════════════════════════════════════════════════
    // Thumbnail — single preview with × remove
    // ════════════════════════════════════════════════════════
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

    // ════════════════════════════════════════════════════════
    // Video — preview with × remove
    // ════════════════════════════════════════════════════════
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

    // ════════════════════════════════════════════════════════
    // EXISTING IMAGES — drag-to-reorder + delete shade
    // ════════════════════════════════════════════════════════
    (function() {
        const grid = document.getElementById('existingGrid');
        if (!grid) return;

        const LABELS = ['1st: Cover', '2nd: At a Glance', '3rd: Gallery Left', '4th: Gallery Right'];
        let dragSrc = null;

        function updateExistingLabels() {
            const cards = grid.querySelectorAll('.existing-card');
            const order = [];
            cards.forEach((card, i) => {
                const lbl = card.querySelector('.existing-label');
                const badgeClass = i === 0 ? 'bg-primary' : i < 3 ? 'bg-secondary' : 'bg-dark';
                lbl.className = `existing-label badge ${badgeClass} mt-1 mb-1 d-block mx-1`;
                lbl.style.cssText = 'font-size:9px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;';
                lbl.textContent = LABELS[i] ?? `Slider ${i - 3}`;
                order.push(card.dataset.idx);
            });
            const inp = document.getElementById('existingOrderInput');
            if (inp) inp.value = order.join(',');
        }

        grid.addEventListener('dragstart', e => {
            const card = e.target.closest('.existing-card');
            if (!card) return;
            dragSrc = card;
            setTimeout(() => card.style.opacity = '.35', 0);
            e.dataTransfer.effectAllowed = 'move';
        });

        grid.addEventListener('dragend', () => {
            grid.querySelectorAll('.existing-card').forEach(c => {
                c.style.opacity = '1';
                c.style.outline = '';
            });
        });

        grid.addEventListener('dragover', e => {
            e.preventDefault();
            const card = e.target.closest('.existing-card');
            if (!card || card === dragSrc) return;
            grid.querySelectorAll('.existing-card').forEach(c => c.style.outline = '');
            card.style.outline = '2px solid #0d6efd';
            e.dataTransfer.dropEffect = 'move';
        });

        grid.addEventListener('drop', e => {
            e.preventDefault();
            const target = e.target.closest('.existing-card');
            if (!target || target === dragSrc || !dragSrc) return;
            const cards = [...grid.querySelectorAll('.existing-card')];
            const srcIdx = cards.indexOf(dragSrc);
            const tgtIdx = cards.indexOf(target);
            if (srcIdx < tgtIdx) grid.insertBefore(dragSrc, target.nextSibling);
            else grid.insertBefore(dragSrc, target);
            grid.querySelectorAll('.existing-card').forEach(c => c.style.outline = '');
            dragSrc = null;
            updateExistingLabels();
        });
    })();

    function toggleExistingDelete(checkbox, idx) {
        const img = document.getElementById('existingImg' + idx);
        const card = checkbox.closest('.existing-card');
        if (img) img.style.opacity = checkbox.checked ? '0.25' : '1';
        if (card) card.style.outline = checkbox.checked ? '2px solid red' : '';
    }

    // ════════════════════════════════════════════════════════
    // NEW IMAGES — drag-drop zone + card reorder + remove
    // existing image count বুঝে label assign করে
    // ════════════════════════════════════════════════════════

    // সব slot এর নাম — index 0 থেকে শুরু (combined position)
    const ALL_SLOT_LABELS = [
        '1st: Cover',
        '2nd: At a Glance',
        '3rd: Gallery Left',
        '4th: Gallery Right',
    ];

    // ── Existing image count (delete checkbox বাদ দিয়ে live count) ──
    function getActiveExistingCount() {
        const grid = document.getElementById('existingGrid');
        if (!grid) return 0;
        const cards = grid.querySelectorAll('.existing-card');
        let active = 0;
        cards.forEach(card => {
            const idx = card.dataset.idx;
            const checkbox = document.getElementById('delImg' + idx);
            if (!checkbox || !checkbox.checked) active++;
        });
        return active;
    }

    // ── New image এর global position = existing active count + new index ──
    function getNewSlotLabel(newIndex) {
        const existingCount = getActiveExistingCount();
        const globalPos = existingCount + newIndex; // 0-based combined position
        if (globalPos < ALL_SLOT_LABELS.length) {
            return {
                text: ALL_SLOT_LABELS[globalPos],
                cls: globalPos === 0 ? 'bg-primary' : 'bg-secondary'
            };
        }
        return {
            text: `Slider ${globalPos - 3}`,
            cls: 'bg-dark'
        };
    }

    let newFiles = [];
    let newDragSrc = null;

    const newDropZone = document.getElementById('newDropZone');
    const multiInput = document.getElementById('multiInput');

    // function triggerMultiFile() {
    //     multiInput.click();
    // }

    // multiInput.addEventListener('change', function() {
    //     addNewFiles(this.files);
    //     this.value = '';
    // });
function triggerMultiFile() {
    const tempInput = document.createElement('input');
    tempInput.type = 'file';
    tempInput.multiple = true;
    tempInput.accept = 'image/*';
    tempInput.onchange = () => addNewFiles(tempInput.files);
    tempInput.click();
}
    newDropZone.addEventListener('dragover', e => {
        e.preventDefault();
        newDropZone.style.borderColor = '#0d6efd';
        newDropZone.style.background = '#e8f0fe';
    });
    newDropZone.addEventListener('dragleave', () => {
        newDropZone.style.borderColor = '#ced4da';
        newDropZone.style.background = '#f8f9fa';
    });
    newDropZone.addEventListener('drop', e => {
        e.preventDefault();
        newDropZone.style.borderColor = '#ced4da';
        newDropZone.style.background = '#f8f9fa';
        addNewFiles(e.dataTransfer.files);
    });

    function addNewFiles(incoming) {
        Array.from(incoming).forEach(f => {
            if (!f.type.startsWith('image/')) return;
            newFiles.push({
                file: f,
                url: URL.createObjectURL(f)
            });
        });
        syncNewInput();
        renderNewMulti();
    }

    function removeNewFile(i) {
        URL.revokeObjectURL(newFiles[i].url);
        newFiles.splice(i, 1);
        syncNewInput();
        renderNewMulti();
    }

    function syncNewInput() {
        const dt = new DataTransfer();
        newFiles.forEach(m => dt.items.add(m.file));
        multiInput.files = dt.files;
        const countEl = document.getElementById('newImgCount');
        if (countEl) countEl.textContent = newFiles.length ? `${newFiles.length} new image(s) queued` : '';
    }

    // Delete checkbox change হলে new image labels ও re-render করো
    document.querySelectorAll('[name="delete_images[]"]').forEach(cb => {
        cb.addEventListener('change', () => {
            if (newFiles.length > 0) renderNewMulti();
        });
    });

    // Existing drag-reorder হলেও new labels update করো
    const _origUpdateExisting = typeof updateExistingLabels === 'function' ? updateExistingLabels : null;
    // (existingGrid IIFE এর ভেতরে আছে, তাই drop event এ renderNewMulti call করি)
    const existingGridEl = document.getElementById('existingGrid');
    if (existingGridEl) {
        existingGridEl.addEventListener('drop', () => {
            setTimeout(() => {
                if (newFiles.length > 0) renderNewMulti();
            }, 50);
        });
    }

    function renderNewMulti() {
        const preview = document.getElementById('newMultiPreview');
        preview.innerHTML = '';

        newFiles.forEach((item, i) => {
            const slot = getNewSlotLabel(i);

            const card = document.createElement('div');
            card.draggable = true;
            card.dataset.index = i;
            card.style.cssText = 'position:relative;width:110px;text-align:center;cursor:grab;' +
                'border:1px solid #dee2e6;border-radius:6px;overflow:visible;background:#fff;';

            // ── drag events ──
            card.addEventListener('dragstart', e => {
                newDragSrc = i;
                setTimeout(() => card.style.opacity = '.35', 0);
                e.dataTransfer.effectAllowed = 'move';
            });
            card.addEventListener('dragend', () => {
                card.style.opacity = '1';
                preview.querySelectorAll('[data-index]').forEach(c => c.style.outline = '');
            });
            card.addEventListener('dragover', e => {
                e.preventDefault();
                preview.querySelectorAll('[data-index]').forEach(c => c.style.outline = '');
                card.style.outline = '2px solid #0d6efd';
            });
            card.addEventListener('drop', e => {
                e.preventDefault();
                const dest = parseInt(card.dataset.index);
                if (newDragSrc === null || newDragSrc === dest) return;
                const moved = newFiles.splice(newDragSrc, 1)[0];
                newFiles.splice(dest, 0, moved);
                newDragSrc = null;
                syncNewInput();
                renderNewMulti();
            });

            // ── image ──
            const img = document.createElement('img');
            img.src = item.url;
            img.style.cssText = 'width:110px;height:80px;object-fit:cover;' +
                'border-radius:5px 5px 0 0;display:block;pointer-events:none;';

            // ── label badge — existing count বুঝে slot দেখায় ──
            const label = document.createElement('div');
            label.className = `badge ${slot.cls} mt-1 mb-1 d-block mx-1`;
            label.style.cssText = 'font-size:9px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;';
            label.textContent = slot.text;

            // ── remove button ──
            const rem = document.createElement('button');
            rem.type = 'button';
            rem.innerHTML = '&times;';
            rem.title = 'Remove';
            rem.style.cssText = 'position:absolute;top:-7px;right:-7px;width:20px;height:20px;' +
                'border-radius:50%;background:red;color:#fff;border:none;' +
                'font-size:13px;line-height:18px;cursor:pointer;padding:0;z-index:10;';
            rem.onclick = e => {
                e.stopPropagation();
                removeNewFile(i);
            };

            card.appendChild(img);
            card.appendChild(label);
            card.appendChild(rem);
            preview.appendChild(card);
        });

        // ── "+ Add more" tile ──
        const addBtn = document.createElement('div');
        addBtn.title = 'Add more images';
        addBtn.style.cssText = 'width:110px;height:108px;border:1.5px dashed #ced4da;border-radius:6px;' +
            'display:flex;flex-direction:column;align-items:center;justify-content:center;' +
            'cursor:pointer;color:#6c757d;font-size:12px;gap:4px;';
        addBtn.innerHTML = '<span style="font-size:22px">+</span><span>Add more</span>';
        addBtn.onclick = () => {
            const inp = document.createElement('input');
            inp.type = 'file';
            inp.multiple = true;
            inp.accept = 'image/*';
            inp.onchange = () => addNewFiles(inp.files);
            inp.click();
        };
        preview.appendChild(addBtn);
    }
    // ── Size rows ──────────────────────────────────────────────
function addSizeRow() {
    const container = document.getElementById('sizeRows');
    // "Add Type" button row এর আগে insert করো
    const addBtnRow = container.querySelector('.size-row:last-child');

    const row = document.createElement('div');
    row.className = 'size-row d-flex gap-2 mb-2 align-items-center';
    row.innerHTML = `
        <input type="text" name="extra_size[]" class="form-control form-control-sm"
            placeholder="e.g. Type B - 1552 Sq. ft.">
        <button type="button" class="btn btn-sm btn-outline-danger" 
            onclick="removeSizeRow(this)" title="Remove">−</button>
    `;
    container.insertBefore(row, addBtnRow);
    row.querySelector('input').focus();
}

function removeSizeRow(btn) {
    const row = btn.closest('.size-row');
    // কমপক্ষে ১টা input row থাকবে
    const inputRows = document.querySelectorAll('#sizeRows input[name="extra_size[]"]');
    if (inputRows.length <= 1) {
        row.querySelector('input').value = '';
        return;
    }
    row.remove();
}
</script>
@endpush