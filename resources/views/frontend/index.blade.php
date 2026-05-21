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
"url" => url('/events'),
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
<section id="home" class="fixed hero-fixed  top-0 left-0 w-full h-screen z-0 overflow-hidden">

    {{-- Background --}}
    <div class="absolute inset-0">
        <img
            src="{{ $hero->img_path ?? asset('assets/images/hero-bg.jpg') }}"
            alt="hero-bg"
            class="w-full h-full object-cover scale-[1.06] animate-[zoomOut_8s_ease_forwards]" />
        <div
            class="absolute inset-0"
            style="background: linear-gradient(110deg, rgba(13,18,28,0.72) 0%, rgba(13,18,28,0.52) 55%, rgba(13,18,28,0.28) 100%)"></div>
    </div>

    {{-- Content --}}
    <div class="relative z-10 h-full flex flex-col justify-center items-end">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mt-5">
                <h1
                    class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl leading-[1.08] opacity-0 animate-[fadeUp_0.8s_0.35s_ease_forwards]">

                    We
                    <span class="font-migra-italic">
                        transform
                    </span>

                    your <br>

                    <span class="font-migra-italic">
                        dreams
                    </span>

                    into addresses
                </h1>
            </div>
            <div class="mt-10 md:mt-28 max-w-xl opacity-0 animate-[fadeUp_0.8s_0.55s_ease_forwards]">
                <p class="md:ml-10 opacity-80 text-sm md:text-base leading-relaxed font-light md:px-10">
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
            <h2 class="font-display font-size[72px]  text-4xl sm:text-5xl font-light leading-tight text-gray-900 text-center p-[50px]">
                <strong>Building </strong> <br> <strong>dreams for</strong>
                <span>decades</span>
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
             DESKTOP LAYOUT (≥ md), original
        ══════════════════════════════════ -->

        <!-- Row 1 -->
        <div class="hidden md:flex relative flex-wrap items-start">

            <!-- Col 1: Heading -->
            <div class="w-full h-full md:w-1/4 pt-6 z-10 fade-in delay-1">
                <h2 class="font-display  font-semibold text-[72px] font-light leading-tight text-gray-900 text-center tracking-tight">
                    Building <br>
                    dreams for <span class="font-cormorant italic">decades</span>
                </h2>

                <div class="mt-8 float-down fade-in delay-2" style="position:relative; left:-60px;">
                    <img src="{{ $extraImages[0] ?? asset('assets/images/side.jpg') }}"
                        alt="Outdoor space"
                        class="img-shadow rounded-sm object-cover"
                        style="width:400px; height:300px; object-position:center;"
                        onerror="this.style.background='#d6cfc5'; this.removeAttribute('src');" />
                </div>
            </div>

            <!-- Col 2: Big Center Image -->
            <div class="w-full md:w-5/12 relative fade-in delay-2" style="margin-left:2% ;">
                <div class="img-shadow rounded-sm overflow-hidden" style="height:800px;">
                    <img src="{{ $dreams->img_path ?? asset('assets/images/main.avif') }}"
                        alt="Modern building"
                        class="w-full h-full object-cover"
                        onerror="this.style.background='#c5bdb5'; this.style.height='100%'; this.removeAttribute('src');" />
                </div>
            </div>

            <!-- Col 3: Right side -->
            <div class="w-full md:w-1/4 flex flex-col items-start pl-6 pt-2 fade-in delay-3 scroll-move" data-axis="Y" data-max-move="50" style="margin-left:4%;">

                <div class="float-up mb-8 self-end ">
                    <div class=" absolute pointer-events-none"

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

                <p class="text-sm leading-relaxed fade-in delay-3 mb-8"
                    style="color:#555; max-width:280px; line-height:1.9;">
                    {{ $dreams->short ?? 'Since 2012, Bhaiya Housing, a distinguished part of Bhaiya Group, has redefined modern infrastructure. Merging architectural brilliance with purposeful design, we craft exquisite homes and commercial spaces that embody aspirations, inspire ambition, and effortlessly adapt to the evolving rhythms of modern life.' }}
                </p>

                <div class="fade-in delay-4">
                    <a href="{{route('front.about') }}" class="circle-btn hover-lg z-20">Learn More</a>
                </div>
            </div>

        </div><!-- /Row 1 desktop -->

        <!-- Row 2: bottom images (desktop only) -->
        <div class="hidden md:flex relative flex-wrap items-center scroll-move" data-axis="Y" data-max-move="50">

            <div class="absolute z-20 fade-in delay-3 float-down " style="left:22%; bottom:0px;">
                <img src="{{ $extraImages[1] ?? asset('assets/images/sub.jpg') }}"
                    alt="Property"
                    class="img-shadow rounded-sm object-cover"
                    style="width:400px; height:400px; object-position:center;"
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
    <div class="hidden md:block absolute z-20" style="top: 200px; right: 350px">
        <a
            id="heroLearnMore"
            href="/projects/{{ $first->id }}"
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
            href="/projects/{{ $first->id }}"
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
                data-url="/projects/{{ $project->id }}"
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
    <div class="absolute inset-0 w-full h-full overflow-hidden" style="z-index:0;">
        <img id="qualityBg" class="absolute w-full scroll-move"
            data-axis="Y"
            src="/assets/images/quality-bg.png" alt=""
            style="top:-20%; left:0; height:140%; object-fit:cover; will-change:transform;" />
    </div>

    {{-- ── Part 1: Hero ── --}}
    <div class="relative z-10 w-full flex flex-col items-center justify-center text-center overflow-hidden
                px-4 pt-16 pb-0
                sm:px-6 sm:pt-20
                md:px-10 md:pt-24">

        {{-- Ghost text --}}
        <span class="absolute inset-0 flex items-center justify-center tracking-[5px] select-none pointer-events-none scroll-move"
            data-axis="Y"
            style="
