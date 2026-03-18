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
                                    <select id="extraStatus" class="form-select form-select-sm">
                                        <option value="ongoing" {{ ($extra['status'] ?? '') === 'ongoing'  ? 'selected' : '' }}>Ongoing</option>
                                        <option value="upcoming" {{ ($extra['status'] ?? '') === 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                                        <option value="complete" {{ ($extra['status'] ?? '') === 'complete' ? 'selected' : '' }}>Complete</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label small">Size</label>
                                    <input type="text" id="extraSize" class="form-control form-control-sm"
                                        value="{{ $extra['size'] ?? '' }}" placeholder="2850 sft (Approx)">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label small">Building Height</label>
                                    <input type="text" id="extraHeight" class="form-control form-control-sm"
                                        value="{{ $extra['building_height'] ?? '' }}" placeholder="G+M+8">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label small">Facing</label>
                                    <select id="extraFacing" class="form-select form-select-sm">
                                        <option value="">-- Select --</option>
                                        @foreach(['North','South','East','West','North-East','North-West'] as $dir)
                                        <option value="{{ $dir }}" {{ ($extra['facing'] ?? '') === $dir ? 'selected' : '' }}>{{ $dir }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label small">Google Map Embed URL</label>
                                    <input type="text" id="extraMap" class="form-control form-control-sm"
                                        value="{{ $extra['map_url'] ?? '' }}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label small">Featured?</label>
                                    <select id="extraFeatured" class="form-select form-select-sm">
                                        <option value="false" {{ empty($extra['featured']) ? 'selected' : '' }}>No</option>
                                        <option value="true" {{ !empty($extra['featured']) ? 'selected' : '' }}>Yes</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3 d-flex align-items-end">
                                    <button type="button" class="btn btn-sm btn-outline-success w-100" onclick="buildExtra()">
                                        ⚙️ Generate JSON
                                    </button>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small">Generated JSON</label>
                                <textarea class="form-control form-control-sm font-monospace" name="extra" id="extraJson" rows="2">{{ $content->extra }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Descriptions --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea class="editor form-control" name="body" rows="4">{!! $content->body !!}</textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Description Box 2</label>
                        <textarea class="editor form-control" name="body_2" rows="4">{!! $content->body_2 !!}</textarea>
                    </div>
                </div>

                {{-- Thumbnail --}}
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Thumbnail Image</label>
                        @if($content->img_path)
                        <div class="mb-2">
                            <img src="{{ asset($content->img_path) }}" style="height:80px; border-radius:4px; border:1px solid #dee2e6;">
                            <div class="badge bg-secondary mt-1">Current</div>
                        </div>
                        @endif
                        <input type="file" class="form-control" name="img_path" accept="image/*"
                            onchange="previewImage(this, 'thumbPreview')">
                        <div class="mt-2" id="thumbPreview"></div>
                    </div>

                    {{-- Video --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Video</label>
                        @if($content->video_path)
                        <div class="mb-2">
                            <span class="badge bg-secondary">Current: {{ basename($content->video_path) }}</span>
                        </div>
                        @endif
                        <input type="file" class="form-control" name="video_path" accept="video/mp4">
                        <small class="text-muted">If you don’t upload a new file, the previous one will remain.</small>
                    </div>
                </div>

                {{-- Multiple Images --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Multiple Images</label>

                    {{-- Current images --}}
                    @if(!empty($imgPaths) && count($imgPaths) > 0)

                    <div class="d-flex gap-2 flex-wrap mb-2">
                        @foreach($imgPaths as $i => $img)
                        @php
                        $labels = ['1st: At a Glance', '2nd: Gallery Left', '3rd: Gallery Right'];
                        $label = $labels[$i] ?? 'Slider ' . ($i - 2);
                        @endphp
                        <div style="text-align:center;">
                            <img src="{{ asset($img) }}" style="height:80px; width:100px; object-fit:cover; border-radius:4px; border:1px solid #dee2e6;">
                            <div class="badge bg-secondary mt-1 d-block" style="font-size:10px; max-width:100px;">{{ $label }}</div>
                        </div>
                        @endforeach
                    </div>
                    <small class="text-muted d-block mb-2">
                        If you upload new files, all existing ones will be replaced. If not, the previous ones will remain.
                    </small> @endif

                    <input type="file" multiple class="form-control" name="img_paths[]" accept="image/*"
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
                        <small class="fw-semibold">🔍 SEO (optional)</small>
                    </div>
                    <div class="collapse" id="seoSection">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label small">Meta Title</label>
                                    <input type="text" class="form-control form-control-sm" name="meta_title" value="{{ $content->meta_title }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label small">Meta Keywords</label>
                                    <input type="text" class="form-control form-control-sm" name="meta_keywords" value="{{ $content->meta_keywords }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label small">Meta Description</label>
                                    <textarea class="form-control form-control-sm" name="meta_description" rows="2">{{ $content->meta_description }}</textarea>
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
<script>
    $(document).ready(function() {
        $('.editor').summernote({
            height: 200
        });
    });

    function buildExtra() {
        const json = {
            status: document.getElementById('extraStatus').value,
            size: document.getElementById('extraSize').value,
            building_height: document.getElementById('extraHeight').value,
            facing: document.getElementById('extraFacing').value,
            featured: document.getElementById('extraFeatured').value === 'true',
            map_url: document.getElementById('extraMap').value,
        };
        document.getElementById('extraJson').value = JSON.stringify(json, null, 2);
    }

    ['extraStatus', 'extraSize', 'extraHeight', 'extraFacing', 'extraFeatured', 'extraMap']
    .forEach(id => document.getElementById(id)
        ?.addEventListener('input', buildExtra));

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