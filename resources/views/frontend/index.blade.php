@extends('layouts.front')

@section('title', ($setting->title ?? 'Bhaiya Housing') . ' – We transform your dreams into addresses')

@section('meta')
@php
$pageTitle = ($setting->title ?? 'Bhaiya Housing') . ' – Premium Real Estate & Property Developers in Bangladesh';
$pageDesc = $setting->short ?? 'Since 2012, Bhaiya Housing crafts exquisite residential and commercial spaces in Bangladesh. Partner with us as a landowner or find your dream luxury property.';
$pageUrl = url('/');
$pageImage = asset('frontend/images/logo.svg');

// Safe fallback for socials if not globally shared
$socialLinks = isset($socials) ? $socials->map(fn($s) => $s->url)->filter()->values()->toArray() : [];

$schema = [
"page" => [
"description" => $pageDesc,
"keywords" => implode(', ', [
$setting->title ?? 'Bhaiya Housing',
'real estate Bangladesh',
'property developer Dhaka',
'buy luxury apartments Dhaka',
'commercial spaces Bangladesh',
'landowner joint venture',
'real estate company in BD',
'Bhaiya Group',
]),
"robots" => "index, follow, max-image-preview:large",
"canonical" => $pageUrl,
],
"openGraph" => [
"type" => "website",
"title" => $pageTitle,
"description" => $pageDesc,
"url" => $pageUrl,
"site_name" => $setting->title ?? 'Bhaiya Housing',
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
"@type" => ["RealEstateBuilder", "LocalBusiness", "Organization"],
"@id" => url('/') . '#organization',
"name" => $setting->title ?? 'Bhaiya Housing',
"alternateName" => $setting->name ?? 'Bhaiya Housing Ltd.',
"url" => url('/'),
"logo" => [
"@type" => "ImageObject",
"url" => $pageImage,
"width" => 200,
"height" => 60,
],
"image" => $pageImage,
"description" => $pageDesc,
"telephone" => $setting->extra ?? '',
"email" => $setting->location ?? '',
"address" => [
"@type" => "PostalAddress",
"streetAddress" => $setting->short ?? 'Dhaka',
"addressLocality" => "Dhaka",
"addressCountry" => "BD",
],
"geo" => [
"@type" => "GeoCoordinates",
"latitude" => "23.8103", // Update with your actual coordinates
"longitude" => "90.4125",
],
"hasMap" => "https://maps.google.com/?q=" . urlencode($setting->short ?? 'Dhaka Bangladesh'),
"priceRange" => "$$$$",
"openingHours" => "Su-Th 09:00-18:00",
"sameAs" => $socialLinks,
"contactPoint" => [
"@type" => "ContactPoint",
"telephone" => $setting->extra ?? '',
"contactType" => "customer service",
"availableLanguage" => ["English", "Bengali"],
"areaServed" => "BD",
],
],
"webSite" => [
"@context" => "https://schema.org",
"@type" => "WebSite",
"@id" => url('/') . '#website',
"name" => $setting->title ?? 'Bhaiya Housing',
"url" => url('/'),
"description" => $pageDesc,
"inLanguage" => "en-US",
"publisher" => ["@id" => url('/') . '#organization'],
"potentialAction" => [
"@type" => "SearchAction",
"target" => [
"@type" => "EntryPoint",
"urlTemplate" => url('/projects') . '?search={search_term_string}',
],
"query-input" => "required name=search_term_string",
],
],
"webPage" => [
"@context" => "https://schema.org",
"@type" => "WebPage",
"@id" => url('/') . '#webpage',
"name" => $pageTitle,
"description" => $pageDesc,
"url" => url('/'),
"inLanguage" => "en-US",
"isPartOf" => ["@id" => url('/') . '#website'],
"about" => ["@id" => url('/') . '#organization'],
"mainEntityOfPage" => ["@id" => url('/') . '#webpage'],
"breadcrumb" => [
"@type" => "BreadcrumbList",
"itemListElement" => [
["@type" => "ListItem", "position" => 1, "name" => "Home", "item" => url('/')],
],
],
],
"projectListing" => [
"@context" => "https://schema.org",
"@type" => "ItemList",
"name" => "Featured Real Estate Projects",
"url" => url('/projects'),
"numberOfItems" => isset($featuredProjects) ? $featuredProjects->count() : 0,
"itemListElement" => isset($featuredProjects) ? $featuredProjects->map(fn($project, $i) => [
"@type" => "ListItem",
"position" => $i + 1,
"item" => [
"@type" => "ApartmentComplex",
"name" => $project->title ?? '',
"url" => url('/projects/' . $project->id),
"image" => $project->img_path ? asset($project->img_path) : $pageImage,
"address" => [
"@type" => "PostalAddress",
"addressLocality" => $project->location ?? 'Bangladesh'
],
],
])->values()->toArray() : [],
],
"newsEventList" => [
"@context" => "https://schema.org",
"@type" => "ItemList",
"name" => "News and Events",
"url" => url('/event'),
"itemListElement" => isset($newsEvents) ? collect($newsEvents)->map(fn($item, $i) => [
"@type" => "ListItem",
"position" => $i + 1,
"item" => [
"@type" => $item->type === 'events' ? "Event" : "Article",
"name" => $item->title ?? '',
"url" => url('/' . ($item->type === 'events' ? 'events/' : 'news/') . $item->id),
"startDate" => $item->start_date ?? null,
],
])->values()->toArray() : [],
],
"faq" => [
"@context" => "https://schema.org",
"@type" => "FAQPage",
"mainEntity" => [
[
"@type" => "Question",
"name" => "What type of properties does " . ($setting->title ?? 'Bhaiya Housing') . " build?",
"acceptedAnswer" => [
"@type" => "Answer",
"text" => "We specialize in constructing exquisite residential homes, luxury apartments, and modern commercial spaces across Bangladesh, blending prestige and elegance.",
],
],
[
"@type" => "Question",
"name" => "How long has Bhaiya Housing been in the real estate industry?",
"acceptedAnswer" => [
"@type" => "Answer",
"text" => "Since 2012, Bhaiya Housing—a proud part of the Bhaiya Group—has been redefining modern infrastructure with over a decade of expertise.",
],
],
[
"@type" => "Question",
"name" => "Can landowners partner with Bhaiya Housing for development?",
"acceptedAnswer" => [
"@type" => "Answer",
"text" => "Yes! We partner with landowners through joint ventures to transform properties into landmark developments. Visit our Landowner Contact page to get started.",
],
],
[
"@type" => "Question",
"name" => "Does Bhaiya Housing ensure on-time project handover?",
"acceptedAnswer" => [
"@type" => "Answer",
"text" => "Absolutely. We guarantee on-schedule completion, respecting your timelines without compromising on quality or premium materials.",
],
],
],
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

{{-- ORGANIZATION SCHEMA --}}
<script type="application/ld+json">
    {
        !!json_encode($schema['organization'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!
    }
</script>

{{-- WEBSITE SCHEMA --}}
<script type="application/ld+json">
    {
        !!json_encode($schema['webSite'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!
    }
</script>

{{-- WEBPAGE SCHEMA --}}
<script type="application/ld+json">
    {
        !!json_encode($schema['webPage'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!
    }
</script>

@if(isset($featuredProjects) && $featuredProjects->isNotEmpty())
{{-- PROJECT LISTING SCHEMA --}}
<script type="application/ld+json">
    {
        !!json_encode($schema['projectListing'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!
    }
</script>
@endif

@if(isset($newsEvents) && count($newsEvents) > 0)
{{-- NEWS & EVENTS LIST SCHEMA --}}
<script type="application/ld+json">
    {
        !!json_encode($schema['newsEventList'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!
    }
</script>
@endif

{{-- FAQ SCHEMA --}}
<script type="application/ld+json">
    {
        !!json_encode($schema['faq'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!
    }
</script>
@endsection

@section('content')

<!-- ===== HERO ===== -->
<section id="home" class="fixed hero-fixed top-0 left-0 w-full h-screen z-0 overflow-hidden">

    {{-- Background --}}
    <div class="absolute inset-0">
        <img
            src="{{ $hero->img_path ?? asset('assets/images/hero-bg.jpg') }}"
            alt="hero-bg"
            class="w-full h-full object-cover scale-[1.06] animate-[zoomOut_8s_ease_forwards]" />
        <div
            class="absolute inset-0"
            style="background: rgba(14, 14, 14, 0.7)"></div>
    </div>

    {{-- Content --}}
    <div class="relative z-10 h-full flex flex-col justify-center items-end">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mt-5">
                <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl leading-[1.08] opacity-0 animate-[fadeUp_0.8s_0.35s_ease_forwards]">
                    We
                    <span class="font-migra-italic">transform</span>
                    your <br>
                    <span class="font-migra-italic">dreams</span>
                    into addresses
                </h1>
            </div>
            <div class="mt-10 pl-8 sm:pl-12 md:pl-16 pb-[6vh] pr-4 sm:pr-6 md:pr-[40px] md:mt-28 max-w-[90%] sm:max-w-[70%] md:max-w-[60%] opacity-0 animate-[fadeUp_0.8s_0.55s_ease_forwards]">

    <p class="text-white text-sm sm:text-base md:text-[1vw] font-normal tracking-normal md:tracking-[-1px] leading-relaxed">
        {{ $hero->short ?? 'Immerse yourself in the artistry...' }}
    </p>

</div>
        </div>
    </div>

    {{-- Scroll indicator --}}
    <div class="absolute bottom-10 left-4 md:left-16 z-20 animate-bounce">
        <div class="w-12 h-12 md:w-14 md:h-14 rounded-full border border-white/30 hover:border-white/60 flex items-center justify-center transition-colors cursor-pointer">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-opacity="0.7">
                <polyline points="6 9 12 15 18 9"></polyline>
            </svg>
        </div>
    </div>

    {{-- Video card --}}
    <div class="absolute p-3 md:p-4 bottom-6 md:bottom-8 right-4 md:right-16 z-20
                flex border border-white/30 hover:border-white/40
                transition-all duration-300 cursor-pointer group
                opacity-0 animate-[fadeUp_0.7s_0.9s_ease_forwards]
                w-[calc(100vw-2rem)] max-w-[360px] sm:max-w-[420px] md:max-w-[500px]
                h-36 sm:h-40 md:h-48">

        <div class="w-[140px] sm:w-[180px] md:w-[250px] flex-shrink-0 relative overflow-hidden bg-neutral-900"
            onclick="openVideoModal()">
            <video class="w-full h-full object-cover scale-105 group-hover:scale-100 transition-transform duration-700"
                autoplay muted loop playsinline>
                <source src="{{ $hero?->video_path ?? asset('videos/home.mp4') }}" type="video/mp4" />
            </video>
            <div class="absolute inset-0 bg-black/30 group-hover:bg-black/10 transition-colors duration-500"></div>
        </div>

        <div class="flex-1 p-2 md:p-3 flex flex-col justify-between">
            <div class="flex items-center justify-end gap-2" onclick="openVideoModal()">
                <span class="text-[10px] tracking-[1.5px] uppercase text-white/50 group-hover:text-white/80 transition-colors duration-300 hidden sm:inline">View</span>
                <div class="w-7 h-7 md:w-8 md:h-8 rounded-full border border-white/30 bg-white/5
                            group-hover:bg-white/15 group-hover:border-white/60 group-hover:scale-110
                            flex items-center justify-center flex-shrink-0 transition-all duration-300">
                    <svg width="9" height="11" viewBox="0 0 12 14" fill="none">
                        <path d="M12 7L0 14V0L12 7Z" fill="white" fill-opacity="0.9" />
                    </svg>
                </div>
            </div>
            <div class="flex justify-end">
                <p class="text-sm md:text-base font-light tracking-wide text-white/90 group-hover:text-white transition-colors duration-300 leading-snug"
                    onclick="openVideoModal()">Watch our video</p>
            </div>
        </div>
    </div>

</section>

<div class="h-screen w-full pointer-events-none"></div>

<div
    id="videoModal"
    class="fixed inset-0 z-[200] items-center justify-center bg-black/85 backdrop-blur-sm px-4 md:px-10"
    style="display: none"
    onclick="closeVideoModal(event)">
    <div class="relative w-full max-w-5xl mx-auto" onclick="event.stopPropagation()">
        <button onclick="closeVideoModal()"
            class="absolute -top-10 right-0 text-white opacity-70 hover:opacity-100 transition-opacity">
            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" stroke="white" stroke-width="1.5" stroke-linecap="round">
                <line x1="4" y1="4" x2="24" y2="24" />
                <line x1="24" y1="4" x2="4" y2="24" />
            </svg>
        </button>
        <video id="modalVideo" class="w-full" controls playsinline style="max-height: 80vh">
            <source src="{{ $hero?->video_path ?? asset('assets/video/1.mp4') }}" type="video/mp4" />
        </video>
    </div>
</div>


<section class="relative z-10 py-16 md:py-24 overflow-hidden bg-[#FFFDFA] box" style="padding-top: 80px;">
    <div class="mx-auto px-4 sm:px-6 lg:px-10">

        @php
        $extraImages = json_decode($dreams->img_paths ?? '[]', true);
        @endphp

        <!-- ══════════════════════════════════
             MOBILE LAYOUT (flex-col, < md)
        ══════════════════════════════════ -->
        <div class="flex flex-col gap-8 md:hidden">

            <!-- Heading -->
            <h2 class="font-display text-4xl sm:text-5xl font-light  text-gray-900 px-4 py-10">
                <strong>Building dreams for</strong> <br>
                <span style="font-family: Migra;">decades</span>
            </h2>

            <!-- Big center image -->
            <div class="img-shadow rounded-sm overflow-hidden w-full fade-in delay-2">
                <img src="{{ $dreams->img_path ?? asset('assets/images/main.avif') }}"
                    alt="Modern building"
                    class="w-full h-[400px] sm:h-[520px] object-cover"
                    onerror="this.style.background='#c5bdb5'; this.removeAttribute('src');" />
            </div>

            <!-- Side images row -->
            <div class="grid grid-cols-2 gap-4 fade-in delay-2">
                <img src="{{ $extraImages[1] ?? asset('assets/images/side.jpg') }}"
                    alt="Outdoor space"
                    class="img-shadow rounded-sm object-cover w-full h-[180px] sm:h-[220px]"
                    onerror="this.style.background='#d6cfc5'; this.removeAttribute('src');" />
                <img src="{{ $extraImages[2] ?? asset('assets/images/right-side.jpg') }}"
                    alt="Interior"
                    class="img-shadow rounded-sm object-cover w-full h-[180px] sm:h-[220px]"
                    onerror="this.style.background='#cdc5bb'; this.removeAttribute('src');" />
            </div>

            <!-- Bottom image -->
            <div class="fade-in delay-3 scroll-move" data-axis="Y" data-max-move="180">
                <img src="{{ $extraImages[0] ?? asset('assets/images/sub.jpg') }}"
                    alt="Property"
                    class="img-shadow rounded-sm object-cover w-full h-[260px] sm:h-[320px]"
                    onerror="this.style.background='#c0b8ae'; this.removeAttribute('src');" />
            </div>

            <!-- Description + CTA -->
            <div class="flex flex-col items-start gap-6">
                <p class="text-sm leading-relaxed fade-in delay-3" style="color:#555; line-height:1.9;">
                    {{ $dreams->short ?? 'Since 2012, Bhaiya Housing, a distinguished part of Bhaiya Group, has redefined modern infrastructure. Merging architectural brilliance with purposeful design, we craft exquisite homes and commercial spaces that embody aspirations, inspire ambition, and effortlessly adapt to the evolving rhythms of modern life.' }}
                </p>
                <div class="fade-in delay-4">
                    <a href="{{ route('front.about') }}" class="circle-btn">Learn More</a>
                </div>
            </div>

        </div>

        <!-- ══════════════════════════════════
             TABLET LAYOUT (≥ md, < lg)
        ══════════════════════════════════ -->
        <div class="hidden md:flex lg:hidden flex-col gap-10">

            <!-- Heading -->
            <h2 class="font-display  text-5xl  leading-tight text-gray-900 ">
                <span> Building <br>
                    dreams for </span> <span style="font-family: Migra;">decades</span>
            </h2>

            <!-- Top row: big image + right col -->
            <div class="flex gap-6 items-start">

                <!-- Big center image -->
                <div class="img-shadow rounded-sm overflow-hidden fade-in delay-2 flex-1" style="height: 500px;">
                    <img src="{{ $dreams->img_path ?? asset('assets/images/main.avif') }}"
                        alt="Modern building"
                        class="w-full h-full object-cover"
                        onerror="this.style.background='#c5bdb5'; this.removeAttribute('src');" />
                </div>

                <!-- Right column -->
                <div class="flex flex-col gap-6 w-[42%] flex-shrink-0 fade-in delay-3">
                    <div class="float-up">
                        <img src="{{ $extraImages[2] ?? asset('assets/images/right-side.jpg') }}"
                            alt="Interior"
                            class="img-shadow rounded-sm object-cover w-full"
                            style="height: 240px; object-position: center;"
                            onerror="this.style.background='#cdc5bb'; this.removeAttribute('src');" />
                    </div>
                    <p class="text-sm leading-relaxed fade-in delay-3 " style="color:#555; line-height:1.9;">
                        {{ $dreams->short ?? 'Since 2012, Bhaiya Housing, a distinguished part of Bhaiya Group, has redefined modern infrastructure. Merging architectural brilliance with purposeful design, we craft exquisite homes and commercial spaces that embody aspirations, inspire ambition, and effortlessly adapt to the evolving rhythms of modern life.' }}
                    </p>
                    <div class="fade-in delay-4">
                        <a href="{{ route('front.about') }}" class="circle-btn hover-lg z-20">Learn More</a>
                    </div>
                </div>
            </div>

            <!-- Bottom row: two images -->
            <div class="grid grid-cols-2 gap-6 fade-in delay-2">
                <img src="{{ $extraImages[0] ?? asset('assets/images/side.jpg') }}"
                    alt="Outdoor space"
                    class="img-shadow rounded-sm object-cover w-full float-down"
                    style="height: 280px; object-position: center;"
                    onerror="this.style.background='#d6cfc5'; this.removeAttribute('src');" />
                <img src="{{ $extraImages[1] ?? asset('assets/images/sub.jpg') }}"
                    alt="Property"
                    class="img-shadow rounded-sm object-cover w-full float-up"
                    style="height: 280px; object-position: center;"
                    onerror="this.style.background='#c0b8ae'; this.removeAttribute('src');" />
            </div>

        </div>

        <!-- ══════════════════════════════════
             DESKTOP LAYOUT (≥ lg), original
        ══════════════════════════════════ -->

        <!-- Row 1 -->
        <div class="hidden lg:flex relative flex-wrap items-start mt-8">

            <!-- Col 1: Heading -->
            <div class="w-full h-full lg:w-1/4 pt-6 z-10 fade-in delay-1">

                <h2 class="font-display  text-[3.8vw]   text-gray-900   " style="line-height:70px;letter-spacing: -3px;">
                    <span class="" style="font-weight: 500;color:#484848"> Building <br>
                        dreams for </span> <br><span style="font-family: Migra;color:#484848">decades</span>
                </h2>

                <div class="mt-32 float-down fade-in delay-2" style="position:relative; left:-60px;">
                    <img src="{{ $extraImages[0] ?? asset('assets/images/side.jpg') }}"
                        alt="Outdoor space"
                        class="img-shadow rounded-sm object-cover"
                        style="width:400px; height:300px; object-position:center;"
                        onerror="this.style.background='#d6cfc5'; this.removeAttribute('src');" />
                </div>
            </div>

            <!-- Col 2: Big Center Image -->
            <div class="w-full lg:w-5/12 relative fade-in delay-2" style="margin-left:2%;">
                <div class="img-shadow rounded-sm overflow-hidden" style="height:800px;">
                    <img src="{{ $dreams->img_path ?? asset('assets/images/main.avif') }}"
                        alt="Modern building"
                        class="w-full h-full object-cover"
                        onerror="this.style.background='#c5bdb5'; this.style.height='100%'; this.removeAttribute('src');" />
                </div>
            </div>

            <!-- Col 3: Right side -->
            <div class="w-full lg:w-1/4 flex flex-col items-start pl-6 pt-2 fade-in delay-3 scroll-move" data-axis="Y" data-max-move="50" style="margin-left:4%;">

                <div class="float-up mb-8 self-end">
                    <div class="absolute pointer-events-none"
                        style="left:-40px; top:-80px; z-index:3;">
                        <img src="/assets/images/overview-stone.png" alt=""
                            style="width:clamp(120px,7vw,160px); opacity:0.8;"
                            onerror="this.style.display='none'" />
                    </div>
                    <img src="{{ $extraImages[2] ?? asset('assets/images/right-side.jpg') }}"
                        alt="Interior"
                        class="img-shadow rounded-sm object-cover"
                        style="width:400px; height:300px; object-position:center;"
                        onerror="this.style.background='#cdc5bb'; this.removeAttribute('src');" />
                </div>

                <p class="text-sm leading-relaxed fade-in delay-3 mb-8  pt-[70px]"
                    style="color:rgb(83, 83, 83);   line-height:25px;font-size:17px;font-weight: 500;">
                    {{ $dreams->short ?? 'Since 2012, Bhaiya Housing, a distinguished part of Bhaiya Group, has redefined modern infrastructure. Merging architectural brilliance with purposeful design, we craft exquisite homes and commercial spaces that embody aspirations, inspire ambition, and effortlessly adapt to the evolving rhythms of modern life.' }}
                </p>

                <div class="fade-in delay-4">
                    <a href="{{ route('front.about') }}" class="circle-btn hover-lg z-20">Learn More</a>
                </div>
            </div>

        </div><!-- /Row 1 desktop -->

        <!-- Row 2: bottom images (desktop only) -->
        <div class="hidden lg:flex relative flex-wrap items-center scroll-move" data-axis="Y" data-max-move="50">

            <div class="absolute z-20 fade-in delay-3 float-down" style="left:22%; bottom:0px;">
                <img src="{{ $extraImages[1] ?? asset('assets/images/sub.jpg') }}"
                    alt="Property"
                    class="img-shadow rounded-sm object-cover"
                    style="width:450px;  "
                    onerror="this.style.background='#c0b8ae'; this.removeAttribute('src');" />
                <div class="scroll-move absolute pointer-events-none"
                    data-axis="Y"
                    style="right:-60px; bottom:0; z-index:-30;">
                    <img src="/assets/images/middle-stone.png" alt=""
                        style="width:clamp(120px,7vw,160px); opacity:0.8;"
                        onerror="this.style.display='none'" />
                </div>
            </div>

            <div class="w-8 h-8 rounded-full float-up opacity-60 mt-10"
                style="background:radial-gradient(circle at 35% 35%,#c9b99a,#8a7560); width:44px; height:44px; margin-top:20px; margin-left:10px;">
            </div>

        </div><!-- /Row 2 desktop -->

    </div>
</section>

@if ($featuredProjects->isNotEmpty())
@php $first = $featuredProjects->first(); @endphp

{{-- ===== FEATURED PROJECTS ===== --}}
<section
    class=" relative z-10 w-full overflow-hidden backdrop-blur-md p-16"
    style="height: 100vh; min-height: 600px; padding-bottom: 100px; padding-top: 100px">
    {{-- Background Video --}}
    <video
        id="heroVideo"
        class="absolute inset-0 w-full h-full object-cover"
        autoplay
        muted
        loop
        playsinline>
        <source
            id="heroVideoSource"
            src="{{ $first->video_path ?? asset('assets/video/1.mp4') }}"
            type="video/mp4" />
    </video>

    {{-- Dark Overlay --}}
    <div
        class="absolute inset-0"
        style="background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.25) 50%, rgba(0,0,0,0.3) 100%)"></div>

    {{-- Learn More circle button — desktop only --}}
    <div class="hidden md:block absolute z-20 right-[50px] lg:right-[300px] top-[100px]" >
        <a
            id="heroLearnMore"
            href="/project/{{ $first->id }}"
            class="circle-learn-btn flex items-center justify-center rounded-full border border-white text-white tracking-widest transition-all duration-300 hover-lg hover:text-black"
            style="width: 10vw; height: 10vw;  font-weight: 400; letter-spacing: 0.1em; font-size: 13px">
            Learn More
        </a>
    </div>

    {{-- Bottom-left: Title + Address --}}
    <div class="absolute z-20 md:pl-32 text-white left-4 md:left-[50px]">
        <p
            class="text-xs tracking-[3px] uppercase text-white mb-12"
            style="font-weight: 400;font-size:20px">
            Featured Project
        </p>
        <h2
            id="heroTitle"
            class="font-display text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-light mb-2"
            style=" font-weight: 300">
            {{ $first->title }}
        </h2>
        <p
            id="heroAddress"
            class="text-sm tracking-wide"
            style=" font-weight: 300; letter-spacing: 0.05em">
            {{ $first->location }}
        </p>

        {{-- Learn More — mobile only --}}
        <a
            id="heroLearnMoreMobile"
            href="/project/{{ $first->id }}"
            class="md:hidden inline-block mt-4 text-xs tracking-[2px] uppercase border border-white/60 text-white px-5 py-2 hover:bg-white hover:text-black transition-all duration-300"
            style=" font-weight: 400">
            Learn More
        </a>
    </div>

    {{-- Bottom Thumbnails Strip --}}
    <div class="absolute md:ml-32 bottom-4 md:bottom-10 left-0 right-0 z-20 px-4 md:px-0 md:left-10">
        <div class="flex gap-3 md:gap-5 overflow-x-auto scrollbar-hide  pb-1 md:p-4 md:overflow-visible">

            @foreach ($featuredProjects as $i => $project)
            <div
                class="thumb-item {{ $i === 0 ? 'active' : '' }}  cursor-pointer overflow-visible relative flex-shrink-0"
                style="
                            width: clamp(120px, 28vw, 200px);
                            height: clamp(90px, 20vw, 150px);
                            border: 2px solid {{ $i === 0 ? 'rgba(255,255,255,0.8)' : 'rgba(255,255,255,0.3)' }};
                        "
                data-video="{{ $project->video_path ?? asset('assets/video/1.mp4') }}"
                data-title="{{ $project->title }}"
                data-address="{{ $project->location }}"
                data-url="/project/{{ $project->id }}"
                onclick="switchVideo(this)">
                <img
                    src="{{ $project->img_path ?? asset('assets/images/video-thumb' . ($i + 1) . '.jpg') }}"
                    alt="{{ $project->title }}"
                    class="w-full h-full object-cover {{ $i === 0 ? 'opacity-90' : 'opacity-70' }} hover:opacity-100 transition-opacity duration-200"
                    onerror="this.parentElement.style.background='#3a3a3a'; this.style.display='none';" />

                {{-- Progress Bar --}}
                <div
                    class="progress-bar absolute left-0 h-[2px] bg-white z-10 {{ $i === 0 ? '' : 'hidden' }}"
                    style="width: 0%; top: 100%; margin-top: 4px; transition: none"></div>
            </div>
            @endforeach

        </div>
    </div>

</section>
@endif

@push('styles')
<style>
    /* Hide scrollbar on thumbnail strip */
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }

    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>
@endpush

<!-- ===== QUALITY / EXCELLENCE ===== -->
@php
$expertiseImages = json_decode($expertise->img_paths ?? '[]', true);
$bgTextLines = explode(' ', $expertise->short ?? 'Quality Construction');
@endphp

<section class="w-full overflow-hidden relative z-10" style="background: rgb(21, 32, 24);">

    {{-- Background image --}}
    <div class="absolute inset-0 w-full h-full " style="z-index:0;">
        <img id="qualityBg" class="absolute w-full"
           
            src="/assets/images/quality-bg.png" alt=""
            style="top:-20%; left:0; height:140%; object-fit:cover; will-change:transform;" />
    </div>

    {{-- ── Part 1: Hero ── --}}
    <div class="relative z-10 w-full flex flex-col items-center justify-center text-center 
                px-4 pt-16 pb-0
                sm:px-6 sm:pt-20
                md:px-10 md:pt-24">

        {{-- Ghost text --}}
        <span class="absolute inset-0 flex items-center top-32 justify-center tracking-[5px] select-none pointer-events-none scroll-move"
            data-axis="Y"
            style="
font-size: clamp(150px, 14vw, 320px);                    font-weight:bolder;
                    color:rgba(255,255,255,0.04);
                    letter-spacing:0.1em;
                    white-space:nowrap;">
            EVERY <br>
            EVERY
        </span>

        {{-- Headline --}}
        <div class="relative z-10 px-2">
            <h2 class="text-white font-light mb-1"
                style="
                      font-size:clamp(28px,7vw,82px);
                       font-weight:normal;
                       letter-spacing:0.01em;">
                {{ $expertise->title ?? '12+ years of expertise.' }}
            </h2>

            <div class="flex items-center justify-center my-2">
                <span class="block w-px bg-white opacity-40" style="height:24px;"></span>
            </div>

            <p class="text-white opacity-60 uppercase mb-2"
                style="letter-spacing:0.2em; font-size:clamp(11px,1.2vw,16px);">
                Excellence in
            </p>

            <h3 class="text-white font-light"
                style="
                       font-size:clamp(32px,7vw,96px);
                       font-weight:blod;">
                Every detail
            </h3>
        </div>

        {{-- Center image --}}
        <div class="relative z-10 w-full mx-auto 
                    px-4 sm:px-6 md:px-0"
            style="max-width:900px; height:clamp(220px,45vw,520px);">
            <img src="{{ $expertise->img_path ?? asset('assets/images/quality-top.jpg') }}"
                alt="Architectural detail"
                class="w-full h-full object-cover"
                onerror="this.parentElement.style.background='#1e2e20'; this.style.display='none';" />

        </div>

    </div>

    {{-- ── Part 2: Two columns ── --}}
    <div class="relative w-full 
                px-4 pt-12 pb-16
                sm:px-6 sm:pt-14 sm:pb-20
                md:px-10 md:pt-16 md:pb-24
                lg:px-16 lg:pt-20 lg:pb-28
                xl:px-24 xl:pt-24 xl:pb-32">

        {{-- Background text --}}
        <div class="absolute inset-0 flex flex-col justify-start pt-4 pl-2 select-none pointer-events-none  mt-16" style="z-index:0;">
            @foreach($bgTextLines as $line)
            <span class="scroll-move" data-axis="Y" style="
                font-size: clamp(32px, 6vw, 120px);
                font-weight: 700;
                color: rgba(255,255,255,0.04);
                white-space: nowrap;
                line-height: 1.1;">
                {{ $line }}
            </span>
            @endforeach
        </div>

        {{-- Grid --}}
        <div id="quality-grid" class="relative z-10 flex flex-col md:flex-row w-full">

            {{-- Animated border line --}}
            <div class="quality-border-line" style="
                position: absolute; top: 0; left: 0;
                height: 1px; width: 0%;
                background: rgba(255,255,255,0.25);
                z-index: 20;"></div>

            {{-- Col 1 --}}
            <div class="quality-col w-full md:w-1/2
                        md:border-r md:border-white/10
                        p-6 sm:p-8 md:p-10"
                style="position: relative;  display: flex; flex-direction: column;">

                <div class="py-6 sm:py-8 md:py-10 px-2 sm:px-4 md:px-8"
                    style="min-height: clamp(100px, 15vw, 180px); position: relative; z-index: 2; flex-shrink: 0;">
                    <p class="text-white text-sm leading-relaxed opacity-80"
                        style="line-height: 1.9; font-weight: 300;">
                        {!! $expertise->body ?? 'We deliver exceptional construction using first-rate materials.' !!}
                    </p>
                </div>

                <div class="quality-img-wrap mx-auto"
                    style="overflow: hidden; flex-shrink: 0;
                           width: clamp(200px, 75%, 400px);
                           height: clamp(260px, 40vw, 550px);
                           transition: height 0.75s cubic-bezier(0.76,0,0.24,1),
                                       width 0.75s cubic-bezier(0.76,0,0.24,1);">
                    <img src="{{ $expertiseImages[0] ?? asset('assets/images/q1.jpg') }}"
                        class="quality-img w-full h-full object-cover"
                        style="transform: scale(1.04);
                               transition: transform 0.75s cubic-bezier(0.25,0.46,0.45,0.94);" />
                </div>
            </div>

            {{-- Col 2 --}}
            <div class="quality-col w-full md:w-1/2
                        border-t border-white/10 md:border-t-0
                        p-6 sm:p-8 md:p-10"
                style="position: relative;  display: flex; flex-direction: column;">

                <div class="py-6 sm:py-8 md:py-10 px-2 sm:px-4 md:px-8"
                    style="min-height: clamp(100px, 15vw, 180px); position: relative; z-index: 2; flex-shrink: 0;">
                    <p class="text-white text-sm leading-relaxed opacity-80"
                        style="line-height: 1.9; font-weight: 300;">
                        {!! $expertise->body_2 ?? 'We guarantee on-schedule completion, respecting your timelines.' !!}
                    </p>
                </div>

                <div class="quality-img-wrap mx-auto"
                    style="overflow: hidden; flex-shrink: 0;
                           width: clamp(200px, 75%, 400px);
                           height: clamp(260px, 40vw, 550px);
                           transition: height 0.75s cubic-bezier(0.76,0,0.24,1),
                                       width 0.75s cubic-bezier(0.76,0,0.24,1);">
                    <img src="{{ $expertiseImages[1] ?? asset('assets/images/q2.jpg') }}"
                        class="quality-img w-full h-full object-cover"
                        style="transform: scale(1.04);
                               transition: transform 0.75s cubic-bezier(0.25,0.46,0.45,0.94);" />
                </div>
            </div>

        </div>
    </div>

</section>

<!-- ===== TESTIMONIALS ===== -->
@php
$sectionImages = json_decode($storiesSection->img_paths ?? '[]', true);
@endphp

<section class="w-full relative z-10 overflow-hidden pt-16 pb-0"
    style="background: url('{{ asset('assets/images/testimonial-bg.png') }}') center center / cover no-repeat, #F6F6F6;">

    <div class="container mx-auto px-6 lg:px-14 pt-16 pb-0">

        {{-- Heading --}}
        <h2 class="mb-10 text-gray-900"
            style="font-size: clamp(28px, 5vw, 64px); font-weight: 300;">
            The stories of
            <em style="font-family: 'Migra', serif; font-style: italic; font-weight: 300;">
                satisfaction
            </em>
        </h2>

        {{-- Testimonial Row --}}
        <div id="testimonialWrapper" style="overflow: hidden; position: relative;">

            <div id="testimonialCard"
                class="flex flex-col md:flex-row items-start gap-6 md:gap-10 mb-16 relative mt-6">

                {{-- Left: Avatar + Name --}}
                <div class="w-full md:w-1/4 flex flex-row md:flex-col items-center md:items-start gap-4 md:gap-3 flex-shrink-0">
                    <div class="rounded-full overflow-hidden border border-gray-200 flex-shrink-0"
                        style="width: clamp(72px, 12vw, 128px); height: clamp(72px, 12vw, 128px);">
                        <img id="testimonialAvatar"
                            src="{{ $storiesItems->first()->img_path ?? asset('assets/images/4.jpeg') }}"
                            alt="avatar"
                            class="w-full h-full object-cover transition-opacity duration-500"
                            onerror="this.src=''; this.parentElement.style.background='#d6cfc5';" />
                    </div>
                    <div>
                        <p id="testimonialName"
                            class="font-medium text-gray-900 text-base md:text-lg transition-opacity duration-500"
                            style="font-weight: 500;">
                            {{ $storiesItems->first()->title ?? 'Md. Mamun Molla' }}
                        </p>
                        <p id="testimonialRole"
                            class="text-gray-600 text-sm mt-0.5 transition-opacity duration-500"
                            style="font-weight: 300;">
                            {{ $storiesItems->first()->name ?? 'Professor' }}
                        </p>
                    </div>
                </div>

                {{-- Right: Quote --}}
                <div class="flex items-start gap-3 sm:gap-4 w-full md:flex-1 min-w-0">

                    {{-- SVG quote mark — hidden on very small screens --}}
                    <div class="flex-shrink-0 hidden sm:block pt-1">
                        <svg width="48" height="36" viewBox="0 0 59 44" fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                            class="md:w-[59px] md:h-[44px]">
                            <path d="M13.2977 17.4125C12.6473 17.4125 12.0232 17.5117 11.4019 17.6021C11.6032 16.9254 11.8102 16.2371 12.1427 15.6187C12.4752 14.7204 12.9944 13.9417 13.5107 13.1571C13.9423 12.3083 14.7036 11.7337 15.2636 11.0075C15.8498 10.3017 16.649 9.83208 17.2819 9.24583C17.9032 8.63333 18.7169 8.32708 19.3644 7.89542C20.0411 7.5075 20.6302 7.07875 21.2602 6.87458L22.8323 6.22708L24.2148 5.6525L22.8002 0L21.059 0.419999C20.5019 0.559999 19.8223 0.723332 19.0494 0.918749C18.259 1.06458 17.4161 1.46417 16.4769 1.82875C15.5494 2.24292 14.4761 2.52292 13.4786 3.18792C12.4752 3.82375 11.3173 4.35458 10.2965 5.20625C9.30775 6.08417 8.11483 6.84542 7.234 7.9625C6.2715 9.00667 5.32066 10.1033 4.58275 11.3517C3.72816 12.5417 3.14775 13.8483 2.53525 15.1404C1.98108 16.4325 1.53483 17.7537 1.17025 19.0371C0.478996 21.6096 0.169829 24.0538 0.0502462 26.145C-0.0489205 28.2392 0.00941282 29.9804 0.131913 31.2404C0.175663 31.8354 0.25733 32.4129 0.315663 32.8125L0.388579 33.3025L0.464413 33.285C0.983174 35.7083 2.17738 37.9351 3.90889 39.708C5.6404 41.4809 7.83845 42.7274 10.2488 43.3032C12.6591 43.8791 15.1832 43.7608 17.5291 42.962C19.875 42.1632 21.9468 40.7166 23.5049 38.7896C25.063 36.8625 26.0437 34.5337 26.3335 32.0725C26.6234 29.6114 26.2105 27.1185 25.1427 24.8821C24.0749 22.6458 22.3958 20.7575 20.2996 19.4356C18.2035 18.1138 15.7759 17.4123 13.2977 17.4125ZM45.3811 17.4125C44.7307 17.4125 44.1065 17.5117 43.4852 17.6021C43.6865 16.9254 43.8936 16.2371 44.2261 15.6187C44.5586 14.7204 45.0777 13.9417 45.594 13.1571C46.0257 12.3083 46.7869 11.7337 47.3469 11.0075C47.9332 10.3017 48.7323 9.83208 49.3652 9.24583C49.9865 8.63333 50.8002 8.32708 51.4477 7.89542C52.1244 7.5075 52.7136 7.07875 53.3436 6.87458L54.9157 6.22708L56.2982 5.6525L54.8836 0L53.1423 0.419999C52.5852 0.559999 51.9057 0.723332 51.1327 0.918749C50.3423 1.06458 49.4994 1.46417 48.5602 1.82875C47.6357 2.24583 46.5594 2.52292 45.5619 3.19083C44.5586 3.82667 43.4007 4.3575 42.3798 5.20917C41.3911 6.08708 40.1982 6.84833 39.3173 7.9625C38.3548 9.00667 37.404 10.1033 36.6661 11.3517C35.8115 12.5417 35.2311 13.8483 34.6186 15.1404C34.0644 16.4325 33.6182 17.7537 33.2536 19.0371C32.5623 21.6096 32.2532 24.0538 32.1336 26.145C32.0344 28.2392 32.0927 29.9804 32.2152 31.2404C32.259 31.8354 32.3407 32.4129 32.399 32.8125L32.4719 33.3025L32.5477 33.285C33.0665 35.7083 34.2607 37.9351 35.9922 39.708C37.7237 41.4809 39.9218 42.7274 42.3321 43.3032C44.7424 43.8791 47.2665 43.7608 49.6124 42.962C51.9583 42.1632 54.0302 40.7166 55.5883 38.7896C57.1464 36.8625 58.127 34.5337 58.4169 32.0725C58.7067 29.6114 58.2938 27.1185 57.226 24.8821C56.1582 22.6458 54.4791 20.7575 52.383 19.4356C50.2868 18.1138 47.8592 17.4123 45.3811 17.4125Z"
                                fill="#152018" />
                        </svg>
                    </div>

                    {{-- Text + arrows --}}
                    <div class="flex-1 min-w-0">
                        <p id="testimonialText"
                            class="text-gray-700 leading-relaxed transition-opacity duration-500"
                            style="font-size: clamp(13px, 1.3vw, 17px); font-weight: 300; line-height: 1.95;">
                            {!! $storiesItems->first()->body ?? '' !!}
                        </p>

                        {{-- Arrows --}}
                        <div class="flex gap-3 justify-end mt-10 md:mt-16">
                            <button onclick="changeTestimonial(-1); resetAutoPlay()" aria-label="Previous"
                                class="rounded-full border border-gray-400 flex items-center justify-center hover:bg-gray-900 hover:border-gray-900 group"
                                style="width: 44px; height: 44px;">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                    <path d="M10 3L5 8L10 13" stroke="#555" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="group-hover:stroke-white" />
                                </svg>
                            </button>
                            <button onclick="changeTestimonial(1); resetAutoPlay()" aria-label="Next"
                                class="rounded-full border border-gray-400 flex items-center justify-center hover:bg-gray-900 hover:border-gray-900 group"
                                style="width: 44px; height: 44px;">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                    <path d="M6 3L11 8L6 13" stroke="#555" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="group-hover:stroke-white" />
                                </svg>
                            </button>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    {{-- Bottom Images --}}

    {{-- Mobile: stacked layout --}}
    <div class="block md:hidden mt-16 px-4">
        <div class="w-full overflow-hidden mb-0" style="height: clamp(220px, 60vw, 380px);">
            <img src="{{ $storiesSection->img_path ?? asset('assets/images/test1.avif') }}"
                alt="Interior"
                class="w-full h-full object-cover"
                onerror="this.parentElement.style.background='#c8c0b8'; this.style.display='none';" />
        </div>
        <p class="text-gray-700 font-light leading-relaxed text-sm py-6"
            style="font-weight: 300; line-height: 1.9;">
            {!! $storiesSection->body ?? 'Bhaiya Housing is devoted to designing inspiring residential and commercial spaces that transcend expectations. With a focus on modern aesthetics, impeccable craftsmanship, and an unwavering commitment to integrity, we create environments that harmoniously balance sophistication and purpose, delivering timeless value.' !!}
        </p>
        <div class="w-full overflow-hidden" style="height: clamp(240px, 65vw, 400px);">
            <img src="{{ $sectionImages[0] ?? asset('assets/images/test2.avif') }}"
                alt="Interior"
                class="w-full h-full object-cover"
                onerror="this.parentElement.style.background='#bab4ac'; this.style.display='none';" />
        </div>
    </div>

    {{-- Desktop: side-by-side layout --}}
    <div class="hidden md:flex relative container mx-auto items-end mt-32"
        style="height: clamp(360px, 48vw, 580px);">

        {{-- Decorative stones --}}
        <div class="scroll-move absolute pointer-events-none"
            data-axis="Y"
            style="left: 0; top: 0; z-index: 3;">
            <img src="/assets/images/overview-stone.png" alt=""
                style="width: clamp(100px, 7vw, 160px); opacity: 0.8;"
                onerror="this.style.display='none'" />
        </div>
        <div class="absolute pointer-events-none"
            style="left: 0; top: -60px; z-index: -3;">
            <img src="/assets/images/reviewstonebg.png" alt=""
                style="width: clamp(100px, 7vw, 160px); opacity: 0.8;"
                onerror="this.style.display='none'" />
        </div>

        {{-- Left image + text --}}
        <div class="w-1/2 h-full flex flex-col pl-6 lg:pl-14 scroll-move" data-axis="-Y">
            <div class="flex-1 overflow-hidden" style="z-index: -10;">
                <img src="{{ $storiesSection->img_path ?? asset('assets/images/test1.avif') }}"
                    alt="Interior"
                    class="w-full h-full object-cover" 
                    onerror="this.parentElement.style.background='#c8c0b8'; this.style.display='none';" />
            </div>
            <p class="text-gray-700 font-light leading-relaxed text-sm py-6 pr-8"
                style="font-weight: 300; line-height: 1.9; max-width: 520px;">
                {!! $storiesSection->body ?? 'Bhaiya Housing is devoted to designing inspiring residential and commercial spaces that transcend expectations. With a focus on modern aesthetics, impeccable craftsmanship, and an unwavering commitment to integrity, we create environments that harmoniously balance sophistication and purpose, delivering timeless value.' !!}
            </p>
        </div>

        {{-- Right image --}}
        <div class="w-1/2 overflow-hidden pl-6 lg:pl-12 flex-shrink-0 scroll-move" data-axis="Y"
            style="height: 110%; margin-left: 2px;">
            <img src="{{ $sectionImages[0] ?? asset('assets/images/test2.avif') }}"
                alt="Interior"
                class="w-full h-full object-cover"
                onerror="this.parentElement.style.background='#bab4ac'; this.style.display='none';" />
        </div>

    </div>

</section>

<!-- ===== NEWS & EVENTS ===== -->
<section class="py-16 md:py-20 px-4 sm:px-6 md:px-12 lg:px-24 overflow-hidden relative z-10"
    style="background: url('{{ asset('assets/images/testimonial-bg.png') }}') center center / cover no-repeat, #F6F6F6;">

    {{-- Hover image (follows cursor) — desktop only --}}
    <div id="newsHoverImg"
        class="hidden md:block"
        style="position: fixed; pointer-events: none; z-index: 999;
               width: clamp(90px, 10vw, 140px); height: clamp(110px, 12vw, 170px);
               transform: rotate(10deg) translate(-50%, -50%);
               opacity: 0; transition: opacity 0.3s ease;
               overflow: hidden; top: 0; left: 0;">
        <img id="newsHoverImgEl" src="" alt=""
            style="width: 100%; height: 100%; object-fit: cover;" />
    </div>

    <div class="container mx-auto flex flex-col md:flex-row gap-8 lg:gap-24 pt-12 md:pt-[100px]">

        {{-- Left Side --}}
        <div class="w-full md:w-[30%] relative z-10">

            {{-- MOBILE heading + View All --}}
            <div class="flex md:hidden items-center justify-between mb-6">
                <h2 style="font-weight: 500; font-size: clamp(28px, 7vw, 48px);
                           color: #1a1a1a; line-height: 1.1;">
                    News
                  
                    <em style="font-style: italic; font-weight: 300;
                               font-size: 0.85em; color: #3a3a3a; margin: 0 3px;">
                        &amp; 
                    </em>
                  
                    Events
                </h2>
                <a href="/event"
                    class="flex items-center justify-center rounded-full flex-shrink-0 text-center"
                    style="width: clamp(70px, 18vw, 90px); height: clamp(70px, 18vw, 90px);
                           border: 1.5px solid #1a1a1a; font-size: 11px;
                           letter-spacing: 0.08em; color: #1a1a1a;
                           text-decoration: none; transition: background 0.3s, color 0.3s;"
                    onmouseover="this.style.background='#152018'; this.style.color='#f2ede6';"
                    onmouseout="this.style.background='transparent'; this.style.color='#1a1a1a';">
                    View All
                </a>
            </div>

            {{-- DESKTOP: rotated heading + View All --}}
            <div class="hidden md:flex flex-row items-center justify-between"
                style="min-height: clamp(300px, 40vw, 500px);">

                {{-- Rotated text block --}}
                <div style="display: flex; flex-direction: column; align-items: flex-start;
                            gap: 0; transform: rotate(-90deg); white-space: nowrap;
                            transform-origin: center center;">

                    <span style="font-weight: 500;
                                 font-size: clamp(32px, 4.5vw, 72px);
                                 color: #1a1a1a; letter-spacing: -0.01em;
                                 display: block; line-height: 1.1;">
                        News
                    </span>

                    <span class="scroll-move" data-axis="X"
                        style="font-weight: 500;
                               font-size: clamp(32px, 4.5vw, 72px);
                               color: #1a1a1a; letter-spacing: -0.01em;
                               display: block; line-height: 1.1;
                               transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
                               will-change: transform;">
                     <span style="font-family: 'Migra', serif;  ">     &amp;  </span> Events
                    </span>

                </div>

                {{-- View All circle --}}
                <a href="/event"
                    class="flex items-center justify-center rounded-full text-center flex-shrink-0"
                    style="width: clamp(90px, 9vw, 130px); height: clamp(90px, 9vw, 130px);
                           border: 1.5px solid #1a1a1a;
                           font-size: clamp(11px, 1vw, 13px);
                           letter-spacing: 0.08em; color: #1a1a1a;
                           text-decoration: none;
                           transition: background 0.3s, color 0.3s;"
                    onmouseover="this.style.background='#152018'; this.style.color='#f2ede6';"
                    onmouseout="this.style.background='transparent'; this.style.color='#1a1a1a';">
                    View All
                </a>

            </div>
        </div>

        {{-- Right Side: News list --}}
        <div class="w-full md:w-[70%] flex flex-col relative z-10">

            @forelse($newsEvents as $index => $item)
            @php
            $isLast = $index === count($newsEvents) - 1;
            $type = ucfirst($item['type']);
            $date = $item['start_date'];
            $url = '/' . strtolower($item['type']) . '/' . $item['id'];
            $imgPath = asset($item['img_path'] ?? '');
            @endphp

            <a href="{{ $url }}"
                class="news-row border-t {{ $isLast ? 'border-b' : '' }} border-[#ccc3b6]
                       py-5 md:py-6 lg:py-8
                       flex flex-col sm:flex-row gap-2 sm:gap-8 md:gap-12 items-start
                       group transition duration-300
                       px-3 sm:px-4 -mx-3 sm:-mx-4 cursor-pointer"
                data-img="{{ $imgPath }}"
                style="text-decoration: none;">

                {{-- Type + Date --}}
                <div class="w-full sm:w-36 md:w-40 flex-shrink-0
                            flex sm:flex-col flex-row items-baseline gap-2 sm:gap-0">
                    <p class="text-base md:text-xl text-[#54504a] font-medium leading-tight">
                        {{ $type }}
                    </p>
                    @if($date)
                    <p class="text-xs md:text-sm text-[#857f77] sm:mt-1 leading-tight">
                        {{ \Carbon\Carbon::parse($date)->format('d F Y') }}
                    </p>
                    @endif
                </div>

                {{-- Title --}}
                <div class="flex-1 min-w-0">
                    <h3 class="text-base md:text-xl lg:text-[1.35rem] text-[#2a2825]
                               font-light leading-snug group-hover:text-[#152018]
                               transition-colors duration-300">
                        {{ $item['title'] }}
                    </h3>
                </div>

            </a>
            @empty
            <p class="text-[#857f77] py-10 text-center">No data</p>
            @endforelse

        </div>
    </div>
</section>



<!-- ===== PARTNERS / CTA ===== -->
<section class="relative z-10 w-full py-16 md:py-20 px-6 md:px-12 lg:px-24 overflow-hidden"
    style="background: #fff;">

    {{-- Background pattern --}}
    <div class="absolute inset-0 pointer-events-none overflow-hidden" style="z-index: 0;">
        <div class="absolute left-0 top-0 w-full sm:w-1/2 md:w-1/3 h-full opacity-50"
            style="background-image: url('/assets/images/partners-bg.png');
                   background-repeat: repeat-y;
                   background-size: 100% auto;">
        </div>
    </div>

    {{-- Content --}}
    <div class="relative z-10 px-0 sm:px-6 md:px-16 lg:px-24">

        {{-- Heading --}}
        <h2 class="mb-10 md:mb-16 font-light leading-tight text-gray-900 scroll-move"
            data-axis="Y"
            style="font-size: clamp(28px, 4.5vw, 64px);">
            @php
            $partnerTitle = $partners->title ?? 'Be a partner, be a patron';
            $titleParts = explode(',', $partnerTitle);
            @endphp

            @if(count($titleParts) >= 2)
            @php preg_match('/^(.*?)(\w+)$/u', trim($titleParts[0]), $m1); @endphp
            <span class="font-normal">{{ trim($m1[1] ?? '') }}</span>
            <em class="font-light italic font-family: 'Migra', serif;">{{ trim($m1[2] ?? $titleParts[0]) }}</em>
            <span class="font-normal">,</span><br />

            @php preg_match('/^(.*?)(\w+)$/u', trim($titleParts[1]), $m2); @endphp
            <span class="font-normal">{{ trim($m2[1] ?? '') }}</span>
            <em class="font-light italic font-family: 'Migra', serif;">{{ trim($m2[2] ?? $titleParts[1]) }}</em>
            @else
            {{ $partnerTitle }}
            @endif
        </h2>

        {{-- Two Cards Row --}}
        <div class="relative flex flex-col md:flex-row gap-4 items-stretch md:ml-[0%] lg:ml-[20%] xl:ml-[28%]">

            {{-- Card 1: Landowner --}}
            <a href="{{ $partners->url ?? '/landowner-contact' }}"
                class="relative flex flex-col justify-between flex-1 cursor-pointer group
                       border rounded-none p-5 md:p-6
                         min-h-[300px] sm:min-h-[380px] md:min-h-[460px] lg:min-h-[520px]
                       transition-all duration-300"
                style="border-color: #c8bfb0; background: rgba(242,237,230,0.6); text-decoration: none;"
                onmouseover="this.style.borderColor='#8a7a60';"
                onmouseout="this.style.borderColor='#c8bfb0';">

                {{-- Arrow top right --}}
                <div class="flex justify-end">
                    <div class="w-9 h-9 rounded-full border border-gray-400
                                flex items-center justify-center
                                transition-all duration-300
                                group-hover:bg-gray-900 group-hover:border-gray-900">
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                            <path d="M3 11L11 3M11 3H5M11 3V9"
                                class="transition-all duration-300 group-hover:stroke-white"
                                stroke="#555" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                </div>

                {{-- Bottom text --}}
                <div class="mt-auto pt-6 md:pt-8">
                    <h3 class="text-gray-900 font-normal mb-2"
                        style="font-size: 20px">        
                        {{ $partners->short ?? 'Contact as Landowner' }}
                    </h3>
                
                    <div class="text-sm font-light leading-relaxed " style="font-size: 18px; color: #6A6A6A;">
                        {!! $partners->body ?? 'Partner with us to transform your property into a landmark development.' !!}
                    </div>
                </div>
            </a>

            {{-- Card 2: Customer --}}
            <a href="{{ $partners->extra ?? '/customer-contact' }}"
                class="flex-shrink-0 scroll-move relative flex flex-col justify-between flex-1 cursor-pointer group
                       overflow-hidden p-5 md:p-6
                       min-h-[300px] sm:min-h-[380px] md:min-h-[460px] lg:min-h-[520px]
                       md:-mt-10"
                style="text-decoration: none;">

                {{-- Background image --}}
                <img src="{{ $partners->img_path ?? asset('assets/images/customer.png') }}"
                    alt="room"
                    class="absolute inset-0 w-full h-full object-cover
                           transition-transform duration-700 group-hover:scale-105 z-0"
                    onerror="this.parentElement.style.background='#1a2a2a'; this.style.display='none';" />

                {{-- Dark overlay --}}
                <div class="absolute inset-0 z-[1]"
                    style="background: linear-gradient(to top, rgba(0, 0, 0, 0.39) 40%, rgba(0,0,0,0.25) 100%);"></div>

                {{-- Arrow top right --}}
                <div class="relative z-10 flex justify-end">
                    <div class="w-9 h-9 rounded-full border border-white
                                flex items-center justify-center
                                transition-all duration-300 group-hover:bg-white">
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                            <path d="M3 11L11 3M11 3H5M11 3V9"
                                class="transition-all duration-300 group-hover:stroke-gray-900"
                                stroke="white" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                </div>

                {{-- Text --}}
                <div class="relative z-10 flex flex-col items-start justify-center flex-1 mt-4">
                    <h3 class="text-white font-normal mb-2"
                        style="font-size: 30px;">
                        {{ $partners->location ?? 'Contact as Customer' }}
                    </h3>
                    <p class="text-sm font-light leading-relaxed text-white/80  " style="font-size: 18px;">
                     Get in touch to find your dream home with Bhaiya Housing.
                    </p>
                </div>
            </a>

            {{-- Decorative stone — moved outside flex children, anchored to wrapper --}}
            <img src="{{ asset('images/mission-stone.png') }}" alt=""
                class="absolute pointer-events-none scroll-move hidden md:block"
                data-axis="Y"
                style="width: clamp(80px, 8vw, 120px); bottom: -10px; right: -50px; z-index: 20;"
                onerror="this.style.display='none';">
        </div>

        {{-- Radar / pulse SVG — decorative, desktop only --}}
        <div class="absolute pointer-events-none hidden md:block"
            style="width: 250; bottom: 40px; left: 50px; z-index: 20;">
            <svg xmlns="http://www.w3.org/2000/svg" width="250" height="250" viewBox="0 0 300 300">
                <defs>
                    <style>
                        .ring1 {
                            animation: radar-pulse 2.5s ease-out infinite;
                        }

                        @keyframes radar-pulse {
                            0% {
                                r: 67.5px;
                                opacity: 0.9;
                                stroke-width: 2.5;
                            }

                            100% {
                                r: 130px;
                                opacity: 0;
                                stroke-width: 0.5;
                            }
                        }
                    </style>
                    <filter id="filter0_d" x="0.3" y="0.3" width="158.4" height="158.4"
                        filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                        <feFlood flood-opacity="0" result="BackgroundImageFix" />
                        <feColorMatrix in="SourceAlpha" type="matrix"
                            values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha" />
                        <feOffset dy="4" />
                        <feGaussianBlur stdDeviation="5.35" />
                        <feComposite in2="hardAlpha" operator="out" />
                        <feColorMatrix type="matrix"
                            values="0 0 0 0 0.945833 0 0 0 0 0.715603 0 0 0 0 0.279809 0 0 0 1 0" />
                        <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow" />
                        <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow" result="shape" />
                    </filter>
                    <filter id="filter1_d" x="21" y="22" width="116" height="116"
                        filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                        <feFlood flood-opacity="0" result="BackgroundImageFix" />
                        <feColorMatrix in="SourceAlpha" type="matrix"
                            values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha" />
                        <feOffset dy="4" />
                        <feGaussianBlur stdDeviation="2" />
                        <feComposite in2="hardAlpha" operator="out" />
                        <feColorMatrix type="matrix"
                            values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0" />
                        <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow1" />
                        <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow1" result="shape" />
                    </filter>
                </defs>

                <g transform="translate(150,150)">
                    <circle class="ring1" cx="0" cy="0" r="67.5"
                        fill="none" stroke="#B79870" stroke-width="2" />
                </g>

                <g transform="translate(70.5, 74.5)">
                    <g filter="url(#filter0_d)">
                        <circle cx="79.5" cy="75.5" r="67.5"
                            stroke="#B79870" stroke-width="2"
                            shape-rendering="crispEdges" fill="none" />
                    </g>
                    <g filter="url(#filter1_d)">
                        <circle cx="79" cy="76" r="52" fill="white" />
                        <circle cx="79" cy="76" r="53" stroke="#A68356" stroke-width="2" fill="none" />
                    </g>
                    <path d="M52 85.5238L70.4079 68.9097L72.157 78.1099L64.2359 85.5238H52Z" fill="#2B2B2B" />
                    <path d="M76.069 74.3843L72.1569 78.1099L70.4078 68.9097L76.069 74.3843Z" fill="#050505" />
                    <path d="M81.8718 68.9097L107 91.9159H94.764L70.4078 68.9097H81.8718Z" fill="#323232" />
                    <path d="M91.333 64.2029L98.5642 60V72.7804L91.333 76.9423V64.2029Z" fill="#323232" />
                </g>
            </svg>
        </div>

    </div>
</section>
@if(count($storiesItems) > 0)
<script>
    const testimonials = @json($storiesItems);
    console.log(testimonials);

    let currentIndex = 0;
    let autoPlayTimer = null;
    let isAnimating = false;

    function changeTestimonial(dir) {
        if (isAnimating) return;
        isAnimating = true;

        const card = document.getElementById('testimonialCard');
        const wrapper = document.getElementById('testimonialWrapper');

        // Slide out current card
        card.style.transition = 'transform 0.45s cubic-bezier(0.77, 0, 0.175, 1), opacity 0.3s ease';
        card.style.transform = `translateX(${dir > 0 ? '-100%' : '100%'})`;
        card.style.opacity = '0.3';

        setTimeout(() => {
            // Update content
            currentIndex = (currentIndex + dir + testimonials.length) % testimonials.length;
            const t = testimonials[currentIndex];

            document.getElementById('testimonialAvatar').src = t.avatar ?? '';
            document.getElementById('testimonialName').textContent = t.name ?? '';
            document.getElementById('testimonialRole').textContent = t.role ?? '';
            document.getElementById('testimonialText').innerHTML = t.text ?? '';
            // Snap to opposite side instantly (no transition)
            card.style.transition = 'none';
            card.style.transform = `translateX(${dir > 0 ? '100%' : '-100%'})`;
            card.style.opacity = '0.3';

            // Force reflow
            card.getBoundingClientRect();

            // Slide in
            card.style.transition = 'transform 0.45s cubic-bezier(0.77, 0, 0.175, 1), opacity 0.35s ease';
            card.style.transform = 'translateX(0)';
            card.style.opacity = '1';

            setTimeout(() => {
                isAnimating = false;
            }, 450);

        }, 380);
    }

    function resetAutoPlay() {
        clearInterval(autoPlayTimer);
        autoPlayTimer = setInterval(() => changeTestimonial(1), 5000);
    }

    resetAutoPlay();
</script>
@endif
<script>
    let progressInterval = null;

    function startProgress(thumbEl) {
        const video = document.getElementById('heroVideo');
        const bar = thumbEl.querySelector('.progress-bar');
        if (!bar) return;

        bar.style.transition = 'none';
        bar.style.width = '0%';
        bar.classList.remove('hidden');

        clearInterval(progressInterval);

        progressInterval = setInterval(() => {
            if (!video.duration) return;
            const pct = (video.currentTime / video.duration) * 100;
            bar.style.transition = 'width 0.3s linear';
            bar.style.width = pct + '%';
            if (pct >= 100) clearInterval(progressInterval);
        }, 300);
    }

    function switchVideo(el) {
        const video = document.getElementById('heroVideo');
        const source = document.getElementById('heroVideoSource');

        // loop বন্ধ করো — শেষ হলে next যাবে
        video.loop = false;

        source.src = el.dataset.video;
        video.load();
        video.play();

        document.getElementById('heroTitle').textContent = el.dataset.title;
        document.getElementById('heroAddress').textContent = el.dataset.address;
        document.getElementById('heroLearnMore').href = el.dataset.url;

        document.querySelectorAll('.thumb-item').forEach(t => {
            t.style.border = '2px solid rgba(255,255,255,0.3)';
            t.querySelector('img')?.classList.replace('opacity-90', 'opacity-70');
            const b = t.querySelector('.progress-bar');
            if (b) {
                b.style.width = '0%';
                b.classList.add('hidden');
            }
        });

        el.style.border = '2px solid rgba(255,255,255,0.8)';
        el.querySelector('img')?.classList.replace('opacity-70', 'opacity-90');

        video.addEventListener('loadedmetadata', () => startProgress(el), {
            once: true
        });
    }

    function autoNext() {
        const thumbs = Array.from(document.querySelectorAll('.thumb-item'));
        const activeIndex = thumbs.findIndex(t => t.style.border.includes('0.8'));
        const nextIndex = (activeIndex + 1) % thumbs.length;
        switchVideo(thumbs[nextIndex]);
    }

    document.addEventListener('DOMContentLoaded', () => {
        const video = document.getElementById('heroVideo');
        video.loop = false;

        // video শেষ হলে next-এ যাও
        video.addEventListener('ended', autoNext);

        const first = document.querySelector('.thumb-item.active');
        if (first && video) {
            video.addEventListener('loadedmetadata', () => startProgress(first), {
                once: true
            });
        }
    });

    function openVideoModal() {
        const modal = document.getElementById('videoModal');
        const video = document.getElementById('modalVideo');
        modal.style.display = 'flex';
        video.currentTime = 0;
        video.play();
    }

    function closeVideoModal(e) {
        if (e && e.target !== document.getElementById('videoModal')) return;
        const modal = document.getElementById('videoModal');
        const video = document.getElementById('modalVideo');
        video.pause();
        video.currentTime = 0;
        modal.style.display = 'none';
    }

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
            document.getElementById('modalVideo').pause();
            document.getElementById('videoModal').style.display = 'none';
        }
    });
</script>
@push('scripts')
<script>
    window.addEventListener('load', function() {

        // ── Border line animation only ──
        gsap.to('.quality-border-line', {
            width: '100%',
            duration: 1.4,
            ease: 'power2.out',
            scrollTrigger: {
                trigger: '#quality-grid',
                start: 'top 80%',
                once: true,
            }
        });

        

    });
</script>

<script>
    (function() {
        const hoverImg = document.getElementById('newsHoverImg');
        const hoverImgEl = document.getElementById('newsHoverImgEl');
        const rows = document.querySelectorAll('.news-row');

        // Follow cursor
        document.addEventListener('mousemove', (e) => {
            hoverImg.style.left = e.clientX + 'px';
            hoverImg.style.top = e.clientY + 'px';
        });

        rows.forEach(row => {
            const src = row.dataset.img;

            row.addEventListener('mouseenter', () => {
                if (!src) return;
                hoverImgEl.src = src;
                hoverImg.style.opacity = '1';
            });

            row.addEventListener('mouseleave', () => {
                hoverImg.style.opacity = '0';
            });
        });
    })();
</script>
<script>
document.querySelectorAll('.quality-col').forEach(col => {
    const wrap = col.querySelector('.quality-img-wrap');
    const img = col.querySelector('.quality-img');

    col.addEventListener('mouseenter', () => {
        wrap.style.width = '100%';
        wrap.style.height = '750px';
        img.style.transform = 'scale(1.02)'; // ← 1.04 থেকে মাত্র 1.06
    });

    col.addEventListener('mouseleave', () => {
        wrap.style.width = '60%';
        wrap.style.height = '550px';
        img.style.transform = 'scale(1)'; // ← default
    });
});
</script>
@endpush
@endsection