font-size: clamp(100px, 12vw, 260px);                    font-weight:bolder;
                    color:rgba(255,255,255,0.04);
                    letter-spacing:0.05em;
                    white-space:nowrap;">
            EVERY <br>
            EVERY
        </span>

        {{-- Headline --}}
        <div class="relative z-10 px-2">
            <h2 class="text-white font-light mb-1"
                style="
                       font-size:clamp(20px,4vw,56px);
                       font-weight:300;
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
        <div class="relative z-10 w-full mx-auto overflow-hidden
                    px-4 sm:px-6 md:px-0"
            style="max-width:900px; height:clamp(220px,45vw,520px);">
            <img src="{{ $expertise->img_path ?? asset('assets/images/quality-top.jpg') }}"
                alt="Architectural detail"
                class="w-full h-full object-cover"
                onerror="this.parentElement.style.background='#1e2e20'; this.style.display='none';" />
            <div class="absolute pointer-events-none"

                style="right:-10px; top:-10px; z-index:3;">
                <svg width="72" height="69" viewBox="0 0 72 69" fill="none" xmlns="http://www.w3.org/2000/svg" class="active">
                    <g clip-path="url(#clip0_328_99169)">
                        <path d="M3.75004 62.8501C5.13004 60.6201 6.90004 60.1701 8.65004 61.5901C8.64004 61.7101 8.59004 61.8201 8.50004 61.9001C8.44004 61.9501 8.35004 61.9901 8.26004 61.9901C8.26004 62.1901 8.48004 62.0401 8.55004 62.1501C9.05004 62.5701 9.24004 63.1701 9.51004 63.7301C9.30004 64.3501 10.23 64.0301 10.17 64.5201C10.05 64.9401 9.64004 65.0401 9.36004 65.2901C8.71004 65.4501 8.05004 65.6801 7.49004 65.0701C7.43004 64.9401 7.40004 64.8001 7.40004 64.6601C6.95004 63.6601 6.10004 64.0901 5.38004 64.1101C3.70004 64.5201 3.66004 64.4901 3.76004 62.8501H3.75004Z" fill="#C6A565" class="svg-elem-1"></path>
                        <path d="M21.73 50.81C22.81 50.99 23.48 51.65 23.47 52.71C23.47 53.52 22.67 53.71 21.99 53.95C20.89 54.34 19.94 53.93 19.28 53.21C18.88 52.78 18.97 51.84 19.78 51.5C20.35 51.27 20.74 50.56 21.5 50.84C21.56 50.98 21.31 51.02 21.39 51.16C21.52 51.05 21.64 50.94 21.73 50.79V50.81Z" fill="#D3BA85" class="svg-elem-2"></path>
                        <path d="M7.75999 64.6101C7.66999 64.6801 7.57999 64.7401 7.48999 64.8101C6.64999 65.3201 7.19999 65.9401 7.34999 66.5201C7.51999 66.8701 7.83999 67.1901 7.51999 67.6201C7.09999 68.2601 6.51999 68.1501 5.92999 67.9401C5.21999 68.1501 6.38999 67.4001 5.65999 67.4401C4.97999 67.4701 3.64999 67.6601 4.62999 66.1701C4.68999 66.0701 4.47999 66.1401 4.40999 66.1401C4.09999 66.1401 3.85999 65.9101 3.55999 65.8901C2.70999 64.8201 3.39999 63.8501 3.74999 62.8601C3.94999 63.8101 4.27999 64.5001 5.36999 63.6701C5.39999 64.2401 5.81999 64.0101 6.12999 64.0701C6.69999 64.1701 7.42999 63.8101 7.75999 64.6101Z" fill="#CDAE6D" class="svg-elem-3"></path>
                        <path d="M37.9 63.23C38.58 63.33 38.7 64.04 39.15 64.41C40.11 65.19 39.57 65.51 38.66 65.62C38.23 65.95 37.7 65.79 37.23 65.9C37.05 65.94 36.87 65.96 36.69 65.96C36.45 65.94 36.21 65.91 35.98 66C35.68 66.11 35.38 66.27 35.04 66.21C34.67 66.03 34.6 65.69 34.6 65.32C34.61 65.11 34.66 64.91 34.73 64.71C34.98 64.32 35.03 63.86 35.15 63.43C35.83 63.08 36.38 62.24 37.31 62.85C37.49 62.99 37.48 63.42 37.88 63.23H37.9Z" fill="#BE9950" class="svg-elem-4"></path>
                        <path d="M19.03 40.6899C20.26 40.9499 21.43 41.2699 21.08 42.9499C21.08 43.1099 21.02 43.2499 20.92 43.3799C20.45 43.8599 19.92 44.0499 19.29 43.6699C19.19 43.5999 19.1 43.5099 19.03 43.4099C19.02 43.3299 18.98 43.2499 18.93 43.1799C18.8 43.2999 18.84 43.4699 18.77 43.6199C18.71 43.8099 18.62 43.9799 18.5 44.1299C18.03 44.4299 17.48 44.5499 16.96 44.7299C16.63 44.5399 16.41 44.2399 16.22 43.9199C16.06 43.6499 15.95 43.3699 15.97 43.0499C16.34 42.2399 17.05 42.3799 17.73 42.4199C17.87 42.3899 18.02 42.4699 18.15 42.3899C17.96 42.3899 17.78 42.3499 17.6 42.2899C17.42 42.1399 17.34 41.9399 17.36 41.7099C17.75 41.0999 18.27 40.6999 19.03 40.6899Z" fill="#E7D290" class="svg-elem-5"></path>
                        <path d="M43.69 33.22C43.18 33.03 42.66 32.83 42.37 32.32C42.08 32.17 41.95 31.96 42.12 31.64C42.57 31.44 42.94 31.64 43.34 31.86C43.58 31.99 43.34 31.75 43.4 31.71C43.44 30.18 44.53 30.76 45.33 30.74C45.59 30.76 45.85 30.79 46.1 30.81C46.52 30.93 46.96 30.53 47.36 30.86C47.44 30.95 47.51 31.06 47.56 31.17C47.78 31.84 48.49 31.15 48.78 31.61C48.81 31.98 48.56 32.09 48.27 32.14C47.71 32.34 47.26 32.83 46.61 32.79C45.52 32.12 44.7 33.35 43.69 33.21V33.22Z" fill="#CFB37B" class="svg-elem-6"></path>
                        <path d="M22.04 10.31C21.32 10.05 21.49 9.43004 21.48 8.89004C21.56 8.49004 21.49 8.06004 21.74 7.70004V7.68004C22.28 7.38004 22.58 6.74004 23.26 6.68004C24.36 6.35004 24.98 6.89004 25.38 7.84004C25.51 9.07004 24.61 9.09004 23.83 9.04004C22.99 8.98004 22.64 9.32004 22.58 10.09C22.45 10.28 22.28 10.38 22.04 10.32V10.31Z" fill="#D6B975" class="svg-elem-7"></path>
                        <path d="M47.3901 31.2C47.3401 31.11 47.2801 31.02 47.2301 30.94C46.8801 30.56 47.7901 29.9 46.9301 29.64C46.7701 29.5 46.6801 29.33 46.6801 29.12C46.8601 28.58 47.2301 28.17 47.6001 27.76C48.1001 27.94 48.3101 27.6 48.5001 27.25C48.7901 28.55 50.1401 29.56 49.5001 31.12C49.2601 31.72 49.0101 32.2 48.2701 32.15C48.4501 31.97 48.6601 31.81 48.6001 31.5C48.3401 30.81 47.7101 31.64 47.3901 31.21V31.2Z" fill="#E3CE8F" class="svg-elem-8"></path>
                        <path d="M19.03 40.6899C18.43 40.9599 18.11 41.6499 17.41 41.7699C17.26 42.4199 16.65 42.4699 16.19 42.7099C15.76 43.0999 15.63 43.7199 15.15 44.0799C14.74 44.3299 14.52 44.7699 14.15 45.0599C13.94 45.1099 13.74 45.1199 13.69 44.8399C13.52 43.8499 13.97 43.0899 14.65 42.4399C14.89 41.8199 15.62 41.5999 15.87 40.9799C16.88 40.3799 17.87 39.6999 19.03 40.6899Z" fill="#DFC782" class="svg-elem-9"></path>
                        <path d="M42.78 28.4501C43.57 27.6101 44.17 26.5001 45.51 26.3801C45.7 26.3601 45.89 26.3601 46.08 26.3501C46.27 26.6201 46.41 26.9101 46.39 27.2601C46.37 27.8501 46.44 28.4601 46.07 28.9801C45.66 29.3801 45.53 30.0901 44.8 30.1501C43.7 30.0501 43.66 29.5701 44.34 28.8501C44.49 28.7201 44.27 28.8501 44.43 28.7401C44.5 28.6801 44.58 28.6401 44.68 28.6101C44.59 28.4901 44.55 28.6701 44.47 28.6501C44.27 28.9501 44.04 29.2101 43.7 29.3501C43.47 29.5501 43.26 29.8001 42.93 29.8501C42.81 29.8101 42.7 29.7501 42.62 29.6501C42.55 29.5501 42.51 29.4301 42.5 29.3001C42.59 29.0101 42.75 28.7501 42.79 28.4501H42.78Z" fill="#DBC288" class="svg-elem-10"></path>
                        <path d="M38.97 66.08C40.2 66 39.77 66.9 39.35 67.05C38.68 67.28 38.84 67.86 38.52 68.2C38.21 68.32 37.79 67.98 37.56 68.43C36.17 68.63 34.96 68.25 33.89 67.34C33.54 67.04 33.51 66.8 33.84 66.5C34.49 66.57 34.98 67.22 35.7 67.04C36.1 67.05 36.41 66.87 36.69 66.61C37.35 66 38.26 66.49 38.97 66.08Z" fill="#CBAB64" class="svg-elem-11"></path>
                        <path d="M69.49 4.35004C70.24 4.60004 70.7 5.22004 71.04 5.82004C71.61 6.82004 70.88 7.24004 70.03 7.48004C69.81 7.43004 69.7 7.28004 69.66 7.07004C70.18 6.28004 69.24 6.92004 69.24 6.64004C68.88 6.48004 68.51 6.52004 68.13 6.57004C67.47 6.67004 67.31 6.27004 67.34 5.71004C67.48 5.34004 67.86 5.15004 68.03 4.79004C68.55 4.86004 68.87 4.42004 69.3 4.29004C69.36 4.31004 69.43 4.32004 69.49 4.34004V4.35004Z" fill="#DCC27D" class="svg-elem-12"></path>
                        <path d="M28.77 19.9201C28.23 19.0201 28.88 18.5601 29.35 18.2401C29.88 17.8801 30.6 17.7601 31.05 18.4901C31.42 19.0901 31.34 19.7201 30.73 20.0501C30.07 20.4001 29.32 20.5001 28.76 19.9201H28.77Z" fill="#DECA9D" class="svg-elem-13"></path>
                        <path d="M37.46 34.7001C36.91 34.0101 37.24 33.3501 37.84 33.1601C38.55 32.9401 39.51 32.6401 39.98 33.7201C39.98 34.0901 40.08 34.4501 40.05 34.8201C39.74 35.2701 39.27 35.4601 38.79 35.6301C38.5 35.1001 37.83 35.1201 37.46 34.7001Z" fill="#CFB477" class="svg-elem-14"></path>
                        <path d="M5.21001 51.55C5.04001 51.38 5.40001 50.91 5.74001 50.77C6.31001 50.52 7.02001 49.97 7.58001 50.76C8.04001 51.41 7.77001 52.33 7.35001 52.64C6.60001 53.18 6.06001 52.31 5.21001 51.56V51.55Z" fill="#CDAF6D" class="svg-elem-15"></path>
                        <path d="M0.0600488 21.81C0.0700488 20.26 1.20005 20.07 2.32005 20.15C3.30005 20.22 3.91005 20.86 3.76005 21.96C2.79005 21.16 3.13005 22.73 2.55005 22.63C2.36005 22.72 2.16005 22.73 1.97005 22.63C1.88005 22.53 1.84005 22.41 1.86005 22.27C1.91005 21.61 1.31005 22.24 1.18005 21.94C0.840049 21.62 0.420049 21.92 0.0500488 21.81H0.0600488Z" fill="#E8D59A" class="svg-elem-16"></path>
                        <path d="M69.56 0.70988C70.77 1.74988 70.75 2.84988 69.49 4.34988H69.37C69.03 4.34988 68.67 4.40988 68.37 4.16988C68.14 3.97988 67.97 3.74988 67.86 3.47988C67.76 3.18988 67.73 2.89988 67.98 2.65988C68.18 2.52988 68.39 2.53988 68.6 2.63988C68.72 2.71988 68.82 2.80988 68.92 2.90988C69.11 3.09988 69.32 3.21988 69.45 2.88988C69.5 2.77988 69.77 2.58988 69.5 2.50988C69.38 2.46988 69.16 2.61988 68.96 2.59988C68.82 2.54988 68.69 2.46988 68.58 2.36988C68.3 2.07988 68.13 1.74988 68.17 1.32988C68.47 0.75988 68.98 0.64988 69.56 0.70988Z" fill="#DCC27D" class="svg-elem-17"></path>
                        <path d="M67.44 5.65989C67.64 5.95989 67.61 6.60989 68.29 6.18989C68.73 5.91989 69.12 6.10989 69.41 6.50989C69.36 6.64989 69.27 6.69989 69.14 6.66989C69.07 6.66989 69.02 6.66989 69.01 6.66989C69 6.66989 68.99 6.66989 68.98 6.66989C69.16 6.57989 68.93 6.73989 69.12 6.66989C69.38 6.69989 69.59 6.80989 69.73 7.01989C69.82 7.16989 69.92 7.32989 70.01 7.47989C69.85 7.59989 69.69 7.71989 69.53 7.82989C69.18 7.79989 68.87 7.88989 68.64 8.15989C67.13 8.45989 67.02 7.32989 66.78 6.33989C67 6.10989 66.99 5.66989 67.43 5.63989L67.44 5.65989Z" fill="#D6BA76" class="svg-elem-18"></path>
                        <path d="M19.1001 48.8701C18.3101 49.3001 17.4901 49.1101 16.6801 48.9401C16.5701 48.9401 16.5001 48.9001 16.4701 48.8301C16.4301 48.7501 16.4201 48.7101 16.4401 48.7001C16.5701 48.1101 17.0701 47.8701 17.5101 47.5601C17.7401 47.4201 18.0001 47.3801 18.2601 47.3801C18.5201 47.3801 18.7801 47.3501 19.0301 47.3401C19.3001 47.3401 19.5701 47.3401 19.8201 47.4901C20.6201 48.4901 19.6901 48.5901 19.1001 48.8701Z" fill="#BF9D59" class="svg-elem-19"></path>
                        <path d="M68.19 1.23996L68.82 2.27996C68.7 2.62996 68.19 2.33996 68.08 2.71996C67.94 2.95996 68.02 3.17996 68.14 3.39996C68.12 3.77996 68.14 4.17996 67.56 4.11996C67.11 3.78996 66.66 3.45996 66.21 3.13996C65.32 2.49996 66.52 2.37996 66.51 1.94996C66.56 1.64996 66.75 1.47996 67.02 1.39996C67.37 1.48996 67.71 1.46996 68 1.20996C68.06 1.20996 68.12 1.21996 68.18 1.22996L68.19 1.23996Z" fill="#CEAC60" class="svg-elem-20"></path>
                        <path d="M22.51 10.0201C22.2 8.89009 22.48 8.58009 23.51 8.67009C24.24 8.73009 25.14 8.97009 25.38 7.84009C26.04 8.68009 25.57 9.20009 24.86 9.65009C24.8 9.67009 24.74 9.70009 24.69 9.72009C24.3 9.74009 23.98 9.94009 23.63 10.0801C23.45 10.1601 23.25 10.2201 23.05 10.2401C22.83 10.2401 22.65 10.1801 22.5 10.0201H22.51Z" fill="#EEDEA5" class="svg-elem-21"></path>
                        <path d="M45.9399 28.94C46.0599 28.38 45.9399 27.76 46.2899 27.25C46.3399 27.22 46.3899 27.19 46.4399 27.15C46.6999 27.01 46.9999 26.95 47.1899 26.71C47.2299 26.67 47.2699 26.62 47.3099 26.58C47.8699 26.49 48.1999 26.83 48.4999 27.23C48.6599 27.99 48.1799 27.91 47.7099 27.83C47.4099 28.27 47.0299 28.62 46.6699 29.01C46.3999 29.22 46.1499 29.36 45.9399 28.94Z" fill="#CFB172" class="svg-elem-22"></path>
                        <path d="M15.99 28.38C16.12 29.24 15.57 29.46 14.88 29.58C14.27 29.69 13.84 29.49 13.54 28.95C13.18 28.28 13.45 27.84 14.03 27.5C14.6 27.97 15.19 28.4 15.99 28.38Z" fill="#F0E2BB" class="svg-elem-23"></path>
                        <path d="M13.6801 44.8399C13.8101 44.8799 13.9301 44.9199 14.0601 44.9599C14.4401 44.9799 14.5701 44.5199 14.9301 44.5099C15.4201 44.4699 15.5301 44.7699 15.4501 45.1599C15.3501 45.5999 15.2701 46.0199 15.5201 46.4399C15.5401 46.5799 15.5201 46.7099 15.4601 46.8399C15.3101 47.0799 15.1801 47.3299 14.8301 47.2899C13.9001 46.7399 13.2501 46.0399 13.6701 44.8499L13.6801 44.8399Z" fill="#EFE0AC" class="svg-elem-24"></path>
                        <path d="M6.18002 6.16991C6.97002 6.45991 6.55002 6.98991 6.33002 7.35991C6.05002 7.83991 5.54002 7.69991 5.12002 7.52991C4.52002 7.29991 4.54002 6.72991 4.63002 6.25991C4.72002 5.75991 5.04002 5.44991 5.60002 5.81991C5.56002 6.32991 5.96002 6.09991 6.18002 6.16991Z" fill="#F0E3B8" class="svg-elem-25"></path>
                        <path d="M3.56006 65.88C4.08006 65.58 4.73006 66.11 5.23006 65.55C5.40006 66.32 4.36006 66.26 4.51006 67.01C5.15006 67.05 5.85006 67.56 6.52006 66.67C6.61006 67.37 5.85006 67.42 5.94006 67.93C4.49006 68 3.93006 67.04 3.56006 65.87V65.88Z" fill="#DEC889" class="svg-elem-26"></path>
                        <path d="M35.9 67.38C35.02 67.54 34.36 67.2 33.85 66.5C33.78 66.33 33.71 66.16 33.63 65.99C33.88 65.5 34.02 64.82 34.84 65.22C34.93 65.53 35.01 65.84 35.1 66.15C35.65 66.37 36.2 66.6 35.89 67.38H35.9Z" fill="#B99551" class="svg-elem-27"></path>
                        <path d="M19.1 48.87C19.41 48.45 20.32 48.25 19.63 47.46C19.62 47.39 19.61 47.33 19.59 47.26C19.9 46.39 20.6 46.59 21.25 46.65C21.29 46.7 21.34 46.75 21.38 46.8C21.19 48.12 20.52 48.91 19.1 48.86V48.87Z" fill="#D9C082" class="svg-elem-28"></path>
                        <path d="M15.99 28.38C14.93 28.98 14.28 28.69 14.03 27.5C15.23 26.59 15.7 27.28 15.99 28.38Z" fill="#D9C189" class="svg-elem-29"></path>
                        <path d="M0.0600278 21.8099C0.430028 21.9999 0.780028 20.3399 1.16003 21.8099C1.29003 22.1599 1.90003 21.9299 1.91003 22.4299C1.96003 23.0599 1.68003 23.3799 1.02003 23.3199C0.0300277 23.2499 -0.0999722 22.6199 0.0600278 21.8199V21.8099Z" fill="#EDDCAA" class="svg-elem-30"></path>
                        <path d="M43.6899 33.22C44.1299 32.94 44.5499 32.63 44.9799 32.36C45.4899 32.05 46.2399 31.98 46.6099 32.79C45.6999 33.35 44.7699 33.8 43.6899 33.21V33.22Z" fill="#DCC68F" class="svg-elem-31"></path>
                        <path d="M7.53004 67.61C7.53004 67.26 7.35004 67.01 7.04004 66.86C7.46004 66.08 8.23004 65.77 8.99004 65.45C9.31004 65.49 9.60004 65.56 9.68004 65.93C9.75004 66.24 9.70004 66.52 9.46004 66.75C9.00004 67.46 8.18004 67.38 7.52004 67.65V67.62L7.53004 67.61Z" fill="#C5A25D" class="svg-elem-32"></path>
                        <path d="M22.93 10.1099C23.11 9.9999 23.28 9.8999 23.46 9.7899C23.92 10.0199 24.35 9.9299 24.76 9.6599L24.88 9.6499C25.72 10.4799 24.62 10.6899 24.37 11.1399C24.01 11.7699 23.57 11.5199 23.19 11.0999C22.73 10.8699 22.67 10.5399 22.94 10.1199L22.93 10.1099Z" fill="#E8D59B" class="svg-elem-33"></path>
                        <path d="M38.97 66.08C38.97 66.66 38.53 66.99 38.12 66.74C37.48 66.36 37.13 66.79 36.67 66.97C36.45 66.86 36.43 66.67 36.49 66.46C36.63 66.09 37.11 65.96 37.16 65.52C37.66 65.55 38.16 65.57 38.66 65.6C38.76 65.76 38.86 65.91 38.97 66.07V66.08Z" fill="#E8D697" class="svg-elem-34"></path>
                        <path d="M39.66 13.3C39.25 13.46 38.81 13.49 38.57 13.13C38.35 12.8 38.38 12.37 38.82 12.11C39.26 11.86 39.6 12.02 39.82 12.39C40.01 12.7 39.99 13.05 39.66 13.3Z" fill="#DBC79B" class="svg-elem-35"></path>
                        <path d="M22.16 45.8401C22.14 46.3601 21.66 46.4901 21.39 46.8001C21.36 46.7601 21.32 46.7301 21.28 46.7001C20.95 46.5401 20.53 46.5001 20.43 46.0401C20.35 45.3801 20.6 44.9601 21.29 44.8601C21.84 44.9501 22.14 45.2801 22.17 45.8401H22.16Z" fill="#CBAB65" class="svg-elem-36"></path>
                        <path d="M2.32001 22.52C2.89001 22.57 2.71001 20.68 3.76001 21.96C3.83001 22.83 3.13001 23.09 2.56001 23.44C2.06001 23.25 2.10001 22.91 2.32001 22.52Z" fill="#E2CC92" class="svg-elem-37"></path>
                        <path d="M9.44004 63.8901C8.81004 63.4701 8.76004 62.6901 8.31004 62.1501C8.29004 62.0101 8.32004 61.8801 8.39004 61.7601C8.47004 61.7001 8.56004 61.6401 8.64004 61.5801C9.72004 61.8401 9.39004 62.9801 9.90004 63.6001C9.85004 63.8601 9.68004 63.9301 9.43004 63.8901H9.44004Z" fill="#B99658" class="svg-elem-38"></path>
                        <path d="M1.91004 17.9C1.70004 17.43 1.87004 17.08 2.22004 16.85C2.63004 16.58 2.99004 16.72 3.15004 17.17C3.26004 17.47 3.46004 17.94 2.91004 17.94C2.59004 17.94 2.18004 18.41 1.91004 17.91V17.9Z" fill="#D6BD87" class="svg-elem-39"></path>
                        <path d="M35.16 63.43C35.75 64 35.26 64.38 34.93 64.79C34.56 64.86 34.19 65.41 33.83 64.77C34.09 64.14 34.26 63.42 35.16 63.43Z" fill="#C5A15D" class="svg-elem-40"></path>
                        <path d="M14.84 47.2799C14.97 47.0899 15.1 46.9 15.22 46.7C15.54 47.26 16.45 47.26 16.53 48.06C16.57 48.27 16.56 48.48 16.55 48.68C16.6 48.76 16.64 48.85 16.67 48.93C15.79 48.67 15.06 48.25 14.83 47.27L14.84 47.2799Z" fill="#D9C186" class="svg-elem-41"></path>
                        <path d="M67.26 1.51C67.01 1.66 66.76 1.81 66.52 1.96C66.39 0.52 67.33 0.16 68.48 0C68.47 0.07 68.46 0.13 68.45 0.2C68.09 0.66 67.87 1.26 67.27 1.51H67.26Z" fill="#D5BA7B" class="svg-elem-42"></path>
                        <path d="M15.87 40.98C16 41.29 16.13 41.59 16.38 42.21C15.42 41.17 15.36 42.78 14.65 42.44C14.52 41.5 15.32 41.35 15.87 40.98Z" fill="#F0E4B2" class="svg-elem-43"></path>
                        <path d="M19.8601 25.44C19.7101 25.09 19.7001 24.81 19.9501 24.7C20.3401 24.54 20.7401 24.65 20.9801 25.03C21.1801 25.35 21.0001 25.6 20.6801 25.71C20.3101 25.83 20.0201 25.67 19.8601 25.44Z" fill="#E6D4AC" class="svg-elem-44"></path>
                        <path d="M22.1599 45.8401C21.9599 45.4301 21.6099 45.1901 21.2299 44.9901C20.9099 44.8501 20.8799 44.6201 20.9999 44.3301C21.2899 44.0901 21.6099 43.8901 21.9899 43.8301C22.4399 44.4701 22.0599 45.1701 22.1599 45.8401Z" fill="#DCC17B" class="svg-elem-45"></path>
                        <path d="M2.32001 22.5199C2.40001 22.8299 2.48001 23.1299 2.56001 23.4299C2.00001 23.9199 1.49001 23.8299 1.01001 23.2999C1.43001 23.1199 1.69001 22.7899 1.90001 22.3999C2.04001 22.4399 2.18001 22.4699 2.31001 22.5099L2.32001 22.5199Z" fill="#D4BD8F" class="svg-elem-46"></path>
                        <path d="M28.7 12.96C28.47 12.61 28.53 12.34 28.93 12.16C29.14 12.07 29.35 11.85 29.55 12.14C29.77 12.47 29.66 12.81 29.44 13.07C29.18 13.37 28.93 13.21 28.7 12.96Z" fill="#D8C18C" class="svg-elem-47"></path>
                        <path d="M37.46 34.7C38.05 34.8 38.94 34.47 38.79 35.63C38.17 35.57 37.39 35.75 37.46 34.7Z" fill="#FDF9E2" class="svg-elem-48"></path>
                        <path d="M69.56 0.71C69.16 1.02 68.72 1.24 68.2 1.24C67.61 0.68 68.35 0.42 68.48 0.03V0C68.98 0.02 69.28 0.35 69.56 0.71Z" fill="#C5A463" class="svg-elem-49"></path>
                        <path d="M7.46004 15.9401C7.27004 15.5001 7.46004 15.2901 7.75004 15.1401C7.99004 15.0101 8.25004 15.0201 8.39004 15.3001C8.54004 15.5901 8.55004 15.8901 8.21004 16.0601C7.91004 16.2101 7.63004 16.1401 7.46004 15.9401Z" fill="#D9C395" class="svg-elem-50"></path>
                        <path d="M21.99 43.84C21.82 44.16 21.55 44.33 21.18 44.33C20.6 44.1 20.86 43.59 20.81 43.19C20.9 43.11 20.99 43.03 21.07 42.96C21.53 43.09 22.13 43.08 21.98 43.84H21.99Z" fill="#C8AA6B" class="svg-elem-51"></path>
                        <path d="M7.53003 67.64C7.91003 66.76 8.87003 67.15 9.47003 66.74C9.04003 67.51 8.51003 68.05 7.53003 67.64Z" fill="#E1C988" class="svg-elem-52"></path>
                        <path d="M68.64 4.15988C68.91 4.10988 69.17 4.12988 69.37 4.33988C69 4.71988 68.65 5.12988 68.03 4.92988C67.84 5.22988 67.64 5.45988 67.4 4.96988C67.44 4.89988 67.49 4.83988 67.57 4.80988C67.81 4.40988 68.11 4.08988 68.64 4.15988Z" fill="#CAA75D" class="svg-elem-53"></path>
                        <path d="M67.4 4.97994C67.62 5.13994 67.83 5.01994 68.03 4.93994C68.42 5.64994 67.8 5.54994 67.45 5.66994C67.23 5.89994 67.02 6.12994 66.8 6.36994C66.8 5.81994 66.85 5.29994 67.4 4.98994V4.97994Z" fill="#EFE3B7" class="svg-elem-54"></path>
                        <path d="M33.83 64.77C34.2 64.77 34.56 64.78 34.93 64.79C34.9 64.93 34.87 65.08 34.85 65.22C34.26 65.18 34.06 65.76 33.64 65.99C33.61 65.57 33.58 65.14 33.84 64.77H33.83Z" fill="#DBBF73" class="svg-elem-55"></path>
                        <path d="M9.68003 65.93C9.48003 65.81 9.27003 65.69 9.07003 65.57C8.86003 65.38 8.84003 65.23 9.16003 65.15C9.50003 64.94 9.83003 64.72 10.17 64.51C10.31 65.08 9.64003 65.38 9.68003 65.93Z" fill="#D5B773" class="svg-elem-56"></path>
                        <path d="M9.44001 63.8901C9.60001 63.7901 9.75001 63.7001 9.91001 63.6001C10.09 63.8801 10.35 64.1301 10.17 64.5101C9.89001 64.4801 9.60001 64.4601 9.33001 64.4001C9.21001 64.3701 9.12001 64.2401 9.01001 64.1601C9.15001 64.0701 9.30001 63.9801 9.44001 63.8901Z" fill="#D5B773" class="svg-elem-57"></path>
                        <path d="M22.93 10.11C23.01 10.44 23.09 10.76 23.18 11.09C22.66 11.04 22.25 10.82 22.04 10.31C22.2 10.21 22.36 10.12 22.51 10.02C22.65 10.05 22.79 10.08 22.92 10.11H22.93Z" fill="#DDC58A" class="svg-elem-58"></path>
                        <path d="M46.29 27.2501C46.13 26.9701 45.9 26.7101 46.08 26.3501C46.49 26.4301 46.9 26.5101 47.31 26.5901C47.32 26.6401 47.33 26.6901 47.33 26.7401C47.09 27.1101 46.73 27.2501 46.31 27.2801L46.29 27.2501Z" fill="#D9C186" class="svg-elem-59"></path>
                        <path d="M23.27 6.66992C22.71 6.90992 22.52 7.72992 21.76 7.66992C22.01 6.95992 22.55 6.66992 23.27 6.66992Z" fill="#D3B879" class="svg-elem-60"></path>
                        <path d="M42.32 31.6001C42.15 31.8501 42.26 32.0801 42.37 32.3101C41.62 32.0401 41.67 31.4501 41.8 30.8401C41.87 30.8301 41.94 30.8201 42 30.8101C42.29 30.8501 42.64 30.8601 42.75 31.1901C42.85 31.5001 42.63 31.6301 42.33 31.6001H42.32Z" fill="#E1CB8D" class="svg-elem-61"></path>
                        <path d="M68.6399 4.1599C68.2799 4.3799 67.9299 4.5999 67.5699 4.8099C67.5699 4.5799 67.5699 4.3499 67.5699 4.1199C67.7599 3.8799 67.9499 3.6399 68.1499 3.3999C68.3099 3.6499 68.4699 3.8999 68.6399 4.1599Z" fill="#D8BC74" class="svg-elem-62"></path>
                        <path d="M27.04 20.4599C26.94 20.2799 26.89 20.0899 27.08 19.9399C27.31 19.7599 27.56 19.7699 27.67 20.0399C27.72 20.1799 27.65 20.4399 27.54 20.5499C27.39 20.6999 27.18 20.6199 27.04 20.4499V20.4599Z" fill="#D5BF8F" class="svg-elem-63"></path>
                        <path d="M37.5699 68.43C37.7699 67.86 38.0299 67.56 38.5299 68.2C38.3799 68.99 37.8799 68.3 37.5699 68.43Z" fill="#F9F4D7" class="svg-elem-64"></path>
                        <path d="M13.91 4.29C13.81 4.09 13.82 3.9 14.04 3.8C14.24 3.71 14.45 3.77 14.52 3.99C14.55 4.11 14.5 4.3 14.41 4.39C14.24 4.56 14.05 4.47 13.92 4.3L13.91 4.29Z" fill="#F4ECCB" class="svg-elem-65"></path>
                        <path d="M42.6 29.29C42.65 29.37 42.7 29.46 42.76 29.54C42.67 29.94 42.66 30.36 42.37 30.69C42.21 30.84 42.03 30.91 41.81 30.85H41.8C41.73 30.4 41.9 30 42.1 29.62C42.17 29.36 42.34 29.26 42.6 29.3V29.29Z" fill="#E2CB90" class="svg-elem-66"></path>
                        <path d="M42.6 29.29C42.43 29.4 42.26 29.5 42.1 29.61C42.14 29.11 42.4 28.75 42.78 28.46C42.98 28.79 42.92 29.07 42.6 29.29Z" fill="#EFE3BF" class="svg-elem-67"></path>
                        <path d="M66.52 1.95996C66.6 2.39996 65.86 2.62996 66.22 3.14996C65.49 2.68996 65.51 2.60996 66.52 1.95996Z" fill="#D8BC74" class="svg-elem-68"></path>
                        <path d="M21.75 7.69995C21.74 8.11995 21.95 8.57995 21.49 8.88995C21.21 8.40995 21.3 8.00995 21.75 7.69995Z" fill="#D3B879" class="svg-elem-69"></path>
                        <path d="M21.73 50.8099C21.58 51.2899 21.29 51.5999 20.74 51.7399C20.76 51.1399 21.29 51.1399 21.5 50.8599C21.57 50.8099 21.64 50.7899 21.73 50.8099Z" fill="#D2B679" class="svg-elem-70"></path>
                        <path d="M6.18003 6.17007C5.94003 6.31007 5.69003 6.62007 5.41003 6.39007C5.13003 6.16007 5.44003 5.98007 5.60003 5.82007C5.79003 5.94007 5.99003 6.05007 6.18003 6.17007Z" fill="#CCB179" class="svg-elem-71"></path>
                        <path d="M40.06 34.81C39.85 34.46 39.61 34.1 39.99 33.71C40.32 34.06 40.33 34.42 40.06 34.81Z" fill="#F1E7C2" class="svg-elem-72"></path>
                        <path d="M68.65 8.17988C68.68 7.35988 69.15 7.69988 69.54 7.84988C69.29 8.07988 69.02 8.27988 68.65 8.17988Z" fill="#DCC27D" class="svg-elem-73"></path>
                        <path d="M37.9 63.2301C37.69 63.3901 37.36 63.7301 37.29 63.6901C36.91 63.4401 37.45 63.1501 37.33 62.8501C37.61 62.8501 37.75 63.0401 37.9 63.2301Z" fill="#D3B87A" class="svg-elem-74"></path>
                        <path d="M9.15999 65.16C9.12999 65.3 9.09999 65.44 9.06999 65.58C8.49999 66.18 7.80999 66.58 7.03999 66.86C6.53999 66.68 7.39999 65.62 6.34999 65.78C6.24999 64.9 7.19999 65.23 7.48999 64.8C7.93999 65.44 8.63999 64.87 9.15999 65.15V65.16Z" fill="#DBC281" class="svg-elem-75"></path>
                        <path d="M7.75998 64.6101C7.11998 64.2101 6.38998 64.3401 5.70998 64.3401C4.98998 64.3401 5.42998 63.9101 5.36998 63.6701C6.02998 63.4101 6.65998 63.8701 7.34998 63.7101C7.75998 63.6201 8.15998 64.0501 7.75998 64.6101Z" fill="#DCC17E" class="svg-elem-76"></path>
                        <path d="M4.79004 62.7601C5.08004 62.0801 5.58004 62.1401 5.91004 61.8301C6.10004 62.7901 5.48004 62.6701 4.79004 62.7601Z" fill="#AA8750" class="svg-elem-77"></path>
                        <path d="M8.38998 61.77C8.35998 61.9 8.33998 62.03 8.30998 62.15C8.03998 62.27 7.76998 62.41 7.47998 62.15C7.67998 61.77 8.11998 61.97 8.38998 61.76V61.77Z" fill="#9E7B47" class="svg-elem-78"></path>
                        <path d="M36.71 66.51C36.7 66.67 36.69 66.83 36.68 66.98C36.62 67.5 36.19 67.31 35.9 67.38C35.87 66.82 35.29 66.61 35.11 66.15C35.44 65.92 35.77 65.7 36.11 65.47C36.35 65.66 36.36 66.04 36.67 66.17C36.75 66.28 36.77 66.39 36.71 66.51Z" fill="#E1CA87" class="svg-elem-79"></path>
                        <path d="M36.7101 66.51C36.6501 66.42 36.5901 66.33 36.5301 66.24C36.3401 66.04 36.3701 65.9 36.6201 65.8C36.8001 65.72 36.9801 65.63 37.1601 65.55C37.4601 66.09 37.0601 66.29 36.7001 66.52L36.7101 66.51Z" fill="#F4ECCC" class="svg-elem-80"></path>
                        <path d="M36.63 65.79C36.6 65.94 36.57 66.08 36.54 66.23C35.62 66.42 36.15 65.78 36.11 65.47C36.29 65.58 36.46 65.68 36.64 65.79H36.63Z" fill="#BB954D" class="svg-elem-81"></path>
                        <path d="M15.51 46.4999C15.03 46.3299 14.41 46.2499 15.01 45.5099C15.2 45.2699 15.63 44.8999 14.98 44.6299C14.75 44.4499 15.03 44.2199 14.93 44.0199C15.12 43.4599 15.51 43.0599 15.96 42.6899C16.05 42.7099 16.1 42.7599 16.1 42.8199C16.1 42.8799 16.1 42.9199 16.07 42.9299C16.23 43.1899 16.38 43.4599 16.54 43.7199C16.37 44.1899 16.81 44.3899 16.98 44.7099C17.28 45.2299 17.74 44.8899 18.13 44.9099C18.26 44.9099 18.39 44.9299 18.51 44.9799C18.76 45.2299 18.8 45.5599 18.85 45.8799C18.88 46.1499 18.89 46.4099 18.78 46.6699C18.69 46.7699 18.59 46.8499 18.47 46.9099C17.95 47.1599 17.3 46.9599 16.82 47.3699C16.27 47.5299 15.95 47.3199 16.01 46.7499C16.08 46.1299 15.59 46.7499 15.51 46.4899V46.4999Z" fill="#D0B168" class="svg-elem-82"></path>
                        <path d="M20.8099 43.1799C21.4499 43.3899 20.8299 44.0099 21.1799 44.3199C21.1899 44.5399 21.2099 44.7699 21.2199 44.9899C20.7099 45.2099 20.6699 45.6899 20.5799 46.1499C20.0599 46.5299 19.5399 46.7099 19.0299 46.1399C18.7999 45.6099 19.8199 45.3199 19.2999 44.7299C19.6599 44.4199 19.6399 44.2499 19.1799 43.6599C19.1999 43.5899 19.2099 43.5299 19.2299 43.4599C19.8199 43.7299 20.3199 43.5099 20.7999 43.1799H20.8099Z" fill="#BE994F" class="svg-elem-83"></path>
                        <path d="M17.2 44.75C17.09 43.66 18.13 44.4 18.44 43.98C18.68 43.98 18.84 44.11 18.99 44.28C19.12 44.46 19.17 44.67 19.16 44.89C18.99 45.23 18.73 45.2 18.45 45.04L18.37 45.01C18.01 45.04 17.66 45.25 17.28 45.07C17.18 44.98 17.16 44.86 17.2 44.74V44.75Z" fill="#D3B56C" class="svg-elem-84"></path>
                        <path d="M16.07 42.93C16.02 42.86 15.98 42.78 15.96 42.69C16.44 42.38 16.93 42.07 17.41 41.76C17.53 41.93 17.65 42.09 17.77 42.26C17.88 42.28 17.93 42.33 17.92 42.39C17.91 42.44 17.89 42.48 17.85 42.5L16.06 42.92L16.07 42.93Z" fill="#F8F1CF" class="svg-elem-85"></path>
                        <path d="M17.2 44.75C17.23 44.84 17.26 44.93 17.31 45.01C17.11 45.21 16.95 45.22 16.87 44.9C16.79 44.5 15.73 44.38 16.53 43.72L17.2 44.74V44.75Z" fill="#F3E8BF" class="svg-elem-86"></path>
                        <path d="M18.55 43.51C18.63 43.29 18.69 43.05 18.81 42.85C18.94 42.63 19.12 42.22 19.41 42.53C19.63 42.77 19.28 43.03 19.06 43.21C18.98 43.46 18.8 43.54 18.55 43.5V43.51Z" fill="#DCC177" class="svg-elem-87"></path>
                        <path d="M18.55 43.51C18.72 43.41 18.89 43.32 19.06 43.22C19.12 43.3 19.18 43.38 19.25 43.46H19.27C19.05 43.75 19.36 44.31 18.79 44.42C18.68 44.27 18.57 44.11 18.46 43.96C18.49 43.81 18.53 43.65 18.56 43.5L18.55 43.51Z" fill="#EBDAA0" class="svg-elem-88"></path>
                        <path d="M17.85 42.5101C17.83 42.4301 17.8 42.3401 17.76 42.2601C18.09 42.2101 18.43 42.1601 18.81 42.1001C18.59 42.5701 18.26 42.6401 17.85 42.5101Z" fill="#D4B361" class="svg-elem-89"></path>
                        <path d="M41.81 30.8499C41.98 30.7399 42.15 30.6399 42.32 30.5299C42.58 30.3599 42.71 30.0199 43.05 29.9599C43.25 29.9299 43.44 29.9799 43.6 30.0999C43.69 30.1999 43.74 30.3199 43.75 30.4499C43.57 30.9099 43.31 31.3599 43.54 31.8899C43.54 32.0199 43.54 32.1499 43.54 32.2799C43.2 31.9199 42.59 32.0699 42.3 31.6099C42.81 30.8999 41.7 31.2799 41.79 30.8599L41.81 30.8499Z" fill="#F0E6BF" class="svg-elem-90"></path>
                        <path d="M43.55 31.89C43.05 31.35 43.34 30.87 43.64 30.38C43.96 29.92 44.42 30.2 44.82 30.17C44.97 30.16 45.1 30.1901 45.23 30.2701C45.45 30.4801 45.59 30.7201 45.47 31.0401C44.84 31.3401 43.6 30.27 43.55 31.88V31.89Z" fill="#E7D49B" class="svg-elem-91"></path>
                        <path d="M47.09 29.6301C47.27 29.4801 47.45 29.3201 47.75 29.0701C47.97 29.8701 47.43 30.3601 47.23 30.9401C46.86 30.8201 46.52 31.7201 46.14 30.9701C46.14 30.9101 46.14 30.8401 46.14 30.7801C46.33 30.2901 46.69 29.9401 47.09 29.6301Z" fill="#F3E8BD" class="svg-elem-92"></path>
                        <path d="M47.39 31.2C47.74 31.5 48.53 30.01 48.6 31.49C48.22 31.67 47.95 32.19 47.48 32C47.21 31.89 47.28 31.49 47.39 31.2Z" fill="#BE9C62" class="svg-elem-93"></path>
                        <path d="M45.48 31.04C45.32 30.78 45.16 30.51 45 30.25C45.16 29.92 45.44 29.66 45.78 29.82C46.22 30.03 46.22 30.51 46.16 30.95V30.97C45.95 31.1 45.73 31.17 45.5 31.05L45.48 31.04Z" fill="#F1E5B2" class="svg-elem-94"></path>
                        <path d="M46.1501 30.9501C45.7801 30.6901 45.9601 29.5201 44.9901 30.2501C44.8901 30.2301 44.8301 30.1801 44.8201 30.1101C44.8101 30.0401 44.8201 29.9901 44.8301 29.9801C45.4601 29.9201 45.2201 28.9301 45.9301 28.9401C46.1701 29.0801 46.3901 28.9801 46.6001 28.8701C46.7201 28.8701 46.7901 28.9101 46.8001 28.9801C46.8001 29.0501 46.8001 29.1001 46.7701 29.1201C46.8801 29.2901 46.9801 29.4601 47.0901 29.6201C47.2701 30.4101 46.4001 30.4601 46.1501 30.9401V30.9501Z" fill="#E7D49B" class="svg-elem-95"></path>
                        <path d="M46.77 29.1201C46.72 29.0401 46.66 28.9501 46.61 28.8701C46.84 28.3801 47.23 28.0601 47.71 27.8301C47.63 28.4301 47.28 28.8301 46.77 29.1201Z" fill="#EFE3B7" class="svg-elem-96"></path>
                        <path d="M14.9301 44.02C15.4701 44.18 14.8401 44.44 14.9801 44.63C14.7201 44.86 14.4901 45.18 14.0601 44.96C14.2201 44.52 14.2301 43.95 14.9301 44.02Z" fill="#C49F56" class="svg-elem-97"></path>
                        <path d="M44.84 29.98C44.89 30.07 44.95 30.16 45 30.25C44.57 30.56 44.09 30.29 43.65 30.37C43.6 30.29 43.55 30.21 43.5 30.13C43.25 29.76 43.37 29.4 43.52 29.04C43.87 29.04 44.13 28.89 44.28 28.56C44.39 28.55 44.46 28.57 44.48 28.64C44.5 28.71 44.5 28.76 44.48 28.78C44.16 29.31 43.92 29.82 44.85 29.97L44.84 29.98Z" fill="#EEE1B6" class="svg-elem-98"></path>
                        <path d="M44.47 28.79C44.4 28.72 44.33 28.65 44.27 28.57C44.31 28.54 44.35 28.51 44.39 28.48C44.71 28.3 44.75 27.69 45.29 27.87C45.39 27.9 45.52 28.1 45.5 28.19C45.39 28.78 44.92 28.77 44.47 28.79Z" fill="#CBAC71" class="svg-elem-99"></path>
                        <path d="M43.1 30.07C42.89 30.31 42.83 30.79 42.33 30.53C42.26 30.1 42.4 29.77 42.77 29.54C42.82 29.62 42.88 29.71 42.93 29.79C43.02 29.82 43.08 29.87 43.1 29.94C43.12 30.01 43.12 30.05 43.1 30.07Z" fill="#D6BC7D" class="svg-elem-100"></path>
                        <path d="M43.1001 30.07C43.0401 29.98 42.9901 29.8901 42.9301 29.7901C43.1301 29.5401 43.3301 29.3 43.5301 29.05C43.5301 29.41 43.5201 29.77 43.5101 30.14C43.3801 30.12 43.2401 30.09 43.1101 30.07H43.1001Z" fill="#E2CB90" class="svg-elem-101"></path>
                        <path d="M69.17 6.68002C69.25 6.63002 69.34 6.57002 69.42 6.52002C69.6 6.55002 69.84 6.52002 69.94 6.62002C70.12 6.81002 69.87 6.91002 69.75 7.03002C69.47 7.05002 69.31 6.89002 69.17 6.68002Z" fill="#CFAE64" class="svg-elem-102"></path>
                        <path d="M1.91003 22.4199C1.69003 22.1799 0.950035 22.5699 1.16003 21.7999C1.70003 21.9099 1.96003 21.3999 2.46003 21.1899C2.59003 21.7999 2.27003 22.1199 1.91003 22.4199Z" fill="#D8C089" class="svg-elem-103"></path>
                        <path d="M69.01 2.49988C69.3 2.33988 69.58 2.18988 70.15 1.87988C69.8 2.63988 69.9 3.31988 69.26 3.52988C68.74 3.69988 68.77 3.05988 68.52 2.80988C68.63 2.60988 68.84 2.58988 69.01 2.50988V2.49988Z" fill="#CEAC60" class="svg-elem-104"></path>
                        <path d="M69.01 2.50002C69.03 2.90002 68.7 2.74002 68.52 2.80002C68.38 2.77002 68.24 2.75002 68.09 2.72002C68.09 2.16002 68.53 2.34002 68.83 2.27002C68.89 2.35002 68.95 2.42002 69.01 2.49002V2.50002Z" fill="#C29B48" class="svg-elem-105"></path>
                        <path d="M69.17 6.68006C68.87 6.87006 68.57 7.06006 68.15 7.33006C68.38 6.73006 68.67 6.53006 69.17 6.68006Z" fill="#DCC27D" class="svg-elem-106"></path>
                        <path d="M16.89 47.0799C17.31 46.4399 17.96 46.9399 18.47 46.7699C18.48 46.8299 18.49 46.8799 18.5 46.9399C18.5 47.1799 18.44 47.3999 18.29 47.5999C18.07 47.6099 17.84 47.6299 17.62 47.6399C17.42 47.7399 17.24 47.7199 17.05 47.6099C16.9 47.4599 16.82 47.2899 16.88 47.0799H16.89Z" fill="#E6D08D" class="svg-elem-107"></path>
                        <path d="M17.17 47.5401C17.32 47.5801 17.47 47.6101 17.62 47.6501C17.53 48.2601 16.8 48.2301 16.56 48.6901C16.44 48.5401 16.33 48.4001 16.21 48.2501C16.36 47.7801 16.67 47.5301 17.17 47.5401Z" fill="#BF9A50" class="svg-elem-108"></path>
                        <path d="M18.47 46.78C18.56 46.73 18.64 46.67 18.73 46.62C19.63 46.28 19.42 47.09 19.63 47.48V47.46C19.41 47.59 19.2 47.71 18.94 47.58C18.6 47.42 18.43 47.16 18.48 46.77L18.47 46.78Z" fill="#DCC587" class="svg-elem-109"></path>
                        <path d="M18.47 46.77C18.62 47.04 18.78 47.31 18.93 47.58C18.72 47.59 18.5 47.6 18.29 47.61C18.09 47.28 18.13 46.99 18.47 46.77Z" fill="#D2B266" class="svg-elem-110"></path>
                        <path d="M68.48 0.0300293C68.46 0.450029 68.06 0.790029 68.2 1.24003C67.74 1.37003 68.08 2.14003 67.5 2.12003C67.41 2.12003 67.34 1.72003 67.26 1.51003C67.52 0.900029 67.76 0.270029 68.48 0.0300293Z" fill="#D8BC74" class="svg-elem-111"></path>
                        <path d="M24.75 9.65994C24.44 10.8899 23.97 10.5799 23.45 9.78994C23.9 9.95994 24.23 8.86994 24.75 9.65994Z" fill="#D4B56D" class="svg-elem-112"></path>
                        <path d="M46.3101 27.28C46.6501 27.1 46.9901 26.92 47.3301 26.74C47.4501 27.79 46.7201 27.24 46.3101 27.28Z" fill="#B08E55" class="svg-elem-113"></path>
                        <path d="M17.17 47.54C16.85 47.78 16.53 48.01 16.21 48.25C16.33 47.45 15.21 47.44 15.23 46.71C15.32 46.64 15.42 46.5799 15.51 46.5099C16.13 46.1999 16.16 46.2 16.2 46.74C16.24 47.28 16.52 47.23 16.88 47.09C16.97 47.24 17.07 47.4 17.16 47.55L17.17 47.54Z" fill="#EBD99D" class="svg-elem-114"></path>
                        <path d="M19.63 47.4699C19.13 47.3899 19.34 46.5699 18.73 46.6099C18.6 46.3999 18.52 46.1799 18.68 45.9499C18.82 45.9199 18.95 45.9499 19.08 46.0299C19.55 46.4799 20.1 45.9399 20.59 46.1499C20.82 46.3399 21.05 46.5199 21.28 46.6999C20.8 47.0999 19.91 46.6199 19.64 47.4699H19.63Z" fill="#BA954D" class="svg-elem-115"></path>
                        <path d="M19.07 46.03C18.94 46 18.81 45.98 18.67 45.95C18.6 45.65 18.52 45.34 18.45 45.04C18.66 45.01 18.88 44.98 19.09 44.95C19.13 44.81 19.22 44.77 19.36 44.83C20.13 45.44 19.31 45.67 19.07 46.03Z" fill="#B08D4D" class="svg-elem-116"></path>
                        <path d="M16.88 44.8999C17.03 44.9399 17.17 44.9699 17.32 45.0099C17.67 45.0099 18.02 45.0099 18.38 45.0099C17.86 45.2299 17.31 45.9899 16.89 44.8999H16.88Z" fill="#E9D8A1" class="svg-elem-117"></path>
                        <path d="M19.37 44.83C19.28 44.86 19.19 44.9 19.1 44.95C18.99 44.78 18.88 44.6 18.78 44.43C18.96 44.12 18.78 43.62 19.26 43.47C19.4 43.92 20.67 44.27 19.37 44.83Z" fill="#DCC177" class="svg-elem-118"></path>
                    </g>
                    <defs>
                        <clipPath id="clip0_328_99169">
                            <rect width="71.25" height="68.58" fill="white" class="svg-elem-119"></rect>
                        </clipPath>
                    </defs>
                </svg>
            </div>
        </div>

    </div>

    {{-- ── Part 2: Two columns ── --}}
    <div class="relative w-full overflow-hidden
                px-4 pt-12 pb-16
                sm:px-6 sm:pt-14 sm:pb-20
                md:px-10 md:pt-16 md:pb-24
                lg:px-16 lg:pt-20 lg:pb-28
                xl:px-24 xl:pt-24 xl:pb-32">

        {{-- Background text --}}
        <div class="absolute inset-0 flex flex-col justify-start pt-4 pl-2 select-none pointer-events-none overflow-hidden mt-16" style="z-index:0;">
            @foreach($bgTextLines as $line)
            <span class="scroll-move" data-axis="Y" style="
