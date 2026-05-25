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
                                    <select name="extra_status" class="form-select form-select-sm">
                                        <option value="ongoing">Ongoing</option>
                                        <option value="upcoming">Upcoming</option>
                                        <option value="complete">Complete</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label small">Size</label>
                                    <input type="text" name="extra_size" class="form-control form-control-sm" placeholder="2850 sft (Approx)">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label small">Building Height</label>
                                    <input type="text" name="extra_height" class="form-control form-control-sm" placeholder="G+M+8">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label small">Facing</label>
                                    <select name="extra_facing" class="form-select form-select-sm">
                                        <option value="">-- Select --</option>
                                        @foreach(['North','South','East','West','North-East','North-West'] as $dir)
                                            <option value="{{ $dir }}">{{ $dir }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small">Google Map Embed URL</label>
                                    <input type="text" name="extra_map" class="form-control form-control-sm">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label small">Featured?</label>
                                    <select name="extra_featured" class="form-select form-select-sm">
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
                            onchange="previewSingle(this, 'thumbPreview', 'img_path')">
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
              {{-- Multiple Images --}}
<div class="mb-3">
    <label class="form-label fw-semibold">Multiple Images</label>
    <input type="file" id="multiInput" name="img_paths[]" multiple accept="image/*" style="display:none">

    {{-- Drop Zone --}}
    <div id="dropZone" onclick="triggerMultiFile()"
        style="border:1.5px dashed #ced4da; border-radius:8px; padding:1.5rem; text-align:center; cursor:pointer; background:#f8f9fa; transition:.2s;">
        <i class="bi bi-cloud-upload fs-3 text-muted"></i>
        <p class="text-muted small mb-2 mt-1">Drag &amp; drop images here, or click to browse</p>
        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="event.stopPropagation();triggerMultiFile()">
            Choose files
        </button>
    </div>

    {{-- Badge legend --}}
    <div class="mt-1 d-flex gap-2 flex-wrap align-items-start">
        <span class="badge bg-primary">1st → At a Glance</span>
        <span class="badge bg-secondary">2nd → Gallery Left</span>
        <span class="badge bg-secondary">3rd → Gallery Right</span>
        <span class="badge bg-dark">4th+ → Slider</span>
        <span class="text-muted small ms-auto" id="imgCount"></span>
    </div>

    {{-- Preview Grid --}}
    <div id="multiPreview" class="mt-2 d-flex gap-2 flex-wrap align-items-start"></div>
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
<script>
    $(document).ready(function () {
        $('.editor').summernote({ height: 200 });
        buildExtra(); // default JSON generate
    });

    // ── Extra JSON builder ──
    function buildExtra() {
        const json = {
            status:           document.getElementById('extraStatus').value,
            size:             document.getElementById('extraSize').value,
            building_height:  document.getElementById('extraHeight').value,
            facing:           document.getElementById('extraFacing').value,
            featured:         document.getElementById('extraFeatured').value === 'true',
            map_url:          document.getElementById('extraMap').value,
        };
        document.getElementById('extraJson').value = JSON.stringify(json, null, 2);
    }

    // Auto rebuild on change
    ['extraStatus','extraSize','extraHeight','extraFacing','extraFeatured','extraMap']
        .forEach(id => document.getElementById(id)
            ?.addEventListener('input', buildExtra));

    // ── Image preview ──
    function previewImage(input, previewId) {
        const preview = document.getElementById(previewId);
        preview.innerHTML = '';
        if (input.files && input.files[0]) {
            const img = document.createElement('img');
            img.src = URL.createObjectURL(input.files[0]);
            img.style.cssText = 'height:100px; border-radius:4px; border:1px solid #dee2e6;';
            preview.appendChild(img);
        }
    }

// ── Multiple Images: drag-drop + reorder ──────────────────────────────
const MULTI_LABELS = ['1st: At a Glance', '2nd: Gallery Left', '3rd: Gallery Right'];
let multiFiles = [];
let dragSrcIdx = null;
const dropZone = document.getElementById('dropZone');
const multiInput = document.getElementById('multiInput');

function triggerMultiFile() { multiInput.click(); }

multiInput.addEventListener('change', function () {
    addFiles(this.files);
    this.value = ''; // reset so same file can be re-added
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
        multiFiles.push({ file: f, url: URL.createObjectURL(f) });
    });
    syncInput();
    renderMulti();
}

