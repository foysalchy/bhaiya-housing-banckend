@extends('layouts.front')

@section('title', 'Career Opportunities')
@section('meta')
@php
$pageTitle = 'Career Opportunities – ' . ($setting->title ?? 'Bhaiya Housing Ltd.');

// Create a compelling SEO description for the career page
$pageDesc = isset($careerOverview->short) && !empty($careerOverview->short)
? Str::limit(strip_tags($careerOverview->short), 160)
: 'Join the dynamic team at Bhaiya Housing Ltd. Explore available job positions, build your career, and shape the future of real estate development in Bangladesh.';

$pageUrl = url()->current();
$pageImage = isset($career->img_path) ? asset($career->img_path) : asset('assets/images/career-hero.jpg');

// Safe fallback for socials
$socialLinks = isset($socials) ? $socials->map(fn($s) => $s->url)->filter()->values()->toArray() : [];

$schema = [
"page" => [
"description" => $pageDesc,
"keywords" => implode(', ', [
'Bhaiya Housing careers',
'real estate jobs Bangladesh',
'property development jobs Dhaka',
'Bhaiya Group job circular',
'hiring real estate professionals BD',
'construction jobs Bangladesh',
'corporate careers Dhaka'
]),
"robots" => "index, follow, max-image-preview:large",
"canonical" => $pageUrl,
],
"openGraph" => [
"type" => "website",
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
"@type" => "WebPage",
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
["@type" => "ListItem", "position" => 2, "name" => "Career", "item" => $pageUrl],
],
],
]
];

