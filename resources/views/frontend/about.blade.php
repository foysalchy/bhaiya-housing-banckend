@extends('layouts.front')

@section('title', 'About Us & Our Legacy')
@section('meta')
@php
$pageTitle = 'About Us & Our Legacy – ' . ($setting->title ?? 'Bhaiya Housing Ltd.');

// Create a strong SEO description based on the 'About' section, with a solid fallback
$pageDesc = isset($about->body) && !empty($about->body)
? Str::limit(strip_tags($about->body), 155)
: 'Learn about Bhaiya Housing Ltd., our mission, vision, and rich history. Discover the visionary leaders driving premium real estate development across Bangladesh.';

$pageUrl = url()->current();
$pageImage = isset($about->img_path) ? asset($about->img_path) : asset('assets/images/about-hero.jpg');

// Safe fallback for socials
$socialLinks = isset($socials) ? $socials->map(fn($s) => $s->url)->filter()->values()->toArray() : [];

// Safely collect leaders and visionaries for Person Schema
$people = collect();
if(isset($leaders)) $people = $people->merge($leaders);
if(isset($visionaries)) $people = $people->merge($visionaries);
$people = $people->unique('name')->values();

$schema = [
"page" => [
"description" => $pageDesc,
"keywords" => implode(', ', [
'About Bhaiya Housing',
'Bhaiya Group Bangladesh',
'real estate developer history Dhaka',
'top housing companies BD',
'mission and vision real estate',
'Bhaiya Housing directors',
'property developers in Bangladesh'
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
"alternateName" => "Bhaiya Group",
"url" => url('/'),
"logo" => [
"@type" => "ImageObject",
"url" => asset('assets/images/logo.png'),
"width" => 200,
"height" => 60,
],
"description" => $pageDesc,
"foundingDate" => isset($timelineItems) ? ($timelineItems->first()?->title ?? '2012') : '2012',
"address" => [
"@type" => "PostalAddress",
"streetAddress" => $setting->short ?? 'Dhaka, Bangladesh',
"addressLocality" => "Dhaka",
"addressCountry" => "BD"
],
"sameAs" => $socialLinks,
],
"webPage" => [
"@context" => "https://schema.org",
"@type" => "AboutPage",
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
["@type" => "ListItem", "position" => 2, "name" => "About Us", "item" => $pageUrl],
],
],
],
"leadership" => [
"@context" => "https://schema.org",
"@type" => "ItemList",
"name" => "Leadership and Visionaries of Bhaiya Housing",
"url" => $pageUrl,
"numberOfItems" => $people->count(),
"itemListElement" => $people->map(fn($person, $i) => [
"@type" => "ListItem",
"position" => $i + 1,
"item" => [
"@type" => "Person",
"name" => $person->name ?? $person->title ?? 'Leader',
"jobTitle" => $person->title ?? 'Executive',
"worksFor" => ["@id" => url('/') . '#organization'],
"image" => isset($person->img_path) ? asset($person->img_path) : $pageImage,
],
])->values()->toArray(),
],
];
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