function removeMultiFile(i) {
    URL.revokeObjectURL(multiFiles[i].url);
    multiFiles.splice(i, 1);
    syncInput();
    renderMulti();
}

function syncInput() {
    const dt = new DataTransfer();
    multiFiles.forEach(m => dt.items.add(m.file));
    multiInput.files = dt.files;
    document.getElementById('imgCount').textContent =
        multiFiles.length ? multiFiles.length + ' image(s) selected' : '';
}

function renderMulti() {
    const preview = document.getElementById('multiPreview');
    preview.innerHTML = '';

    multiFiles.forEach((item, i) => {
        const card = document.createElement('div');
        card.draggable = true;
        card.dataset.index = i;
        card.style.cssText = 'position:relative;width:110px;text-align:center;cursor:grab;border:1px solid #dee2e6;border-radius:6px;overflow:visible;background:#fff;';

        // drag handles
        card.addEventListener('dragstart', e => {
            dragSrcIdx = i;
            setTimeout(() => card.style.opacity = '.35', 0);
            e.dataTransfer.effectAllowed = 'move';
        });
        card.addEventListener('dragend', () => {
            card.style.opacity = '1';
            document.querySelectorAll('#multiPreview [data-index]')
                .forEach(c => c.style.outline = '');
        });
        card.addEventListener('dragover', e => {
            e.preventDefault();
            document.querySelectorAll('#multiPreview [data-index]')
                .forEach(c => c.style.outline = '');
            card.style.outline = '2px solid #0d6efd';
        });
        card.addEventListener('drop', e => {
            e.preventDefault();
            const dest = parseInt(card.dataset.index);
            if (dragSrcIdx === null || dragSrcIdx === dest) return;
            const moved = multiFiles.splice(dragSrcIdx, 1)[0];
            multiFiles.splice(dest, 0, moved);
            dragSrcIdx = null;
            syncInput();
            renderMulti();
        });

        const img = document.createElement('img');
        img.src = item.url;
        img.style.cssText = 'width:110px;height:80px;object-fit:cover;border-radius:5px 5px 0 0;display:block;pointer-events:none;';

        const labelEl = document.createElement('div');
        labelEl.className = 'badge mt-1 mb-1 d-block mx-1';
        labelEl.style.cssText = 'font-size:9px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;';
        labelEl.classList.add(i < 3 ? (i === 0 ? 'bg-primary' : 'bg-secondary') : 'bg-dark');
        labelEl.textContent = MULTI_LABELS[i] ?? `Slider ${i - 2}`;

        const rem = document.createElement('button');
        rem.type = 'button';
        rem.innerHTML = '&times;';
        rem.style.cssText = 'position:absolute;top:-7px;right:-7px;width:20px;height:20px;border-radius:50%;background:red;color:#fff;border:none;font-size:13px;line-height:18px;cursor:pointer;padding:0;z-index:10;';
        rem.onclick = e => { e.stopPropagation(); removeMultiFile(i); };

        card.appendChild(img);
        card.appendChild(labelEl);
        card.appendChild(rem);
        preview.appendChild(card);
    });

    // "+ Add more" button
    const addBtn = document.createElement('div');
    addBtn.style.cssText = 'width:110px;height:108px;border:1.5px dashed #ced4da;border-radius:6px;display:flex;flex-direction:column;align-items:center;justify-content:center;cursor:pointer;color:#6c757d;font-size:12px;gap:4px;';
    addBtn.innerHTML = '<span style="font-size:22px">+</span><span>Add more</span>';
    addBtn.onclick = () => {
        const inp = document.createElement('input');
        inp.type = 'file'; inp.multiple = true; inp.accept = 'image/*';
        inp.onchange = () => addFiles(inp.files);
        inp.click();
    };
    preview.appendChild(addBtn);
}

</script>
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

    // ── Single image (thumbnail) ───────────────────────────────
    function previewSingle(input, previewId, inputName) {
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

    // ── Video preview ──────────────────────────────────────────
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

    // ── Multiple images ────────────────────────────────────────
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

                // Sync back to input.files via DataTransfer
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