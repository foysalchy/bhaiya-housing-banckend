@extends('layouts.backend')
@section('title', 'Create Project')
@section('content')

<div class="container mt-2">
    <form action="{{ route('content.store') }}" method="POST" enctype="multipart/form-data">
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
                        <input type="text" class="form-control" name="title" required placeholder="e.g. Kazi Kuthi">
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

                {{-- Row 2: Location --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Location / Address <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="location" required placeholder="e.g. Plot:8, Road:5, Bashundhara R/A, Dhaka">
                </div>

                {{-- Row 3: Extra JSON helper --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Project Details</label>
                    <div class="card bg-light border">
                        <div class="card-body pb-0">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label small">Project Status</label>
                                    <select id="extraStatus" class="form-select form-select-sm">
                                        <option value="ongoing">Ongoing</option>
                                        <option value="upcoming">Upcoming</option>
                                        <option value="complete">Complete</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label small">Size (e.g. 2850 sft)</label>
                                    <input type="text" id="extraSize" class="form-control form-control-sm" placeholder="2850 sft (Approx)">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label small">Building Height (e.g. G+M+8)</label>
                                    <input type="text" id="extraHeight" class="form-control form-control-sm" placeholder="G+M+8">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label small">Facing</label>
                                    <select id="extraFacing" class="form-select form-select-sm">
                                        <option value="">-- Select --</option>
                                        <option value="North">North</option>
                                        <option value="South">South</option>
                                        <option value="East">East</option>
                                        <option value="West">West</option>
                                        <option value="North-East">North-East</option>
                                        <option value="North-West">North-West</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small">Google Map Embed URL</label>
                                    <input type="text" id="extraMap" class="form-control form-control-sm" placeholder="https://www.google.com/maps/embed?pb=...">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label small">Featured?</label>
                                    <select id="extraFeatured" class="form-select form-select-sm">
                                        <option value="false">No</option>
                                        <option value="true">Yes</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3 d-flex align-items-end">
                                    <button type="button" class="btn btn-sm btn-outline-success w-100" onclick="buildExtra()">
                                        ⚙️ Generate JSON
                                    </button>
                                </div>
                            </div>
                            {{-- Preview --}}
                            <div class="mb-3">
                                <label class="form-label small">Generated JSON <small class="text-muted">(auto-filled)</small></label>
                                <textarea class="form-control form-control-sm font-monospace" name="extra" id="extraJson" rows="2" placeholder='{"status":"ongoing","size":"","building_height":"","facing":"","featured":false,"map_url":""}'></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Row 4: Descriptions --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea class="editor form-control" name="body" rows="4"></textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Description Box 2</label>
                        <textarea class="editor form-control" name="body_2" rows="4"></textarea>
                    </div>
                </div>

                {{-- Row 5: Images --}}
                <div class="row">

                    {{-- Thumbnail --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Thumbnail Image <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" name="img_path" required accept="image/*"
                            onchange="previewImage(this, 'thumbPreview')">
                        <div class="mt-2" id="thumbPreview"></div>
                    </div>

                    {{-- Video --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Video</label>
                        <input type="file" class="form-control" name="video_path" accept="video/mp4">
                        <small class="text-muted">MP4 format, max 50MB</small>
                    </div>

                </div>

                {{-- Multiple Images with hint --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Multiple Images</label>
                    <input type="file" multiple class="form-control" name="img_paths[]" accept="image/*"
                        onchange="previewMultiple(this)">
                    <div class="mt-1 d-flex gap-2 flex-wrap align-items-start">
                        <span class="badge bg-primary">1st image → At a Glance (Right side)</span>
                        <span class="badge bg-secondary">2nd image → Gallery Left</span>
                        <span class="badge bg-secondary">3rd image → Gallery Right</span>
                        <span class="badge bg-dark">4th+ images → Slider</span>
                    </div>
                    <div class="mt-2 d-flex gap-2 flex-wrap" id="multiPreview"></div>
                </div>

                {{-- SEO --}}
                <div class="card border mt-3">
                    <div class="card-header bg-light py-2 cursor-pointer" data-bs-toggle="collapse" data-bs-target="#seoSection">
                        <small class="fw-semibold">🔍 SEO (optional — click to expand)</small>
                    </div>
                    <div class="collapse" id="seoSection">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label small">Meta Title</label>
                                    <input type="text" class="form-control form-control-sm" name="meta_title">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label small">Meta Keywords</label>
                                    <input type="text" class="form-control form-control-sm" name="meta_keywords">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label small">Meta Description</label>
                                    <textarea class="form-control form-control-sm" name="meta_description" rows="2"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-success px-5">
                    Save Project
                </button>
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

    function previewMultiple(input) {
        const preview = document.getElementById('multiPreview');
        preview.innerHTML = '';
        const labels = ['1st: At a Glance', '2nd: Gallery Left', '3rd: Gallery Right'];
        Array.from(input.files).forEach((file, i) => {
            const wrap = document.createElement('div');
            wrap.style.cssText = 'text-align:center;';
            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.style.cssText = 'height:80px; width:100px; object-fit:cover; border-radius:4px; border:1px solid #dee2e6;';
            const label = document.createElement('div');
            label.className = 'badge bg-secondary mt-1 d-block';
            label.style.cssText = 'font-size:10px; max-width:100px;';
            label.textContent = labels[i] ?? `Slider ${i - 2}`;
            wrap.appendChild(img);
            wrap.appendChild(label);
            preview.appendChild(wrap);
        });
    }
</script>
@endpush