font-size: clamp(32px, 6vw, 120px);                         font-weight:700;
                         color:rgba(255,255,255,0.04);
                         white-space:nowrap;
                         line-height:1.1;">
                {{ $line }}
            </span>
            @endforeach
        </div>

        {{-- Grid --}}
        <div id="quality-grid" class="relative z-10 flex flex-col md:flex-row w-full">

            {{-- Animated border line --}}
            <div class="quality-border-line" style="
                position:absolute; top:0; left:0;
                height:1px; width:0%;
                background:rgba(255,255,255,0.25);
                z-index:20;"></div>


            {{-- Col 1 --}}
            <div class="quality-col w-full md:w-1/2
            md:border-r md:border-white/10 p-10"
                style="position:relative; overflow:hidden; display:flex; flex-direction:column;">

                <div style="padding:2.5rem 2rem; min-height:180px; position:relative; z-index:2; flex-shrink:0;">
                    <p class="text-white text-sm leading-relaxed opacity-80"
                        style="line-height:1.9; font-weight:300;">

                        {!! $expertise->body_2 ?? 'We deliver exceptional construction using first-rate materials.' !!}
                    </p>
                </div>

                <div class="quality-img-wrap"
                    style="overflow:hidden; flex-shrink:0;
               width:60%; margin:0 auto; height:550px;
               transition: height 0.75s cubic-bezier(0.76,0,0.24,1),
                           width 0.75s cubic-bezier(0.76,0,0.24,1);">
                    <img src="{{ $expertiseImages[0] ?? asset('assets/images/q1.jpg') }}"
                        class="quality-img w-full  object-cover"
                        style="transform:scale(1.04);
                   transition:transform 0.75s cubic-bezier(0.25,0.46,0.45,0.94);" />
                </div>
            </div>

            {{-- Col 2 --}}
            <div class="quality-col w-full md:w-1/2
            border-t border-white/10 md:border-t-0 p-10"
                style="position:relative; overflow:hidden; display:flex; flex-direction:column;">

                <div style="padding:2.5rem 2rem; min-height:180px; position:relative; z-index:2; flex-shrink:0;">
                    <p class="text-white text-sm leading-relaxed opacity-80"
                        style="line-height:1.9; font-weight:300;">
                        {{-- ✅ body_2 --}}
                        {!! $expertise->body_2 ?? 'We guarantee on-schedule completion, respecting your timelines.' !!}
                    </p>
                </div>

                <div class="quality-img-wrap"
                    style="overflow:hidden; flex-shrink:0;
               width:60%; margin:0 auto; height:550px;
               transition: height 0.75s cubic-bezier(0.76,0,0.24,1),
                           width 0.75s cubic-bezier(0.76,0,0.24,1);">
                    <img src="{{ $expertiseImages[1] ?? asset('assets/images/q2.jpg') }}"
                        class="quality-img w-full h-full object-cover"
                        style="transform:scale(1.04);
                   transition:transform 0.75s cubic-bezier(0.25,0.46,0.45,0.94);" />
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
            style="font-size:clamp(32px,5vw,64px); font-weight:300;">

            The stories of
            <em style="font-family:'Migra',serif; font-style:italic; font-weight:300;">
                satisfaction
            </em>

        </h2>

        {{-- Testimonial Row --}}
        <div id="testimonialWrapper" style="overflow: hidden; position: relative;">

            <div id="testimonialCard" class="flex flex-col md:flex-row items-start gap-10 mb-16 relative mt-6">

                {{-- Left: Avatar + Name --}}
                <div class="w-full md:w-1/4 flex flex-col gap-3 flex-shrink-0">
                    <div class="rounded-full overflow-hidden border border-gray-200" style="width:128px; height:128px;">
                        <img id="testimonialAvatar"
                            src="{{ $storiesItems->first()->img_path ?? asset('assets/images/4.jpeg') }}"
                            alt="avatar" class="w-full h-full object-cover transition-opacity duration-500"
                            onerror="this.src=''; this.parentElement.style.background='#d6cfc5';" />
                    </div>
                    <div>
                        <p id="testimonialName" class="font-medium text-gray-900 text-lg transition-opacity duration-500"
                            style=" font-weight:500;">
                            {{ $storiesItems->first()->title ?? 'Md. Mamun Molla' }}
                        </p>
                        <p id="testimonialRole" class="text-gray-600 text-sm mt-0.5 transition-opacity duration-500"
                            style="font-weight:300;">
                            {{ $storiesItems->first()->name ?? 'Professor' }}
                        </p>
                    </div>
                </div>

                {{-- ✅ Right: Quote — right edge পর্যন্ত যাবে --}}
                <div class="flex items-start gap-4 pl-32">

                    <!-- SVG -->
                    <div class="flex-shrink-0">
                        <svg width="59" height="44" viewBox="0 0 59 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M13.2977 17.4125C12.6473 17.4125 12.0232 17.5117 11.4019 17.6021C11.6032 16.9254 11.8102 16.2371 12.1427 15.6187C12.4752 14.7204 12.9944 13.9417 13.5107 13.1571C13.9423 12.3083 14.7036 11.7337 15.2636 11.0075C15.8498 10.3017 16.649 9.83208 17.2819 9.24583C17.9032 8.63333 18.7169 8.32708 19.3644 7.89542C20.0411 7.5075 20.6302 7.07875 21.2602 6.87458L22.8323 6.22708L24.2148 5.6525L22.8002 0L21.059 0.419999C20.5019 0.559999 19.8223 0.723332 19.0494 0.918749C18.259 1.06458 17.4161 1.46417 16.4769 1.82875C15.5494 2.24292 14.4761 2.52292 13.4786 3.18792C12.4752 3.82375 11.3173 4.35458 10.2965 5.20625C9.30775 6.08417 8.11483 6.84542 7.234 7.9625C6.2715 9.00667 5.32066 10.1033 4.58275 11.3517C3.72816 12.5417 3.14775 13.8483 2.53525 15.1404C1.98108 16.4325 1.53483 17.7537 1.17025 19.0371C0.478996 21.6096 0.169829 24.0538 0.0502462 26.145C-0.0489205 28.2392 0.00941282 29.9804 0.131913 31.2404C0.175663 31.8354 0.25733 32.4129 0.315663 32.8125L0.388579 33.3025L0.464413 33.285C0.983174 35.7083 2.17738 37.9351 3.90889 39.708C5.6404 41.4809 7.83845 42.7274 10.2488 43.3032C12.6591 43.8791 15.1832 43.7608 17.5291 42.962C19.875 42.1632 21.9468 40.7166 23.5049 38.7896C25.063 36.8625 26.0437 34.5337 26.3335 32.0725C26.6234 29.6114 26.2105 27.1185 25.1427 24.8821C24.0749 22.6458 22.3958 20.7575 20.2996 19.4356C18.2035 18.1138 15.7759 17.4123 13.2977 17.4125ZM45.3811 17.4125C44.7307 17.4125 44.1065 17.5117 43.4852 17.6021C43.6865 16.9254 43.8936 16.2371 44.2261 15.6187C44.5586 14.7204 45.0777 13.9417 45.594 13.1571C46.0257 12.3083 46.7869 11.7337 47.3469 11.0075C47.9332 10.3017 48.7323 9.83208 49.3652 9.24583C49.9865 8.63333 50.8002 8.32708 51.4477 7.89542C52.1244 7.5075 52.7136 7.07875 53.3436 6.87458L54.9157 6.22708L56.2982 5.6525L54.8836 0L53.1423 0.419999C52.5852 0.559999 51.9057 0.723332 51.1327 0.918749C50.3423 1.06458 49.4994 1.46417 48.5602 1.82875C47.6357 2.24583 46.5594 2.52292 45.5619 3.19083C44.5586 3.82667 43.4007 4.3575 42.3798 5.20917C41.3911 6.08708 40.1982 6.84833 39.3173 7.9625C38.3548 9.00667 37.404 10.1033 36.6661 11.3517C35.8115 12.5417 35.2311 13.8483 34.6186 15.1404C34.0644 16.4325 33.6182 17.7537 33.2536 19.0371C32.5623 21.6096 32.2532 24.0538 32.1336 26.145C32.0344 28.2392 32.0927 29.9804 32.2152 31.2404C32.259 31.8354 32.3407 32.4129 32.399 32.8125L32.4719 33.3025L32.5477 33.285C33.0665 35.7083 34.2607 37.9351 35.9922 39.708C37.7237 41.4809 39.9218 42.7274 42.3321 43.3032C44.7424 43.8791 47.2665 43.7608 49.6124 42.962C51.9583 42.1632 54.0302 40.7166 55.5883 38.7896C57.1464 36.8625 58.127 34.5337 58.4169 32.0725C58.7067 29.6114 58.2938 27.1185 57.226 24.8821C56.1582 22.6458 54.4791 20.7575 52.383 19.4356C50.2868 18.1138 47.8592 17.4123 45.3811 17.4125Z" fill="#152018"></path>
                        </svg>
                    </div>

                    <!-- TEXT -->
                    <div class="flex-1 min-w-0">

                        <p id="testimonialText"
                            class="text-gray-700 leading-relaxed transition-opacity duration-500"
                            style="font-size:clamp(14px,1.3vw,17px); font-weight:300; line-height:1.95;">
                            {!! $storiesItems->first()->body ?? '' !!}
                        </p>

                        <!-- ARROWS -->
                        <div class="flex gap-3 justify-end mt-16    ">
                            <button onclick="changeTestimonial(-1); resetAutoPlay()" aria-label="Previous"
                                class="rounded-full border border-gray-400 flex items-center justify-center hover:bg-gray-900 hover:border-gray-900 group"
                                style="width:44px; height:44px;">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                    <path d="M10 3L5 8L10 13" stroke="#555" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" class="group-hover:stroke-white" />
                                </svg>
                            </button>

                            <button onclick="changeTestimonial(1); resetAutoPlay()" aria-label="Next"
                                class="rounded-full border border-gray-400 flex items-center justify-center hover:bg-gray-900 hover:border-gray-900 group"
                                style="width:44px; height:44px;">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                    <path d="M6 3L11 8L6 13" stroke="#555" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" class="group-hover:stroke-white" />
                                </svg>
                            </button>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>

    </div>

    {{-- Bottom Images --}}
    <div class="relative container flex items-end mt-32" style="height:clamp(360px,48vw,580px);">

        {{-- Stone: scroll করে উপরে যাবে --}}
        <div class="scroll-move absolute pointer-events-none"
            data-axis="Y"
            style="left:0; top:0; z-index:3;">
            <img src="/assets/images/overview-stone.png" alt=""
                style="width:clamp(120px,7vw,160px); opacity:0.8;"
                onerror="this.style.display='none'" />
        </div>
        <div class=" absolute pointer-events-none"

            style="left:0; top:-60px; z-index:-3;">
            <img src="/assets/images/reviewstonebg.png" alt=""
                style="width:clamp(120px,7vw,160px); opacity:0.8;"
                onerror="this.style.display='none'" />
        </div>

        {{-- Left image + text --}}
        <div class="w-1/2 h-full flex flex-col pl-6 lg:pl-14">
            <div class="flex-1 overflow-hidden" style="z-index: -10;">
                <img src="{{ $storiesSection->img_path ?? asset('assets/images/test1.avif') }}"
                    alt="Interior"
                    class="w-full h-full object-cover"
                    onerror="this.parentElement.style.background='#c8c0b8'; this.style.display='none';" />
            </div>
            <p class="text-gray-700 font-light leading-relaxed text-sm py-6 pr-8"
                style="font-weight:300; line-height:1.9; max-width:520px;">
                {!! $storiesSection->body ?? 'Bhaiya Housing is devoted to designing inspiring residential and commercial spaces that transcend expectations. With a focus on modern aesthetics, impeccable craftsmanship, and an unwavering commitment to integrity, we create environments that harmoniously balance sophistication and purpose, delivering timeless value.' !!}
            </p>
        </div>

        {{-- Right image: scroll করে উপরে যাবে --}}
        <div class=" w-1/2 overflow-hidden pl-12"


            style="height:110%; margin-left:2px; flex-shrink:0;">
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

    {{-- Hover image (follows cursor) --}}
    <div id="newsHoverImg"
        style="position:fixed; pointer-events:none; z-index:999;
               width:120px; height:150px;
               transform:rotate(10deg) translate(-50%,-50%);
               opacity:0; transition:opacity 0.3s ease;
               overflow:hidden; top:0; left:0;">
        <img id="newsHoverImgEl" src="" alt=""
            style="width:100%; height:100%; object-fit:cover;" />
    </div>

    <div class="container mx-auto flex flex-col md:flex-row gap-8 lg:gap-24 pt-12 md:pt-[100px]">

        {{-- Left Side --}}
        <div class="w-full md:w-[30%] relative z-10">

            {{-- MOBILE --}}
            <div class="flex md:hidden items-center justify-between mb-2">
                <h2 style=" font-weight:500; font-size:clamp(28px,7vw,48px); color:#1a1a1a; line-height:1.1;">
                    News
                    <em style=" font-style:italic; font-weight:300; font-size:0.85em; color:#3a3a3a; margin:0 3px;">&amp;</em>
                    Events
                </h2>
                <a href="/events"
                    class="flex items-center justify-center rounded-full flex-shrink-0"
                    style="width:85px; height:85px; border:1.5px solid #1a1a1a; font-size:11px; letter-spacing:0.08em; color:#1a1a1a; text-decoration:none; transition:background 0.3s, color 0.3s;"
                    onmouseover="this.style.background='#152018'; this.style.color='#f2ede6';"
                    onmouseout="this.style.background='transparent'; this.style.color='#1a1a1a';">
                    View All
                </a>
            </div>

            {{-- DESKTOP: News | line | Events --}}
            <div class="hidden md:flex flex-row items-center justify-between min-h-[500px]">

                {{-- Rotated container --}}
                <div style="display:flex; flex-direction:column; align-items:flex-start; gap:0;
            transform:rotate(-90deg); white-space:nowrap; transform-origin: center center;">

                    <span style=" font-weight:500;
                 font-size:clamp(40px,5vw,72px); color:#1a1a1a; letter-spacing:-0.01em;
                 display:block; line-height:1.1;">
                        News
                    </span>

                    <span class="scroll-move" data-axis="X"
                        style=" font-weight:500;
               font-size:clamp(40px,5vw,72px); color:#1a1a1a; letter-spacing:-0.01em;
               display:block; line-height:1.1;
               transition: transform 0.6s cubic-bezier(0.25,0.46,0.45,0.94);
               will-change: transform;">
                        &amp; Events
                    </span>

                </div>

                <a href="/events"
                    class="flex items-center justify-center rounded-full"
                    style="width:130px; height:130px; border:1.5px solid #1a1a1a; font-size:13px;
               letter-spacing:0.08em; color:#1a1a1a; text-decoration:none; flex-shrink:0;
               transition:background 0.3s, color 0.3s;"
                    onmouseover="this.style.background='#152018'; this.style.color='#f2ede6';"
                    onmouseout="this.style.background='transparent'; this.style.color='#1a1a1a';">
                    View All
                </a>

            </div>

        </div>

        {{-- Right Side: List --}}
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
                       flex flex-col sm:flex-row gap-2 sm:gap-12 items-start
                       group  transition duration-300
                       px-3 sm:px-4 -mx-3 sm:-mx-4 cursor-pointer"
                data-img="{{ $imgPath }}"
                style="text-decoration:none;">

                <div class="w-full sm:w-40 flex-shrink-0 flex sm:flex-col flex-row gap-2 sm:gap-0">
                    <p class="text-base md:text-xl text-[#54504a] font-medium">{{ $type }}</p>
                    @if($date)
                    <p class="text-xs md:text-sm text-[#857f77] sm:mt-1">
                        {{ \Carbon\Carbon::parse($date)->format('d F Y') }}
                    </p>
                    @endif
                </div>

                <div class="flex-1">
                    <h3 class="text-base md:text-xl lg:text-[1.35rem] text-[#2a2825] font-light leading-snug">
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
<section class="relative z-10 w-full py-20 px-6 md:px-12 lg:px-24 overflow-hidden" style="background:#fff;">

   
 

      <div class="absolute inset-0 pointer-events-none overflow-hidden" style="z-index:0;">
         <div class="absolute left-0 top-0 w-1/3 h-full opacity-50"
             style="background-image: url('/assets/images/partners-bg.png'); background-repeat: repeat-y; background-size: 100% auto;">
         </div>
     </div>
    <!-- Content -->
    <div class="relative z-10 px-6 md:px-16 lg:px-24">

        <!-- Heading -->
        <h2 class="mb-16 font-light leading-tight text-gray-900 scroll-move" data-axis="Y" style="font-size:clamp(32px,4.5vw,64px);">
            @php

            $partnerTitle = $partners->title ?? 'Be a partner, be a patron';
            $titleParts = explode(',', $partnerTitle);
            @endphp

            @if(count($titleParts) >= 2)
            {{-- Line 1: "Be a partner" --}}
            @php preg_match('/^(.*?)(\w+)$/u', trim($titleParts[0]), $m1); @endphp
            <span class="font-normal">{{ trim($m1[1] ?? '') }}</span>
            <em class="font-light italic">{{ trim($m1[2] ?? $titleParts[0]) }}</em>
            <span class="font-normal">,</span><br />

            {{-- Line 2: "be a patron" --}}
            @php preg_match('/^(.*?)(\w+)$/u', trim($titleParts[1]), $m2); @endphp
            <span class="font-normal">{{ trim($m2[1] ?? '') }}</span>
            <em class="font-light italic">{{ trim($m2[2] ?? $titleParts[1]) }}</em>
            @else
            {{ $partnerTitle }}
            @endif
        </h2>

        <!-- Two Cards Row -->
        <div class="flex flex-col md:flex-row gap-4 items-stretch md:ml-[28%]">

            <!-- Card 1: Landowner -->
            <a href="{{ $partners->url ?? '/landowner-contact' }}"
                class="relative flex flex-col justify-between flex-1 cursor-pointer group border rounded-none p-6 min-h-[520px] transition-all duration-300"
                style="border-color:#c8bfb0; background:rgba(242,237,230,0.6); text-decoration:none;"
                onmouseover="this.style.borderColor='#8a7a60';"
                onmouseout="this.style.borderColor='#c8bfb0';">

                <!-- Arrow top right -->
                <div class="flex justify-end">
                    <div class="w-9 h-9 rounded-full border border-gray-400 flex items-center justify-center transition-all duration-300 group-hover:bg-gray-900 group-hover:border-gray-900">
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                            <path d="M3 11L11 3M11 3H5M11 3V9"
                                class="transition-all duration-300 group-hover:stroke-white"
                                stroke="#555" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                </div>

                <!-- Bottom text -->
                <div class="mt-auto pt-8">
                    <h3 class="text-gray-900 font-normal mb-2"
                        style=" font-size:clamp(18px,1.8vw,24px);">
                        {{ $partners->short ?? 'Contact as Landowner' }}
                    </h3>
                    <p class="text-sm font-light leading-relaxed text-gray-500 max-w-xs">
                        {!! $partners->body ?? 'Partner with us to transform your property into a landmark development.' !!}
                    </p>
                </div>
            </a>

            <!-- Card 2: Customer -->
            <a href="{{ $partners->extra ?? '/customer-contact' }}"
                class="relative flex flex-col justify-between flex-1 cursor-pointer group overflow-hidden min-h-[520px] p-6 -mt-10"
                style="text-decoration:none;">

                <!-- Background image -->
                <img src="{{ $partners->img_path ?? asset('assets/images/customer.png') }}"
                    alt="room"
                    class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105 z-0"
                    onerror="this.parentElement.style.background='#1a2a2a'; this.style.display='none';" />

                <!-- Dark overlay -->
                <div class="absolute inset-0 z-[1]"
                    style="background:linear-gradient(to top, rgba(0,0,0,0.75) 40%, rgba(0,0,0,0.25) 100%);"></div>

                <!-- Arrow top right -->
                <div class="relative z-10 flex justify-end">
                    <div class="w-9 h-9 rounded-full border border-white flex items-center justify-center transition-all duration-300 group-hover:bg-white">
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                            <path d="M3 11L11 3M11 3H5M11 3V9"
                                class="transition-all duration-300 group-hover:stroke-gray-900"
                                stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                </div>

                <!-- Center text -->
                <div class="relative z-10 flex flex-col items-start justify-center flex-1">
                    <h3 class="text-white font-normal mb-2"
                        style="font-size:clamp(18px,1.8vw,24px);">
                        {{ $partners->location ?? 'Contact as Customer' }}
                    </h3>
                    <p class="text-sm font-light leading-relaxed text-white max-w-xs">
                        {!! $partners->body_2 ?? 'Get in touch to find your dream home with Bhaiya Housing.' !!}
                    </p>
                </div>
            </a>
            <img src="{{ asset('images/mission-stone.png') }}" alt=""
                class="absolute pointer-events-none scroll-move" data-axis="Y"
                style="width: 120px; bottom: -10px; right: 50px; z-index: 20;"
                onerror="this.style.display='none';">
        </div>