@if($people->count() > 0)
<script type="application/ld+json">
    {
        !!json_encode($schema['leadership'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!
    }
</script>
@endif
@endsection

@section('content')


<!-- HERO ABOUT SECTION -->
<style>
    * {
        box-sizing: border-box !important;
    }

    body,
    html {
        overflow-x: hidden !important;
        margin: 0 !important;
        padding: 0 !important;
    }
</style>

<section class="relative w-full" style="min-height: 400px; height: clamp(400px, 45vw, 560px); margin: 0; padding: 0; left: 0; position: relative;">
    <img src="{{ asset($about->img_path ?? '') }}" alt="{{ $about->title ?? 'About' }}"
        class="absolute inset-0 w-full h-full object-cover object-center" />
    <div class="absolute inset-0 bg-black/55"></div>

    <div class="container m-auto mx-auto absolute inset-0 flex flex-col justify-center"
        style="padding-top: 88px;  ">

        <h2 data-aos="fade-up" data-aos-duration="1000"
            class="text-white leading-tight"
            style="font-size: clamp(22px, 4.5vw, 72px);">
            Building <span class="font-migra-italic">quality</span> spaces with
            <span class="font-migra-italic">excellence & dedication</span>
        </h2>

        @if ($about->body || $about->body_2)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6 mt-6 md:mt-12 mb-8 md:mb-16">
            @if ($about->body)
            <div data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                <style>
                    .about-body-1,
                    .about-body-1 * {
                        color: white !important;
                    }
                </style>
                <div class="about-body-1 leading-relaxed font-medium pl-0 sm:pl-8 md:pl-16"
                    style="font-size: clamp(12px, 1.2vw, 18px);">
                    {!! $about->body !!}
                </div>
            </div>
            @endif
            @if ($about->body_2)
            <div data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
                <style>
                    .about-body-2,
                    .about-body-2 * {
                        color: white !important;
                    }
                </style>
                <div class="about-body-2 leading-relaxed font-medium"
                    style="font-size: clamp(12px, 1.2vw, 18px);">
                    {!! $about->body_2 !!}
                </div>
            </div>
            @endif
        </div>
        @endif
    </div>
</section>


<!-- ===== MISSION & VISION SECTION ===== -->
<section class="relative w-full z-10   py-16 md:py-20 lg:py-32">

    <!-- Split Background -->
    <div class="absolute inset-0 z-0 flex">
        <div class="hidden md:block md:w-1/2 bg-white"></div>
        <div class="w-full md:w-1/2 relative bg-white">
            @if ($missionVision?->img_path)
            <img src="{{ asset($missionVision->img_path) }}" alt="Mission Vision Background"
                class="w-full h-full object-cover">
            @endif
        </div>
    </div>

    @php
    $mvImages = is_array($missionVision?->img_paths)
    ? $missionVision->img_paths
    : json_decode($missionVision?->img_paths ?? '[]', true);
    $leftImg = $mvImages[2] ?? null;
    $topRightImg = $mvImages[1] ?? null;
    $bottomRightImg = $mvImages[0] ?? null;
    @endphp

    <div class="relative w-full px-4 sm:px-6 md:pr-[8%] md:pl-0">

        <!-- IMAGE GRID -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6">

            <!-- Left Vertical Image -->
            <div class="md:col-span-4 relative md:-mt-64 z-10 scroll-move"
                data-axis="Y" data-aos="fade-up" data-aos-duration="1000">
                @if ($leftImg)
                <img src="{{ asset($leftImg) }}" alt="Left Image"
                    class="w-full h-auto object-cover shadow-sm">
                @endif
            </div>

            <!-- Right Column -->
            <div class="md:col-span-8 flex flex-col relative">

                @if ($topRightImg)
                <div class="w-full md:w-[85%] lg:w-[75%] self-end relative md:-mt-56"
                    data-aos="fade-left" data-aos-duration="1200">

                    <img src="{{ asset($topRightImg) }}" alt="right image top"
                        class="w-full h-auto object-cover shadow-sm">

                    <!-- Stone decoration — hidden on small screens to prevent overflow -->
                    <div class="hidden sm:block absolute -bottom-16 md:-bottom-24 -left-8 md:-left-16 scroll-move z-[100]"
                        data-axis="Y"
                        style="width: clamp(90px, 7vw, 160px); height: auto;">
                        <img src="{{ asset('images/mission-stone.png') }}" alt="mission-stone"
                            class="w-full h-auto object-contain drop-shadow-lg relative">
                        <div class="w-8 h-8 md:w-12 md:h-12 absolute top-0 left-0">
                            <img src="{{ asset('images/stone-bg.svg') }}" alt="stone-bg"
                                class="w-full h-full object-contain">
                        </div>
                    </div>
                </div>
                @endif

                <!-- Heading -->
                <div class="mt-16 md:mt-32 md:ml-12 relative z-20"
                    data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                    <h2 class="text-3xl md:text-5xl lg:text-7xl text-[#595959] leading-snug tracking-tight">
                        {!! $missionVision->title ?? '' !!}
                    </h2>
                </div>

                @if ($bottomRightImg)
                <div class="w-full sm:w-[70%] md:w-[50%] lg:w-[45%] self-end relative z-30 mb-12 md:mb-20"
                    data-aos="fade-up" data-aos-duration="1200">
                    <div class="relative scroll-move" data-axis="Y">

                        <img src="{{ asset($bottomRightImg) }}" alt="right bottom image"
                            class="w-full h-auto object-cover shadow-sm">

                        <!-- Stone decoration — hidden on small screens -->
                        <div class="hidden sm:block absolute -bottom-6 md:-bottom-8 -right-6 md:-right-12 z-[999] scroll-move"
                            data-axis="Y">
                            <img src="{{ asset('images/mission-stone-bottom.png') }}"
                                alt="mission-stone-bottom"
                                class="object-contain drop-shadow-md relative z-[999]"
                                style="width: clamp(90px, 7vw, 160px); height: auto;">
                        </div>
                    </div>
                </div>
                @endif

            </div><!-- end right column -->
        </div><!-- end image grid -->
    </div>

    <!-- Mission & Vision Text -->
    <div class="grid grid-cols-1 md:grid-cols-12 gap-10 relative z-40 mt-2
                px-4 sm:px-[6%] md:pl-[8%] md:pr-[4%] " style="margin-top: -100px;">

        <!-- Mission -->
        <div class="md:col-span-6 relative" data-aos="fade-right">
            <h2 class="italic leading-none text-[#1520187D] absolute z-0 opacity-40
                        -top-10 md:-top-20 -left-1 md:-left-6
                        text-[2rem] sm:text-[2.5rem] md:text-[4rem] lg:text-[6rem] " style="font-family: 'Migra', serif;">
                {{ $missionVision?->name ?? 'Mission' }}
            </h2>
            <div class="relative z-10 pt-4 md:pt-16">
                <p class="text-gray-700 font-light text-sm md:text-lg leading-relaxed max-w-2xl">
                    {!! $missionVision->body ?? '' !!}
                </p>
            </div>
        </div>

        <!-- Vision -->
        <div class="md:col-span-6 relative mt-12 md:mt-48" data-aos="fade-left">
            <h2 class="italic leading-none text-[#1520187D] absolute z-0 opacity-40
                        -top-10 md:-top-20 -left-1 md:-left-6
                        text-[2rem] sm:text-[2.5rem] md:text-[4rem] lg:text-[6rem]" style="font-family: 'Migra', serif;">
                {{ $missionVision?->short ?? 'Vision' }}
            </h2>
            <div class="relative z-10 pt-4 md:pt-16">
                <p class="text-gray-700 font-light text-sm md:text-lg leading-relaxed max-w-2xl
                           pl-0 sm:pl-6 md:pl-12">
                    {!! $missionVision->body_2 ?? '' !!}
                </p>
            </div>
        </div>

    </div>

    <!-- "History" large text -->
    <div class="hidden md:block relative md:absolute md:bottom-16 left-0 px-4 sm:px-6 md:left-20 lg:left-32
            z-20 md:translate-y-1/2 leading-none pointer-events-none mt-12 md:mt-0">
        <span class="font-semibold tracking-tight leading-none text-[#262E35]
                 text-[2.5rem] sm:text-[3.5rem] md:text-[80px] lg:text-[120px] xl:text-[153px]">
            History
        </span>
    </div>

</section>

<!-- ===== TIMELINE SECTION ===== -->
<section id="timeline-section" style="background: #20281D;"
    class="relative w-full min-h-screen flex flex-col justify-between overflow-hidden text-white py-12 md:py-16 px-4 sm:px-6 md:px-20 lg:px-32">

    <div class="relative z-10 w-full -mt-8 md:-mt-16 md:-mt-20" data-aos="fade-down">
        <h2 class="font-semibold tracking-tight leading-none text-[#f6f6f6] opacity-90
                   text-5xl sm:text-7xl md:text-[120px] lg:text-[153px]">
            <span class="block md:hidden  mt-1"> <br>
                History
            </span>
            Timeline
        </h2>

       
    </div>
    <!-- Background Image -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/timeline-bg.avif') }}" alt="Background"
            class="w-full h-full object-cover  ">
    </div>



    <!-- 2. Middle Content -->
    <div class="relative z-10 flex flex-col md:flex-row items-center justify-center mt-8 md:mt-10 gap-8 md:gap-0">

        <!-- Image & Year -->
        <div class="relative flex items-center justify-center w-full md:w-auto">
            <div class="relative z-10" data-aos="zoom-in" data-aos-duration="1200">
                <div class="transform -rotate-6">
                    <div class="w-[220px] h-[280px] sm:w-[280px] sm:h-[350px] md:w-[380px] md:h-[430px]  overflow-hidden shadow-2xl border-4 border-zinc-800 bg-zinc-900">
                        <img id="timeline-img"
                            src="{{ $timelineItems->first()?->img_path ? asset($timelineItems->first()->img_path) : '' }}"
                            alt="Timeline"
                            class="w-full h-full opacity-50 object-cover">
                    </div>
                </div>
            </div>

            <h1 id="timeline-year"
                class="absolute z-20 top-0 left-24 sm:left-32 md:left-48 lg:left-64 text-[4rem] sm:text-[6rem] md:text-[9rem] lg:text-[11rem] font-bold leading-none text-gray-300 opacity-90 select-none tracking-tighter transition-all duration-700 pointer-events-none">
                {{ $timelineItems->first()?->title }}
            </h1>
        </div>

        <!-- Description -->
        <div id="content-wrap"
            class="relative z-30 w-full md:max-w-[40%] md:mt-40  px-2 md:px-0 transition-all duration-500 ml-12">
            <h2 id="timeline-title" class="text-2xl sm:text-3xl md:text-4xl   mb-1 md:mb-2 mt-16 text-white leading-tight">
                {!! nl2br(e($timelineItems->first()?->name ?? '')) !!}
            </h2>
            <p id="timeline-desc" class="text-white text-sm sm:text-base md:text-lg leading-relaxed">
                {!! $timelineItems->first()?->short !!}
            </p>
        </div>
    </div>

    <!-- 3. Bottom Timeline Bar -->
    <div class="relative z-40 w-full mt-12 md:mt-20 pb-6 md:pb-10">
        <div class="relative w-full h-[2px] bg-gray-700 flex justify-between items-center">
            <div id="progress-line"
                class="absolute left-0 top-0 h-full w-0 bg-white transition-all duration-700 shadow-[0_0_15px_white]">
            </div>

            @foreach ($timelineItems as $index => $item)
            <button onclick="changeTimeline({{ $index }})"
                aria-label="Go to timeline {{ $item->title }}"
                class="nav-dot relative z-10 w-4 h-4 md:w-6 md:h-6 rounded-full outline-none transition-all
                    {{ $index === 0 ? 'bg-white ring-4 md:ring-8 ring-white/10 shadow-[0_0_15px_white]' : 'bg-gray-600 hover:bg-gray-400' }}">
            </button>
            @endforeach
        </div>
    </div>

</section>

<!-- ===== MESSAGE FROM LEADERS SECTION ===== -->
<section class="relative w-full py-16 md:py-20 lg:py-32 bg-[#05100a] text-white overflow-hidden">

    <div class="absolute inset-0 z-0 pointer-events-none">
        <img src="{{ asset($leadersMessage?->img_path ?? '') }}" alt="leader"
            class="w-full h-full object-cover">
    </div>

    <div class="container mx-auto  relative z-10">

        <!-- Section Title -->
        <div class="mb-12 md:mb-16 lg:mb-24" data-aos="fade-up">
            <h2 class="text-4xl sm:text-4xl md:text-7xl font-semibold tracking-tight">
                {{ $leadersMessage?->title ?? 'Message from leaders' }}
            </h2>
        </div>

        @foreach ($leaders as $index => $leader)
        @if ($index % 2 == 0)
        <!-- Image Left, Text Right -->
        <div class="flex pl-16 flex-col md:flex-row items-center gap-10 md:gap-12 lg:gap-20 mb-20 md:mb-32">

            <div class="w-full md:w-1/2 relative" data-aos="fade-right">
                <div class="relative z-10 overflow-hidden shadow-2xl">
                    <img src="{{ asset($leader->img_path ?? '') }}" alt="{{ $leader->title ?? '' }}"
                        class="w-full h-[650px]  grayscale hover:grayscale-0 transition-all duration-700 object-cover">
                </div>
                <div class="absolute -bottom-[-30px] -left-6 w-12 h-12 z-20 scroll-move" data-axis="y">
                    <img src="{{ asset('images/stone-bg.svg') }}" alt="stone" class="w-full h-full opacity-80">
                </div>
            </div>

            <div class="w-full md:w-1/2 scroll-move" data-axis="y" data-aos="fade-left">
                <div class="mb-4 md:mb-6">
                    <img src="{{ asset('images/comma.svg') }}" alt="comma">
                </div>
                <h3 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-1">{{ $leader->title }}</h3>
                <p class="text-base md:text-lg tracking-widest text-gray-200 mb-6 md:mb-8">{{ $leader->name }}</p>
                <div class="space-y-4 md:space-y-6 text-gray-300 leading-relaxed text-base md:text-lg lg:text-xl font-light">
                    {!! $leader->body ?? '' !!}
                </div>
            </div>
        </div>
        @else
        <!-- Text Left, Image Right -->
        <div class="flex flex-col-reverse md:flex-row items-center gap-10 md:gap-12 lg:gap-20 mb-20 md:mb-32">

            <div class="w-full md:w-1/2" data-aos="fade-right">
                <div class="mb-4 md:mb-6">
                    <img src="{{ asset('images/comma.svg') }}" alt="comma">
                </div>
                <h3 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-1">{{ $leader->title ?? '' }}</h3>
                <p class="text-base md:text-lg tracking-widest text-gray-200 mb-6 md:mb-8">{{ $leader->name ?? '' }}</p>
                <div class="space-y-4 md:space-y-6 text-gray-200 leading-relaxed text-base md:text-lg lg:text-xl font-light">
                    {!! $leader->body ?? '' !!}
                </div>
            </div>

            <div class="w-full md:w-1/2 relative" data-aos="fade-left">
                <div class="relative z-10 overflow-hidden shadow-2xl border-l-4 border-emerald-900/30">
                    <img src="{{ asset($leader->img_path ?? '') }}" alt="{{ $leader->title ?? '' }}"
                        class="w-full h-[650px]  object-cover grayscale hover:grayscale-0 transition-all duration-700">
                </div>
                <div class="absolute -bottom-[-40px] -left-6 w-12 h-12 z-20 transform rotate-180 scroll-move" data-axis="y">
                    <img src="{{ asset('images/stone-bg.svg') }}" alt="stone" class="w-full h-full opacity-80">
                </div>
            </div>
        </div>
        @endif
        @endforeach

    </div>
</section>

<!-- ===== MEET THE VISIONARIES ===== -->
<section class="relative w-full pt-16 md:pt-20 bg-[#f9f9f9] overflow-hidden mb-0 pb-0">

    <div class="absolute inset-0 z-0 opacity-40">
        <img src="{{ asset('images/visionaries-bg.png') }}" alt="background" class="w-full h-full object-cover">
    </div>

    <div class="container mx-auto px-4 sm:px-6 md:px-12 relative z-10 mb-10">

        <div class="mb-12 md:mb-16">
            <h2 class="text-4xl sm:text-5xl md:text-[72px] font-semibold text-[#424242] tracking-tight" data-aos="fade-up">
                Meet the Visionaries
            </h2>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6 md:gap-8">
            @foreach ($visionaries as $index => $member)
            <div class="group" data-aos="fade-up" data-aos-delay="{{ (($index % 4) + 1) * 100 }}">
                <div class="aspect-[4/5] overflow-hidden bg-gray-200 mb-3 md:mb-4 shadow-sm">
                    <img src="{{ asset($member->img_path) }}" alt="{{ $member->title }}"
                        class="w-full h-full object-cover group-hover:grayscale-0 transition-all duration-700">
                </div>
                <p class="text-lg sm:text-xl md:text-2xl font-bold text-gray-800">{{ $member->title }}</p>
                <p class="text-sm sm:text-base md:text-lg text-gray-500 font-medium">{{ $member->name }}</p>
            </div>
            @endforeach
        </div>
    </div>

    <!-- ===== ABOUT BHAIYA HOUSING ===== -->
    @php
    $aboutImages = is_array($aboutBhaiya?->img_paths)
    ? $aboutBhaiya->img_paths
    : json_decode($aboutBhaiya?->img_paths ?? '[]', true);
    $aboutRightImg = $aboutImages[0] ?? null;
    @endphp

    <div class="container mx-auto  mb-10 mt-16">
<br>
        <div class="mb-6 md:mb-8 lg:mb-12">
            <h2 class="text-4xl sm:text-5xl md:text-6xl lg:text-[75px] text-[#313131] leading-[0.9] tracking-tight">
               About  <span class="font-migra-italic">Bhaiya <br> Housing</span>
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-10 lg:gap-24 mb-12 md:mb-16 lg:mb-24">
            <div class="text-[#595959] text-sm md:text-lg leading-relaxed pl-16 scroll-move" data-axis="Y">
                {{ $aboutBhaiya?->short ?? '' }}
            </div>
            <div class="text-[#595959] text-sm md:text-lg leading-relaxed">
                {{ $aboutBhaiya?->extra ?? '' }}
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 md:gap-6 lg:gap-10 ">
            @if ($aboutBhaiya?->img_path)
            <div class="md:col-span-4 scroll-move" data-axis="y" data-aos="fade-right" data-aos-duration="1000">
                <img src="{{ asset($aboutBhaiya->img_path) }}" alt="About" class="w-full h-full object-cover ">
            </div>
            @endif
            @if ($aboutRightImg)
            <div class="md:col-span-8" data-aos="fade-left" data-aos-duration="1000">
                <img src="{{ asset($aboutRightImg) }}" alt="About" class="w-full h-full object-cover ">
            </div>
            @endif
        </div>
    </div>

    <!-- ===== ABOUT BHAIYA HOUSING GROUP ===== -->
    @php
    $groupImages = is_array($aboutBhaiyaGroup?->img_paths)
    ? $aboutBhaiyaGroup->img_paths
    : json_decode($aboutBhaiyaGroup?->img_paths ?? '[]', true);
    $groupOverflowImg = $groupImages[0] ?? null;
    @endphp

    <div class="container mx-auto  ">

        <div class="mb-10 md:mb-12 lg:mb-16 relative">
           <h2 class="text-4xl sm:text-5xl md:text-7xl lg:text-[75px] text-[#313131] leading-tight tracking-tight">
                <span style="font-weight:500">About</span>     <span class="italic font-light" style="font-family: 'Migra', serif;"> Bhaiya<br>  Group   </span>     <span style="font-weight:500" ></span>
            </h2>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-10 lg:gap-24 mb-16 md:mb-20 lg:mb-32">
            <div class="text-[#595959] text-sm md:text-[15px] leading-relaxed pl-16">
                {!! $aboutBhaiyaGroup?->body !!}
            </div>
            <div class="text-[#595959] text-sm md:text-[15px] leading-relaxed scroll-move" data-axis="Y">
                {!! $aboutBhaiyaGroup?->body_2 !!}
            </div>
        </div>
    </div>

    <!-- Cover Image with Overflow Small Image -->
    <div class="relative w-full overflow-visible mb-0 pb-0">
        @if ($aboutBhaiyaGroup?->img_path)
        <div class="w-full">
            <img src="{{ asset($aboutBhaiyaGroup->img_path) }}" alt="Cover"
                class="w-full h-[220px] md:h-[350px] object-cover block">
        </div>
        @endif

        @if ($groupOverflowImg)
        <div class="absolute top-[-6%] left-[4%] sm:left-[6%] z-20 scroll-move" data-axis="Y" data-aos="fade-down" data-aos-duration="1200"
            data-aos-easing="ease-out-back">
            <div class="absolute -top-4 -left-8 md:-top-6 md:-left-12 w-10 h-10 md:w-16 md:h-16 z-30">
                <img src="{{ asset('images/stone-bg.svg') }}" alt="stone-bg" class="w-full h-full object-contain">
            </div>
            <img src="{{ asset($groupOverflowImg) }}" alt="Building"
                class="w-[100px] sm:w-[160px] md:w-[300px] lg:w-[400px] h-auto object-cover block">
        </div>
        @endif
    </div>

</section>



@endsection
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const header = document.getElementById('site-header');
        const contentDiv = document.querySelector('.absolute.inset-0.flex.flex-col');
        if (header && contentDiv) {
            contentDiv.style.paddingTop = header.offsetHeight + 'px';
        }
    });