// Generate JobPosting schemas for Google Jobs optimization
$jobSchemas = [];
if(isset($jobPositions) && count($jobPositions) > 0) {
foreach($jobPositions as $job) {
$jobSchemas[] = [
"@context" => "https://schema.org",
"@type" => "JobPosting",
"title" => $job->title ?? 'Real Estate Professional',
"description" => isset($job->short) ? strip_tags($job->short) : 'Join the team at Bhaiya Housing Ltd.',
"datePosted" => isset($job->created_at) ? $job->created_at->toIso8601String() : now()->toIso8601String(),
"employmentType" => "FULL_TIME",
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
"addressLocality" => "Dhaka",
"addressCountry" => "BD"
]
],
];
}
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
    {
        !!json_encode($schema['organization'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!
    }
</script>

<script type="application/ld+json">
    {
        !!json_encode($schema['webPage'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!
    }
</script>

@if(!empty($jobSchemas))
@foreach($jobSchemas as $jobSchema)
<script type="application/ld+json">
    {
        !!json_encode($jobSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!
    }
</script>
@endforeach
@endif
@endsection

@section('content')

<main class="">
    <!-- ===== HERO ===== -->
    <section class="fixed hero-fixed  top-0 left-0 w-full z-0 overflow-hidden
                h-[600px] md:h-[700px] lg:h-[900px]">
        <!-- Background Image -->
        <img src="{{ asset($career->img_path ?? '') }}"
            alt="interior"
            class="absolute inset-0 w-full h-full object-cover">

        <!-- Dark Overlay -->
        <div class="absolute inset-0 bg-black/50"></div>

        <!-- Text -->
    <div class="absolute inset-0 flex items-center px-6 sm:px-10 md:px-20">
    <h2 class="text-white font-semibold pl-4 sm:pl-8 md:pl-12 pt-16 sm:pt-24 md:pt-32"
        style="font-size: clamp(32px, 3.85vw, 90px); line-height: 1.2;">
        {!! $career->title ?? '' !!}
    </h2>
</div>

    </section>
    <div class="h-[600px] md:h-[700px] lg:h-[900px] w-full pointer-events-none"
        style="position: relative; z-index: 2;"></div>

    <!-- Career Section -->
    <section class="relative z-10 w-full overflow-hidden py-16 bg-[#F6F6F6]">

        <!-- Background Decoration Image (Full width) -->
        <div class="absolute inset-0 pointer-events-none z-0">
            <img src="{{ asset('images/career-bg.png') }}" alt="" class="w-full h-full object-cover opacity-70">
        </div>

        <div class="overview mb-10">
            @php
            $overviewImages = is_array($careerOverview?->img_paths)
            ? $careerOverview->img_paths
            : json_decode($careerOverview?->img_paths ?? '[]', true);
            $rightImg = $overviewImages[0] ?? null;
            @endphp

            <div class="relative z-10 container mx-auto  ">

                <!-- Row 1: Two text columns -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-16 mb-16">
                    <div class="text-lg font-normal text-gray-700 leading-relaxed pl-20">
                        {!! $careerOverview?->short ?? '' !!}
                    </div>
                    <div class="text-md font-normal text-gray-700 leading-relaxed">
                        {!! $careerOverview?->body ?? '' !!}
                    </div>
                </div>

                <!-- Row 2: Left small image + Right large image -->
                <div class="flex flex-col md:flex-row gap-10 items-start">

                    <!-- Left image container with Stones -->
                    <div class="relative w-full md:w-4/12 flex-shrink-0">
                        <!-- Main Image -->
                        @if($careerOverview?->img_path)
                        <div class="relative z-10">
                            <img src="{{ asset($careerOverview->img_path) }}" alt="Career"
                                class="w-full object-cover shadow-sm"
                                style="height: 450px;">
                        </div>
                        @endif

                        <!-- Gold Splash Image (contact-stone-bg.png) - ছবির নিচে এবং বামে থাকবে -->
                        <img src="{{ asset('images/contact-stone-bg.png') }}" alt=""
                            class="absolute pointer-events-none scroll-move" data-axis="Y"
                            style="width: 140px; bottom: -40px; left: -60px; z-index: 5;">

                        <!-- Black Stone Image (mission-stone.png) - একদম কোণায় উপরে থাকবে -->
                        <img src="{{ asset('images/mission-stone.png') }}" alt=""
                            class="absolute pointer-events-none scroll-move" data-axis="Y"
                            style="width: 80px; bottom: -10px; left: -20px; z-index: 20;"
                            onerror="this.style.display='none';">
                    </div>

                    <!-- Right large image -->
                    <div class="w-full md:w-8/12">
                        @if($rightImg)
                        <img src="{{ asset($rightImg) }}" alt="Office"
                            class="w-full object-cover scroll-move" data-axis="Y"
                            style="height: 450px;">
                        @endif
                    </div>
                </div>

                <!-- Row 3: Bottom paragraph - Align with the second image -->
                @if($careerOverview?->body_2)
                <div class="mt-12 md:ml-[36%] lg:ml-[35%]">
                    <div class="text-[15px] font-normal text-gray-700 leading-relaxed max-w-[750px]">
                        {!! $careerOverview->body_2 !!}
                    </div>
                </div>
                @endif

            </div>
        </div>
        <!-- Available Job Positions -->
        <div class="job-position">
            <div class="absolute inset-0 pointer-events-none z-0">
                <img src="{{ asset('images/career-bg.png') }}" alt=""
                    class="w-full h-full object-cover opacity-10"
                    onerror="this.style.display='none';">
            </div>

            <div class="absolute bottom-0 right-0 pointer-events-none z-0">
                <img src="{{ asset('images/stone2.png') }}" alt=""
                    style="width:120px; opacity:0.85;"
                    onerror="this.style.display='none';">
            </div>

            <div class="relative z-10 container mx-auto px-6 lg:px-14">

                <!-- Heading -->
                <h2 class="font-light text-gray-900 mb-12"
                    style="font-size:clamp(28px,4.5vw,64px); font-weight:300;">
                    Available job positions
                </h2>

                <!-- Job List -->
                <div class="md:ml-[28%]">

                    @foreach($jobPositions as $job)
                    <div class="py-6" style="border-top:1px solid #c8c0b4;">
                        <h2 class="text-gray-800 font-normal mb-1"
                            style="font-size:clamp(18px,2vw,34px); font-weight:400;">
                            {{ $job->title ??'' }}
                        </h2>
                        <p class="text-lg font-light text-gray-500 leading-loose mb-6" style="line-height:1.4;">
                            {!! $job->short ??'' !!}
                        </p>
                        <a href="{{ route('job.details', $job->name) }}"
                            class="mt-0 inline-block px-8 py-2.5 border border-gray-700 text-md font-light text-gray-700 tracking-wide transition-all duration-300 hover:bg-gray-900 hover:text-white hover:border-gray-900">
                            Apply Now
                        </a>
                    </div>
                    @endforeach
                    <div class=" absolute pointer-events-none scroll-move" data-axis="Y"

                        style="right:-140px; bottom:-60px; z-index:3;">
                        <img src="/assets/images/overview-stone.png" alt=""
                            style="height:220px;width: 220px; " />
                    </div>
                    <!-- Bottom border -->
                    <div style="border-top:1px solid #c8c0b4;"></div>

                </div>
            </div>
        </div>

    </section>
   
    <!-- Apply For A Role Section -->
    <section class="relative w-full overflow-hidden py-20" style="background:#1B281F;">

        <div class="absolute inset-0 pointer-events-none z-0">
            <img src="{{ asset('images/form-bg.png') }}" alt=""
                class="w-full h-full object-cover opacity-20"
                onerror="this.style.display='none';">
        </div>

        <div class="relative z-10 container mx-auto px-6 lg:px-14">

            <h2 class="text-white font-semibold mb-14"
                style="font-size:clamp(36px,6vw,80px); font-weight:600; letter-spacing:-0.01em;">
                Apply For A Role
            </h2>

            @if(session('success'))
            <div class="bg-green-100 text-green-700 text-sm px-4 py-3 rounded mb-8">
                {{ session('success') }}
            </div>
            @endif

            <form action="{{ route('job.apply') }}" method="POST" enctype="multipart/form-data"
                class="space-y-10">
                @csrf

                <!-- Row 1: Full Name + Mobile -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-10">
                    <div style="border-bottom:1px solid rgba(255,255,255,0.25);">
                        <input type="text" name="name" placeholder="Your Full Name*"
                            class="w-full bg-transparent text-white text-sm font-light py-3 outline-none placeholder-white/40">
                    </div>
                    <div style="border-bottom:1px solid rgba(255,255,255,0.25);">
                        <input type="tel" name="phone" placeholder="Your Mobile Number*"
                            class="w-full bg-transparent text-white text-sm font-light py-3 outline-none placeholder-white/40">
                    </div>
                </div>

                <!-- Row 2: Email + Subject -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-10">
                    <div style="border-bottom:1px solid rgba(255,255,255,0.25);">
                        <input type="email" name="email" placeholder="Your Email Address*"
                            class="w-full bg-transparent text-white text-sm font-light py-3 outline-none placeholder-white/40">
                    </div>
                    <div style="border-bottom:1px solid rgba(255,255,255,0.25);">
                        <input type="text" name="subject" placeholder="Write Your Subject*"
                            class="w-full bg-transparent text-white text-sm font-light py-3 outline-none placeholder-white/40">
                    </div>
                </div>

                <!-- Row 3: Job Select -->
                <div style="border-bottom:1px solid rgba(255,255,255,0.25);">
                    <label for="job_position" class="sr-only">Select a Position</label>
                    <select id="job_position" name="content_id"
                        class="w-full bg-transparent text-white text-sm font-light py-3 outline-none appearance-none cursor-pointer"
                        style="background-color: transparent;">
                        <option value="" class="bg-[#1B281F] text-white/40">Select a Position*</option>
                        @foreach($jobList as $job)
                        <option value="{{ $job->id }}" class="bg-[#1B281F] text-white">
                            {{ $job->title }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Row 4: Upload Resume -->
                <div>
                    <div class="flex items-center gap-4 mb-4">
                        <p class="text-white text-sm font-normal">Upload Your Resume</p>
                        <p class="text-white/40 text-xs font-light">PDF Files Only || Max 2MB</p>
                    </div>
                    <label for="resumeUpload" class="flex items-center gap-3 cursor-pointer w-fit">
                        <div class="w-12 h-12 rounded-full border border-white/40 flex items-center justify-center transition-all duration-300 hover:border-white hover:bg-white/10">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4" />
                                <polyline points="17 8 12 3 7 8" />
                                <line x1="12" y1="3" x2="12" y2="15" />
                            </svg>
                        </div>
                        <span id="fileLabel" class="text-white text-sm font-light opacity-70">Attach Your Resume*</span>
                    </label>
                    <input type="file" id="resumeUpload" name="resume" accept=".pdf" class="hidden"
                        onchange="document.getElementById('fileLabel').textContent = this.files[0]?.name || 'Attach Your Resume*'">
                </div>

                <!-- Submit -->
                <div class="pt-2">
                    <button type="submit"
                        class="px-10 py-3 border border-white text-white text-sm font-light tracking-widest transition-all duration-300 hover:bg-white hover:text-gray-900">
                        Apply Now
                    </button>
                </div>

            </form>
        </div>
          <div class=" absolute pointer-events-none scroll-move z-[1000]" data-axis="Y"

                        style="left:-140px; bottom:-60px;">
                        <img src="/assets/images/overview-stone.png" alt=""
                            style="height:220px;width: 220px; " />
                    </div>
    </section>


</main>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {

        if (typeof fbq !== 'undefined') {
            fbq('track', 'ViewContent', {
                content_name: 'Career Page',
                content_category: 'Career',
            });
        }

    });
</script>
@endpush

@push('pixel_events')
@if(session('success'))
fbq('track', 'Lead', {
content_name: 'Job Application',
content_category: 'Career',
});
@endif
@endpush