<div class="absolute pointer-events-none"
     style="width: 200px; bottom: 40px; left: 50px; z-index: 20;">
  <svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 300 300">
    <defs>
      <style>
        .ring1 { animation: radar-pulse 2.5s ease-out infinite; }
        @keyframes radar-pulse {
          0%   { r: 67.5px; opacity: 0.9; stroke-width: 2.5; }
          100% { r: 130px;  opacity: 0;   stroke-width: 0.5; }
        }
      </style>
      <filter id="filter0_d" x="0.3" y="0.3" width="158.4" height="158.4" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
        <feFlood flood-opacity="0" result="BackgroundImageFix"/>
        <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
        <feOffset dy="4"/>
        <feGaussianBlur stdDeviation="5.35"/>
        <feComposite in2="hardAlpha" operator="out"/>
        <feColorMatrix type="matrix" values="0 0 0 0 0.945833 0 0 0 0 0.715603 0 0 0 0 0.279809 0 0 0 1 0"/>
        <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow"/>
        <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow" result="shape"/>
      </filter>
      <filter id="filter1_d" x="21" y="22" width="116" height="116" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
        <feFlood flood-opacity="0" result="BackgroundImageFix"/>
        <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
        <feOffset dy="4"/>
        <feGaussianBlur stdDeviation="2"/>
        <feComposite in2="hardAlpha" operator="out"/>
        <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/>
        <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow1"/>
        <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow1" result="shape"/>
      </filter>
    </defs>

    <!-- Single radar pulse ring -->
    <g transform="translate(150,150)">
      <circle class="ring1" cx="0" cy="0" r="67.5" fill="none" stroke="#B79870" stroke-width="2"/>
    </g>

    <!-- Original SVG content -->
    <g transform="translate(70.5, 74.5)">
      <g filter="url(#filter0_d)">
        <circle cx="79.5" cy="75.5" r="67.5" stroke="#B79870" stroke-width="2" shape-rendering="crispEdges" fill="none"/>
      </g>
      <g filter="url(#filter1_d)">
        <circle cx="79" cy="76" r="52" fill="white"/>
        <circle cx="79" cy="76" r="53" stroke="#A68356" stroke-width="2" fill="none"/>
      </g>
      <path d="M52 85.5238L70.4079 68.9097L72.157 78.1099L64.2359 85.5238H52Z" fill="#2B2B2B"/>
      <path d="M76.069 74.3843L72.1569 78.1099L70.4078 68.9097L76.069 74.3843Z" fill="#050505"/>
      <path d="M81.8718 68.9097L107 91.9159H94.764L70.4078 68.9097H81.8718Z" fill="#323232"/>
      <path d="M91.333 64.2029L98.5642 60V72.7804L91.333 76.9423V64.2029Z" fill="#323232"/>
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

        // ── Hover: image expand ──
        document.querySelectorAll('.quality-img-wrap').forEach(wrap => {
            const img = wrap.querySelector('.quality-img');

            wrap.addEventListener('mouseenter', () => {
                img.style.transform = 'scale(1.08)';
            });

            wrap.addEventListener('mouseleave', () => {
                img.style.transform = 'scale(1)';
            });
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
            img.style.transform = 'scale(1)';
        });

        col.addEventListener('mouseleave', () => {
            wrap.style.width = '60%';
            wrap.style.height = '550px';
            img.style.transform = 'scale(1.04)';
        });
    });
</script>
@endpush
@endsection