</script>
<script>
<<<<<<< HEAD
    const timelineData = {!! json_encode($timelineData) !!};
=======
    const timelineData = {!!json_encode($timelineData) !!};
>>>>>>> bec00e7963e80422426433861d456eaba6defde9
    const total = timelineData.length;
    let currentIndex = 0;

    window.changeTimeline = function(index) {
        if (index === currentIndex) return;

        const direction = index > currentIndex ? 'up' : 'down';
        currentIndex = index;

        const data = timelineData[index];

        const year = document.getElementById('timeline-year');
        const title = document.getElementById('timeline-title');
        const desc = document.getElementById('timeline-desc');
        const img = document.getElementById('timeline-img');
        const wrap = img.parentElement;

        const textEls = [year, title, desc];

        fadeOut(textEls, direction, () => {
            year.textContent = data.year;
            title.innerHTML = data.title.replace(/\n/g, '<br>');
            desc.innerHTML = data.desc;
            fadeIn(textEls, direction);
        });

        const newImg = new Image();
        newImg.onload = () => {
            fadeOut([wrap], direction, () => {
                img.src = newImg.src;
                fadeIn([wrap], direction);
            });
        };
        newImg.src = data.img;

        const percent = total > 1 ? (index / (total - 1)) * 100 : 0;
        document.getElementById('progress-line').style.width = percent + '%';

        document.querySelectorAll('.nav-dot').forEach((dot, i) => {
            dot.classList.toggle('bg-white', i === index);
            dot.classList.toggle('ring-4', i === index);
            dot.classList.toggle('md:ring-8', i === index);
            dot.classList.toggle('ring-white/10', i === index);
            dot.classList.toggle('shadow-[0_0_15px_white]', i === index);
            dot.classList.toggle('bg-gray-600', i !== index);
        });
    }

    function fadeOut(elements, direction, callback) {
        const yVal = direction === 'up' ? '-20px' : '20px';
        elements.forEach(el => {
            el.style.transition = 'opacity 0.35s ease, transform 0.35s ease';
            el.style.opacity = '0';
            el.style.transform = `translateY(${yVal})`;
        });
        setTimeout(callback, 350);
    }

    function fadeIn(elements, direction) {
        const yStart = direction === 'up' ? '20px' : '-20px';
        elements.forEach(el => {
            el.style.transition = 'none';
            el.style.transform = `translateY(${yStart})`;
        });
        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                elements.forEach(el => {
                    el.style.transition = 'opacity 0.45s ease, transform 0.45s ease';
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0px)';
                });
            });
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        const els = ['timeline-year', 'timeline-title', 'timeline-desc'];
        els.forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                el.style.opacity = '1';
                el.style.transform = 'translateY(0px)';
            }
        });
        const img = document.getElementById('timeline-img');
        if (img) {
            img.parentElement.style.opacity = '1';
            img.parentElement.style.transform = 'translateY(0px)';
        }
    });
</script>
<script>
    function setHeaderHeight() {
        const header = document.querySelector('header') || document.querySelector('nav');
        if (header) {
            document.documentElement.style.setProperty('--header-height', header.offsetHeight + 'px');
        }
    }
    setHeaderHeight();
    window.addEventListener('resize', setHeaderHeight);
</script>
@endpush