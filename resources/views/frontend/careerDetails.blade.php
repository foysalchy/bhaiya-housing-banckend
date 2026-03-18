@extends('layouts.front')
@section('title', $job->title)
@section('content')

<!-- HERO -->
<section class="relative w-full overflow-hidden py-32" style="background:#1B281F;">
    <div class="container mx-auto px-6 lg:px-14 relative z-10">
        <div class="flex flex-col md:flex-row justify-between">
            <div>
                <h1 class="font-serif italic text-white mb-6"
                    style="font-size:clamp(32px,5vw,72px); font-weight:300;">
                    {{ $job->title }}
                </h1>
                <div style="border-top:1px solid rgba(255, 255, 255, 0.637); width:700px;"></div>
            </div>

            <!-- Meta Right -->
            <div class="mt-8 md:mt-0 space-y-4 text-right">
                @if($job->extra)
                <div>
                    <p class="text-white/50 text-sm">Department</p>
                    <p class="text-white font-medium">{{ $job->extra }}</p>
                </div>
                @endif
                @if($job->location)
                <div>
                    <p class="text-white/50 text-sm">Location</p>
                    <p class="text-white font-medium">{{ $job->location }}</p>
                </div>
                @endif
                @if($job->body_2)
                <div>
                    <p class="text-white/50 text-sm">Job Type</p>
                    <p class="text-white font-medium">{!!  $job->body_2 !!}</p>
                </div>
                @endif
                @if($job->body_3)
                <div>
                    <p class="text-white/50 text-sm">Experience</p>
                    <p class="text-white font-medium">{!! $job->body_3 !!}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- DETAIL + FORM -->
<section class="relative w-full py-20 bg-white">
    <div class="container mx-auto px-6 lg:px-14">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-16">

            <!-- Left: Job Details -->
            <div class="text-gray-700 text-sm leading-relaxed job-body">
                {!! $job->body !!}

                <a href="{{ route('career') }}"
                class="mt-10 inline-block px-8 py-2.5 border border-gray-700 text-sm font-light text-gray-700 tracking-wide transition-all duration-300 hover:bg-gray-900 hover:text-white">
                    Go Back
                </a>
            </div>

            <!-- Right: Apply Form -->
            <div class="relative bg-[#1B281F] p-8 md:p-10">

                <h2 class="font-serif italic text-white mb-10"
                    style="font-size:clamp(28px,4vw,56px); font-weight:300;">
                    Apply For A Role
                </h2>

                @if(session('success'))
                <div class="bg-green-100 text-green-700 text-sm px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
                @endif

                <form action="{{ route('job.apply') }}" method="POST" enctype="multipart/form-data"
                      class="space-y-8">
                    @csrf
                    <input type="hidden" name="content_id" value="{{ $job->id }}">
                    <input type="hidden" name="job_title" value="{{ $job->title }}">

                    <div style="border-bottom:1px solid rgba(255,255,255,0.25);">
                        <input type="text" name="name" placeholder="Your Full Name*"
                               class="w-full bg-transparent text-white text-sm font-light py-3 outline-none placeholder-white/40">
                    </div>

                    <div style="border-bottom:1px solid rgba(255,255,255,0.25);">
                        <input type="tel" name="phone" placeholder="Your Mobile Number*"
                               class="w-full bg-transparent text-white text-sm font-light py-3 outline-none placeholder-white/40">
                    </div>

                    <div style="border-bottom:1px solid rgba(255,255,255,0.25);">
                        <input type="email" name="email" placeholder="Your Email Address*"
                               class="w-full bg-transparent text-white text-sm font-light py-3 outline-none placeholder-white/40">
                    </div>

                    <div style="border-bottom:1px solid rgba(255,255,255,0.25);">
                        <input type="text" name="subject" placeholder="Write Your Subject*"
                               class="w-full bg-transparent text-white text-sm font-light py-3 outline-none placeholder-white/40">
                    </div>

                    <!-- Resume Upload -->
                    <div>
                        <p class="text-white text-sm font-normal mb-3">Upload Your Resume</p>
                        <label for="resumeUpload" class="flex items-center gap-3 cursor-pointer w-fit">
                            <div class="w-12 h-12 rounded-full border border-white/40 flex items-center justify-center hover:border-white hover:bg-white/10 transition-all">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.5">
                                    <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/>
                                    <polyline points="17 8 12 3 7 8"/>
                                    <line x1="12" y1="3" x2="12" y2="15"/>
                                </svg>
                            </div>
                            <span id="fileLabel" class="text-white text-sm font-light opacity-70">Attach Your Resume*</span>
                        </label>
                        <input type="file" id="resumeUpload" name="resume" accept=".pdf" class="hidden"
                               onchange="document.getElementById('fileLabel').textContent = this.files[0]?.name || 'Attach Your Resume*'">
                        <p class="text-white/60 text-xs mt-2">PDF Files Only || Max 2MB</p>
                    </div>

                    <button type="submit"
                            class="px-10 py-3 border border-white text-white text-sm font-light tracking-widest transition-all duration-300 hover:bg-white hover:text-gray-900">
                        Apply Now
                    </button>

                    <p class="text-white/60 text-xs">
                        By applying for this job listing, you agree to our Data Privacy Policy for recruitment and job applications.
                    </p>
                </form>
            </div>

        </div>
    </div>
</section>

@endsection


@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {

        if (typeof fbq !== 'undefined') {
            fbq('track', 'ViewContent', {
                content_name: '{{ addslashes($job->title) }}',
                content_category: 'Job Position',
                content_ids: ['{{ $job->id }}'],
                content_type: 'job'
            });
        }

    });
</script>
@endpush

@push('pixel_events')
    @if(session('success'))
        fbq('track', 'Lead', {
            content_name: '{{ addslashes($job->title) }}',
            content_category: 'Job Application',
            content_ids: ['{{ $job->id }}'],
        });
    @endif
@endpush
