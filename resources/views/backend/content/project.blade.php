@extends('layouts.backend')
@section('title', 'Create Project')
@section('content')

<div class="container mt-2">
    <form action="{{ route('content.store', $type) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="type" value="project">

        <div class="card card-success card-outline mb-4">
            <div class="card-header">
                <div class="card-title">Create New Project</div>
            </div>
            <div class="card-body">

                {{-- Row 1: Basic Info --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Project Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="title" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-semibold">Project Type <span class="text-danger">*</span></label>
                        <select name="short" class="form-select" required>
                            <option value="">-- Select --</option>
                            <option value="Residential">Residential</option>
                            <option value="Commercial">Commercial</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>

                {{-- Location --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Location / Address <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="location" required>
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
                                        <option value="ongoing">Ongoing</option>
                                        <option value="upcoming">Upcoming</option>
                                        <option value="complete">Complete</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small">Size / Apartment Types</label>
                                    <div id="sizeRows">
                                        <div class="size-row d-flex gap-2 mb-2 align-items-center">
                                            <input type="text" name="extra_size[]" class="form-control form-control-sm"
                                                placeholder="e.g. Type A - 1558 Sq. ft.">
                                            <button type="button" class="btn btn-sm btn-outline-success" onclick="addSizeRow()" title="Add row">+</button>
                                        </div>
                                    </div>
                                    <small class="text-muted">Multiple type  + press</small>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label small">Building Height</label>
                                    <input type="text" name="extra_height" id="extraHeight" class="form-control form-control-sm" placeholder="G+M+8">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label small">Facing</label>
                                    <select name="extra_facing" id="extraFacing" class="form-select form-select-sm">
                                        <option value="">-- Select --</option>
                                        @foreach(['North','South','East','West','North-East','North-West'] as $dir)
                                        <option value="{{ $dir }}">{{ $dir }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small">Google Map Embed URL</label>
                                    <input type="text" name="extra_map" id="extraMap" class="form-control form-control-sm">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label small">Featured?</label>
                                    <select name="extra_featured" id="extraFeatured" class="form-select form-select-sm">
                                        <option value="false">No</option>
                                        <option value="true">Yes</option>
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
                        <textarea class="editor form-control" name="body" rows="4"></textarea>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-semibold">Description Box 2</label>
                        <textarea class="editor form-control" name="body_2" rows="4"></textarea>
                    </div>
                </div>

                {{-- Thumbnail --}}
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Thumbnail Image</label>
                        <input type="file" class="form-control" name="img_path" accept="image/*"
                            onchange="previewSingle(this, 'thumbPreview')">
                        <div class="mt-2 d-flex gap-2 flex-wrap" id="thumbPreview"></div>
                    </div>

                    {{-- Video --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Video</label>
                        <input type="file" class="form-control" name="video_path" accept="video/mp4"
                            onchange="previewVideo(this)">
                        <div class="mt-2" id="videoPreview"></div>
                    </div>
                </div>

                {{-- Multiple Images --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Multiple Images</label>
                    <input type="file" id="multiInput" name="img_paths[]" multiple accept="image/*" style="display:none">

                    {{-- Drop Zone --}}
                    <div id="dropZone" onclick="triggerMultiFile()"
                        style="border:1.5px dashed #ced4da; border-radius:8px; padding:1.5rem; text-align:center;
                               cursor:pointer; background:#f8f9fa; transition:.2s;">
                        <i class="bi bi-cloud-upload fs-3 text-muted"></i>
                        <p class="text-muted small mb-2 mt-1">Drag &amp; drop images here, or click to browse</p>
                        <button type="button" class="btn btn-outline-secondary btn-sm"
                            onclick="event.stopPropagation(); triggerMultiFile()">
                            Choose files
                        </button>
                    </div>

                    <div class="mt-1 d-flex gap-2 flex-wrap align-items-start">
                        <span class="badge bg-primary">1st → Cover</span>
                        <span class="badge bg-secondary">2nd → At a Glance</span>
                        <span class="badge bg-secondary">3rd → Gallery Left</span>
                        <span class="badge bg-secondary">4th → Gallery Right</span>
                        <span class="badge bg-dark">5th+ → Slider</span>
                        <span class="text-muted small ms-auto" id="imgCount"></span>
                    </div>
                    <div id="multiPreview" class="mt-2 d-flex gap-2 flex-wrap align-items-start"></div>
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
                                    <input type="text" class="form-control form-control-sm" name="meta_title">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small">Meta Keywords</label>
                                    <input type="text" class="form-control form-control-sm" name="meta_keywords">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label small">Meta Description</label>
                                    <textarea class="form-control form-control-sm" name="meta_description" rows="4"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-success px-5">Create Project</button>
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
    // Summernote
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
    // Thumbnail — single preview
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
    // Video — preview
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
    // Multiple Images — drag-drop + reorder + remove
    // ════════════════════════════════════════════════════════
    const SLOT_LABELS = [
        '1st: Cover',
        '2nd: At a Glance',
        '3rd: Gallery Left',
        '4th: Gallery Right',
    ];

    function getSlotLabel(i) {
        if (i < SLOT_LABELS.length) {
            return {
                text: SLOT_LABELS[i],
                cls: i === 0 ? 'bg-primary' : 'bg-secondary'
            };
        }
        return {
            text: `Slider ${i - 3}`,
            cls: 'bg-dark'
        };
    }

    let multiFiles = [];
    let dragSrc = null;

    const dropZone = document.getElementById('dropZone');
    const multiInput = document.getElementById('multiInput');

    function triggerMultiFile() {
        multiInput.click();
    }

    multiInput.addEventListener('change', function() {
        addFiles(this.files);
        this.value = '';
    });

    dropZone.addEventListener('dragover', e => {
        e.preventDefault();
        dropZone.style.borderColor = '#0d6efd';
        dropZone.style.background = '#e8f0fe';
    });
    dropZone.addEventListener('dragleave', () => {
        dropZone.style.borderColor = '#ced4da';
        dropZone.style.background = '#f8f9fa';
    });
    dropZone.addEventListener('drop', e => {
        e.preventDefault();
        dropZone.style.borderColor = '#ced4da';
        dropZone.style.background = '#f8f9fa';
        addFiles(e.dataTransfer.files);
    });

    function addFiles(incoming) {
        Array.from(incoming).forEach(f => {
            if (!f.type.startsWith('image/')) return;
            multiFiles.push({
                file: f,
                url: URL.createObjectURL(f)
            });
        });
        syncInput();
        renderMulti();
    }

    function removeFile(i) {
        URL.revokeObjectURL(multiFiles[i].url);
        multiFiles.splice(i, 1);
        syncInput();
        renderMulti();
    }

    function syncInput() {
        const dt = new DataTransfer();
        multiFiles.forEach(m => dt.items.add(m.file));
        multiInput.files = dt.files;
        const countEl = document.getElementById('imgCount');
        if (countEl) countEl.textContent = multiFiles.length ? `${multiFiles.length} image(s) selected` : '';
    }

    function renderMulti() {
        const preview = document.getElementById('multiPreview');
        preview.innerHTML = '';

        multiFiles.forEach((item, i) => {
            const slot = getSlotLabel(i);

            const card = document.createElement('div');
            card.draggable = true;
            card.dataset.index = i;
            card.style.cssText = 'position:relative;width:110px;text-align:center;cursor:grab;' +
                'border:1px solid #dee2e6;border-radius:6px;overflow:visible;background:#fff;';

            card.addEventListener('dragstart', e => {
                dragSrc = i;
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
                if (dragSrc === null || dragSrc === dest) return;
                const moved = multiFiles.splice(dragSrc, 1)[0];
                multiFiles.splice(dest, 0, moved);
                dragSrc = null;
                syncInput();
                renderMulti();
            });

            const img = document.createElement('img');
            img.src = item.url;
            img.style.cssText = 'width:110px;height:80px;object-fit:cover;' +
                'border-radius:5px 5px 0 0;display:block;pointer-events:none;';

            const label = document.createElement('div');
            label.className = `badge ${slot.cls} mt-1 mb-1 d-block mx-1`;
            label.style.cssText = 'font-size:9px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;';
            label.textContent = slot.text;

            const rem = document.createElement('button');
            rem.type = 'button';
            rem.innerHTML = '&times;';
            rem.title = 'Remove';
            rem.style.cssText = 'position:absolute;top:-7px;right:-7px;width:20px;height:20px;' +
                'border-radius:50%;background:red;color:#fff;border:none;' +
                'font-size:13px;line-height:18px;cursor:pointer;padding:0;z-index:10;';
            rem.onclick = e => {
                e.stopPropagation();
                removeFile(i);
            };

            card.appendChild(img);
            card.appendChild(label);
            card.appendChild(rem);
            preview.appendChild(card);
        });

        // "+ Add more" tile
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
            inp.onchange = () => addFiles(inp.files);
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