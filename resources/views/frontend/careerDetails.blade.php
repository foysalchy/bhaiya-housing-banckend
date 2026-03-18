@extends('layouts.front')
@section('title', $job->title ?? 'Career Opportunity')
@section('meta')
@php
    $jobTitle = $job->title ?? 'Career Opportunity';
    $pageTitle = $jobTitle . ' – ' . ($setting->title ?? 'Bhaiya Housing Ltd.');
    
    // Create an SEO description from the job short description or body
    $pageDesc = isset($job->short) && !empty($job->short) 
        ? strip_tags($job->short) 
        : Str::limit(strip_tags($job->body ?? 'Join Bhaiya Housing Ltd. and shape the future of real estate in Bangladesh.'), 160);
    
    $pageUrl = url()->current();
    // Default career image or logo
    $pageImage = asset('assets/images/career-hero.jpg');

    // Safe fallback for socials
    $socialLinks = isset($socials) ? $socials->map(fn($s) => $s->url)->filter()->values()->toArray() : [];

    // Attempt to map employment type for Google Jobs (FULL_TIME, PART_TIME, CONTRACTOR, INTERN)
    $rawEmpType = strtoupper(str_replace(['-', ' '], '_', strip_tags($job->body_2 ?? 'FULL_TIME')));
    $validEmpTypes = ['FULL_TIME', 'PART_TIME', 'CONTRACTOR', 'TEMPORARY', 'INTERN', 'VOLUNTEER', 'PER_DIEM', 'OTHER'];
    $employmentType = in_array($rawEmpType, $validEmpTypes) ? $rawEmpType : 'FULL_TIME';

    $schema = [
        "page" => [
            "description" => $pageDesc,
            "keywords" => implode(', ', array_filter([
                $jobTitle,
                'jobs at Bhaiya Housing',
                isset($job->location) ? "jobs in {$job->location}" : null,
                isset($job->extra) ? "{$job->extra} department jobs" : null,
                'real estate career Bangladesh',
                'property developer jobs Dhaka'
            ])),
            "robots" => "index, follow, max-image-preview:large",
            "canonical" => $pageUrl,
        ],
        "openGraph" => [
            "type" => "article",
            "title" => $pageTitle,
            "description" => $pageDesc,
            "url" => $pageUrl,
            "site_name" => $setting->title ?? 'Bhaiya Housing Ltd.',
            "image" => $pageImage,
            "locale" => "en_US",
        ],
        "twitter" => [
            "card" => "summary_large_image",
            "title" => $pageTitle,
            "description" => $pageDesc,
            "image" => $pageImage,
        ],
        "organization" => [
            "@context" => "https://schema.org",
            "@type" => ["RealEstateBuilder", "Organization"],
            "@id" => url('/') . '#organization',
            "name" => $setting->title ?? 'Bhaiya Housing Ltd.',
            "url" => url('/'),
            "logo" => [
                "@type" => "ImageObject",
                "url" => asset('assets/images/logo.png'),
                "width" => 200,
                "height" => 60,
            ],
            "sameAs" => $socialLinks,
        ],
        "webPage" => [
            "@context" => "https://schema.org",
            "@type" => "ItemPage",
            "@id" => $pageUrl . '#webpage',
            "name" => $pageTitle,
            "description" => $pageDesc,
            "url" => $pageUrl,
            "inLanguage" => "en-US",
            "isPartOf" => ["@id" => url('/') . '#website'],
            "about" => ["@id" => url('/') . '#organization'],
            "breadcrumb" => [
                "@type" => "BreadcrumbList",
                "itemListElement" => [
                    ["@type" => "ListItem", "position" => 1, "name" => "Home", "item" => url('/')],
                    ["@type" => "ListItem", "position" => 2, "name" => "Career", "item" => route('career')],
                    ["@type" => "ListItem", "position" => 3, "name" => $jobTitle, "item" => $pageUrl],
                ],
            ],
        ],
        "jobPosting" => [
            "@context" => "https://schema.org",
            "@type" => "JobPosting",
            "title" => $jobTitle,
            // Google prefers HTML for the JobPosting description
            "description" => !empty($job->body) ? $job->body : $pageDesc,
            "datePosted" => isset($job->created_at) ? $job->created_at->toIso8601String() : now()->toIso8601String(),
            "validThrough" => isset($job->created_at) ? $job->created_at->addMonths(2)->toIso8601String() : now()->addMonths(2)->toIso8601String(),
            "employmentType" => $employmentType,
            "hiringOrganization" => [
                "@type" => "Organization",
                "name" => $setting->title ?? 'Bhaiya Housing Ltd.',
                "sameAs" => url('/'),
                "logo" => asset('assets/images/logo.png')
            ],
            "jobLocation" => [
                "@type" => "Place",
                "address" => [
                    "@type" => "PostalAddress",
                    "addressLocality" => $job->location ?? 'Dhaka',
                    "addressCountry" => "BD"
                ]
            ],
        ]
    ];
    
    // Add optional experience requirements if available
    if(isset($job->body_3)) {
        $schema['jobPosting']['experienceRequirements'] = strip_tags($job->body_3);
    }
@endphp

{{-- META --}}
<meta name="description" content="{{ $schema['page']['description'] }}">
<meta name="keywords" content="{{ $schema['page']['keywords'] }}">
<meta name="robots" content="{{ $schema['page']['robots'] }}">
<link rel="canonical" href="{{ $schema['page']['canonical'] }}">

{{-- OPEN GRAPH --}}
<meta property="og:type" content="{{ $schema['openGraph']['type'] }}">
<meta property="og:title" content="{{ $schema['openGraph']['title'] }}">
<meta property="og:description" content="{{ $schema['openGraph']['description'] }}">
<meta property="og:url" content="{{ $schema['openGraph']['url'] }}">
<meta property="og:site_name" content="{{ $schema['openGraph']['site_name'] }}">
<meta property="og:image" content="{{ $schema['openGraph']['image'] }}">
<meta property="og:locale" content="{{ $schema['openGraph']['locale'] }}">

{{-- TWITTER --}}
<meta name="twitter:card" content="{{ $schema['twitter']['card'] }}">
<meta name="twitter:title" content="{{ $schema['twitter']['title'] }}">
<meta name="twitter:description" content="{{ $schema['twitter']['description'] }}">
<meta name="twitter:image" content="{{ $schema['twitter']['image'] }}">

{{-- SCHEMAS --}}
<script type="application/ld+json">
    {!! json_encode($schema['organization'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>

<script type="application/ld+json">
    {!! json_encode($schema['webPage'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>

<script type="application/ld+json">
    {!! json_encode($schema['jobPosting'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
@endsection
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
