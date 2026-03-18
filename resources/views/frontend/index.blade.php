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
    {!! json_encode($schema['organization'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>

{{-- WEBSITE SCHEMA --}}
<script type="application/ld+json">
    {!! json_encode($schema['webSite'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>

{{-- WEBPAGE SCHEMA --}}
<script type="application/ld+json">
    {!! json_encode($schema['webPage'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>

@if(isset($featuredProjects) && $featuredProjects->isNotEmpty())
{{-- PROJECT LISTING SCHEMA --}}
<script type="application/ld+json">
    {!! json_encode($schema['projectListing'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
@endif

@if(isset($newsEvents) && count($newsEvents) > 0)
{{-- NEWS & EVENTS LIST SCHEMA --}}
<script type="application/ld+json">
    {!! json_encode($schema['newsEventList'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
@endif

{{-- FAQ SCHEMA --}}
<script type="application/ld+json">
    {!! json_encode($schema['faq'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
@endsection

@section('content')

 <!-- ===== HERO ===== -->
 <section id="home" class=" relative h-screen w-full overflow-hidden">
     <!-- Background -->
     <div class="absolute inset-0">
         <img src="{{ $hero->img_path ?? asset('assets/images/hero-bg.jpg') }}" alt="hero-bg" class="w-full h-full object-cover scale-[1.06] animate-[zoomOut_8s_ease_forwards]" />
         <div class="absolute inset-0"
             style="background: linear-gradient(110deg, rgba(13,18,28,0.72) 0%, rgba(13,18,28,0.52) 55%, rgba(13,18,28,0.28) 100%);">
         </div>
     </div>

     <!-- Content -->
     <div class="relative z-10 h-full flex flex-col justify-center items-end">
         <div class="container mx-auto">
             <div class="max-w-3xl mt-5">

                 <h1
                     class="font-heading text-5xl md:text-6xl lg:text-7xl leading-[1.08] opacity-0 animate-[fadeUp_0.8s_0.35s_ease_forwards]">
                   {{$hero->titlle ?? 'We transform your dreams into addresses'}}
                 </h1>
             </div>

             <div class="mt-28 max-w-xl opacity-0 animate-[fadeUp_0.8s_0.55s_ease_forwards]">
                 <p class="ml-10 opacity-80 text-sm md:text-base leading-relaxed font-light px-10">
                     {{$hero->short ?? 'Immerse yourself in the artistry of exceptional spaces with Bhaiya Housing, where each project is a harmonious blend of prestige, elegance, and refined sophistication. Beyond constructing buildings, we meticulously create residential and commercial environments to reflect your aspirations.'}}
                 </p>
             </div>

         </div>
     </div>

     <!-- Scroll indicator -->
     <div class="absolute bottom-10 left-6 md:left-16 z-20 animate-bounce">
         <div
             class="w-14 h-14 rounded-full border border-white/30 hover:border-white/60 flex items-center justify-center transition-colors cursor-pointer">
             <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"
                 stroke-opacity="0.7">
                 <polyline points="6 9 12 15 18 9"></polyline>
             </svg>
         </div>
     </div>

<!-- Video card -->
<div class="absolute bottom-8 right-6 md:right-16 z-20 w-[320px]  flex border border-white/10 bg-black/50 backdrop-blur-md hover:border-white/25 transition-all opacity-0 animate-[fadeUp_0.7s_0.9s_ease_forwards]">

    <!-- Left: Video autoplay (silent preview) -->
    <div class="w-[150px] flex-shrink-0 relative overflow-hidden">
        <video class="w-full h-full object-cover" autoplay muted loop playsinline>
            <source src="{{ $hero?->video_path ?? asset('assets/video/1.mp4') }}" type="video/mp4" />
        </video>
        <div class="absolute inset-0 bg-black/30"></div>
    </div>

    <!-- Right: Watch button -->
    <div class="flex-1 p-3 flex flex-col justify-between">
        <div class="flex items-center justify-end gap-2">
            <span class="text-[10px] tracking-[1px] text-white/60">View</span>
            <div class="w-8 h-8 rounded-full border border-white/30 flex items-center justify-center flex-shrink-0">
                <svg width="10" height="12" viewBox="0 0 12 14" fill="none">
                    <path d="M12 7L0 14V0L12 7Z" fill="white" />
                </svg>
            </div>
        </div>
        <p class="text-base font-light tracking-wide cursor-pointer hover:opacity-80 transition-opacity"
            onclick="openVideoModal()">
            Watch our video
        </p>
    </div>

</div>

<!-- ── Video Modal ── -->
<div id="videoModal"
    class="fixed inset-0 z-[200] items-center justify-center bg-black/85 backdrop-blur-sm"
    style="display:none;"
    onclick="closeVideoModal(event)">

    <div class="relative w-full max-w-4xl mx-4" onclick="event.stopPropagation()">

        <!-- Close -->
        <button onclick="closeVideoModal()"
            class="absolute -top-10 right-0 text-white opacity-70 hover:opacity-100 transition-opacity">
            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" stroke="white" stroke-width="1.5" stroke-linecap="round">
                <line x1="4" y1="4" x2="24" y2="24" />
                <line x1="24" y1="4" x2="4" y2="24" />
            </svg>
        </button>

        <!-- Video with sound -->
        <video id="modalVideo" class="w-full" controls playsinline style="max-height:80vh;">
            <source src="{{ $hero?->video_path ?? asset('assets/video/1.mp4') }}" type="video/mp4" />
        </video>

    </div>
</div>
 </section>


<section class="py-16 md:py-24 overflow-hidden bg-[#FFFDFA]" style="padding-top: 80px;">
    <div class="mx-auto px-4 sm:px-6 lg:px-10">

        @php
        $extraImages = json_decode($dreams->img_paths ?? '[]', true);
        @endphp

        <!-- ══════════════════════════════════
             MOBILE LAYOUT (flex-col, < md)
        ══════════════════════════════════ -->
        <div class="flex flex-col gap-8 md:hidden">

            <!-- Heading -->
            <h2 class="font-display text-4xl sm:text-5xl font-light leading-tight text-gray-900 text-center">
                {!! nl2br(e($dreams->title ?? "Building\ndreams for\ndecades")) !!}
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
            <div class="fade-in delay-3">
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
                    <a href="{{ $dreams->url ?? 'about.html' }}" class="circle-btn">Learn More</a>
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
                <h2 class="font-display text-5xl lg:text-6xl font-light leading-tight text-gray-900 text-center">
                    {!! nl2br(e($dreams->title ?? "Building\ndreams for\ndecades")) !!}
                </h2>

                <div class="mt-8 float-down fade-in delay-2" style="position:relative; left:-60px;">
                    <img src="{{ $extraImages[1] ?? asset('assets/images/side.jpg') }}"
                        alt="Outdoor space"
                        class="img-shadow rounded-sm object-cover"
                        style="width:400px; height:300px; object-position:center;"
                        onerror="this.style.background='#d6cfc5'; this.removeAttribute('src');" />
                </div>
            </div>

            <!-- Col 2: Big Center Image -->
            <div class="w-full md:w-5/12 relative fade-in delay-2" style="margin-left:2%;">
                <div class="img-shadow rounded-sm overflow-hidden" style="height:800px;">
                    <img src="{{ $dreams->img_path ?? asset('assets/images/main.avif') }}"
                        alt="Modern building"
                        class="w-full h-full object-cover"
                        onerror="this.style.background='#c5bdb5'; this.style.height='100%'; this.removeAttribute('src');" />
                </div>
            </div>

            <!-- Col 3: Right side -->
            <div class="w-full md:w-1/4 flex flex-col items-start pl-6 pt-2 fade-in delay-3" style="margin-left:4%;">

                <div class="float-up mb-8 self-end">
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
                    <a href="{{ $dreams->url ?? 'about.html' }}" class="circle-btn">Learn More</a>
                </div>
            </div>

        </div><!-- /Row 1 desktop -->

        <!-- Row 2: bottom images (desktop only) -->
        <div class="hidden md:flex relative flex-wrap items-center">

            <div class="absolute z-20 fade-in delay-3 float-down" style="left:20%; bottom:0px;">
                <img src="{{ $extraImages[0] ?? asset('assets/images/sub.jpg') }}"
                    alt="Property"
                    class="img-shadow rounded-sm object-cover"
                    style="width:400px; height:400px; object-position:center;"
                    onerror="this.style.background='#c0b8ae'; this.removeAttribute('src');" />
            </div>

            <div class="w-8 h-8 rounded-full float-up opacity-60 mt-10"
                style="background:radial-gradient(circle at 35% 35%,#c9b99a,#8a7560); width:44px; height:44px; margin-top:20px; margin-left:10px;">
            </div>

        </div><!-- /Row 2 desktop -->

    </div>
</section>

 @if($featuredProjects->isNotEmpty())
 @php $first = $featuredProjects->first(); @endphp

 <!-- ===== FEATURED PROJECTS ===== -->
 <section class="relative w-full overflow-hidden"
     style="height: 100vh; min-height: 600px; padding-bottom: 100px; padding-top: 100px;">

     <!-- Background Video -->
     <video id="heroVideo" class="absolute inset-0 w-full h-full object-cover" autoplay muted loop playsinline>
         <source id="heroVideoSource"
             src="{{ $first->video_path ?? asset('assets/video/1.mp4') }}"
             type="video/mp4" />
     </video>

     <!-- Dark Overlay -->
     <div class="absolute inset-0"
         style="background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.25) 50%, rgba(0,0,0,0.3) 100%);">
     </div>

     <!-- Top-right: Learn More circle button -->
     <div class="absolute top-6 right-8 z-20">
         <a id="heroLearnMore" href="/projects/{{ $first->id }}"
             class="circle-learn-btn flex items-center justify-center rounded-full border border-white text-white text-sm tracking-widest transition-all duration-300 hover:bg-white hover:text-black"
             style="width:120px; height:120px; font-family:'Jost',sans-serif; font-weight:400; letter-spacing:0.1em; font-size:13px;">
             Learn More
         </a>
     </div>

     <!-- Bottom-left: Title + Address -->
     <div class="absolute z-20 text-white" style="left: 32px;">
         <h2 id="heroTitle" class="font-display text-5xl font-light mb-2"
             style="font-family:'Cormorant Garamond',serif; font-weight:300;">
             {{ $first->title }}
         </h2>
         <p id="heroAddress" class="text-sm tracking-wide opacity-80"
             style="font-family:'Jost',sans-serif; font-weight:300; letter-spacing:0.05em;">
             {{ $first->location }}
         </p>
     </div>

     <!-- Bottom Thumbnails Strip -->
     <div class="absolute bottom-10 left-10 z-20 flex gap-1 p-4">

         @foreach($featuredProjects as $i => $project)
         <div class="thumb-item {{ $i === 0 ? 'active' : '' }} cursor-pointer overflow-hidden"
             style="width:70px; height:56px; border:2px solid {{ $i === 0 ? 'rgba(255,255,255,0.8)' : 'rgba(255,255,255,0.3)' }};"
             data-video="{{ $project->video_path ?? asset('assets/video/1.mp4') }}"
             data-title="{{ $project->title }}"
             data-address="{{ $project->location }}"
             data-url="/projects/{{ $project->id }}"
             onclick="switchVideo(this)">
             <img src="{{ $project->img_path ?? asset('assets/images/video-thumb' . ($i+1) . '.jpg') }}"
                 alt="{{ $project->title }}"
                 class="w-full h-full object-cover {{ $i === 0 ? 'opacity-90' : 'opacity-70' }} hover:opacity-100 transition-opacity duration-200"
                 onerror="this.parentElement.style.background='#3a3a3a'; this.style.display='none';" />
         </div>
         @endforeach

     </div>

 </section>
 @endif

 <!-- ===== QUALITY / EXCELLENCE ===== -->
 @php
 $expertiseImages = json_decode($expertise->img_paths ?? '[]', true);
 $bgTextLines = explode(' ', $expertise->short ?? 'Quality Construction');
 @endphp

 <section class="w-full overflow-hidden relative" style="background: rgb(21, 32, 24); padding-bottom: 15vw;">
     <div class="bg-image absolute inset-0 w-full h-full overflow-hidden" style="z-index:0;">
         <img id="qualityBg" class="absolute w-full" src="/assets/images/quality-bg.png" alt="image"
             style="top:-20%; left:0; height:140%; object-fit:cover; will-change:transform;" />
     </div>

     <!-- ── Part 1: Hero ── -->
     <div class="relative w-full flex flex-col items-center justify-center text-center overflow-hidden"
         style="padding: 80px 20px 0;">

         <!-- Ghost text background -->
         <span class="absolute inset-0 flex items-center justify-center select-none pointer-events-none"
             style="font-family:'Cormorant Garamond',serif; font-size:clamp(100px,18vw,260px); font-weight:700; color:rgba(255,255,255,0.04); letter-spacing:0.05em; white-space:nowrap; user-select:none;">
             EVERY
         </span>

         <!-- Headline --> 
         <div class="relative z-10">
             <h2 class="text-white font-light mb-1"
                 style="font-family:'Jost',sans-serif; font-size:clamp(28px,4vw,56px); font-weight:300; letter-spacing:0.01em;">
                 {{ $expertise->title ?? '12+ years of expertise.' }}
             </h2>
             <div class="flex items-center justify-center gap-3 mb-2">
                 <span class="block w-px bg-white opacity-40" style="height:28px;"></span>
             </div>
             <p class="text-white opacity-60 tracking-widest uppercase text-xs mb-2"
                 style="letter-spacing:0.2em;">Excellence in</p>
             <h3 class="text-white font-light"
                 style="font-family:'Cormorant Garamond',serif; font-size:clamp(40px,7vw,96px); font-weight:300;">
                 {{ $expertise->name ?? 'Every detail' }}
             </h3>
         </div>

         <!-- Center architectural image -->
         <div class="relative z-10 mt-10 w-full"
             style="max-width:900px; height:clamp(300px,45vw,520px); overflow:hidden;">
             <img src="{{ $expertise->img_path ?? asset('assets/images/quality-top.jpg') }}"
                 alt="Architectural detail"
                 class="w-full h-full object-cover"
                 onerror="this.parentElement.style.background='#1e2e20'; this.style.display='none';" />
         </div>
     </div>

     <!-- ── Part 2: Two columns ── -->
     <div class="relative w-full overflow-hidden" style="margin-top:0;">


         <div class="absolute inset-0 flex flex-col justify-start pt-4 pl-4 select-none pointer-events-none overflow-hidden"
             style="z-index:0;">
             @foreach($bgTextLines as $line)
             <span style="font-family:'Cormorant Garamond',serif; font-size:clamp(60px,12vw,180px); font-weight:700; color:rgba(255,255,255,0.04); white-space:nowrap; line-height:1;">
                 {{ $line }}
             </span>
             @endforeach
         </div>

         <!-- Two Columns -->
         <div class="relative z-10 flex flex-col md:flex-row w-full"
             style="border-top:1px solid rgba(255,255,255,0.08);">

             <!-- Col 1 -->
             <div class="w-full md:w-1/2 flex flex-col"
                 style="border-right:1px solid rgba(255,255,255,0.08); padding:50px 40px 60px;">
                 <p class="text-white text-sm leading-relaxed mb-10 opacity-80"
                     style="max-width:480px; line-height:1.9; font-weight:300;">
                     {!! $expertise->body ?? 'We deliver exceptional construction using first-rate materials and innovative techniques. Every project is built with precision and care, ensuring unmatched durability, stunning aesthetics, and spaces that exceed expectations and endure over time.' !!}
                 </p>

                 <div class="expand-img-wrap overflow-hidden cursor-pointer" style="height:420px; position:relative;">
                     <img src="{{ $expertiseImages[0] ?? asset('assets/images/q1.jpg') }}"
                         alt="Lobby interior"
                         class="expand-img w-full h-full object-cover transition-transform duration-700 ease-in-out"
                         style="transform-origin:center center; transform:scale(1);"
                         onerror="this.parentElement.style.background='#1a2b1c'; this.style.display='none';" />
                     <div class="expand-overlay absolute inset-0 transition-opacity duration-500"
                         style="background:rgba(21,32,24,0.35); opacity:0;"></div>
                 </div>
             </div>

             <!-- Col 2 -->
             <div class="w-full md:w-1/2 flex flex-col" style="padding:50px 40px 60px;">
                 <p class="text-white text-sm leading-relaxed mb-10 opacity-80"
                     style="max-width:480px; line-height:1.9; font-weight:300;">
                     {!! $expertise->body_2 ?? 'We guarantee on-schedule completion, respecting your timelines without compromise. Projects are executed with careful planning and efficiency, giving you a smooth, hassle-free experience as you prepare to step into your perfectly completed space.' !!}
                 </p>

                 <div class="expand-img-wrap overflow-hidden cursor-pointer" style="height:420px; position:relative;">
                     <img src="{{ $expertiseImages[1] ?? asset('assets/images/q2.jpg') }}"
                         alt="Bathroom interior"
                         class="expand-img w-full h-full object-cover transition-transform duration-700 ease-in-out"
                         style="transform-origin:center center; transform:scale(1);"
                         onerror="this.parentElement.style.background='#1a2b1c'; this.style.display='none';" />
                     <div class="expand-overlay absolute inset-0 transition-opacity duration-500"
                         style="background:rgba(21,32,24,0.35); opacity:0;"></div>
                 </div>
             </div>

         </div>
     </div>
 </section>

 <!-- ===== TESTIMONIALS ===== -->
 @php
 $sectionImages = json_decode($storiesSection->img_paths ?? '[]', true);
 @endphp

 <section class="w-full relative overflow-hidden pt-16 pb-0 px-5" style="background:#F6F6F6;">
     <div class="container mx-auto px-6 lg:px-14 pt-16 pb-10">

         <!-- Decorative stone/dot -->
         <div class="absolute left-8 pointer-events-none" style="top:52%; z-index:2;">
             <img src="/assets/images/overview-stone.png" alt="" style="width:56px; opacity:0.7;"
                 onerror="this.style.display='none'" />
         </div>

         <div>
             <!-- Heading -->
             <h2 class="mb-10 font-light text-gray-900"
                 style="font-size:clamp(32px,5vw,64px); font-family:'Jost',sans-serif; font-weight:300; letter-spacing:-0.01em;">
                 {!! $storiesSection->title
                 ? preg_replace('/satisfaction/i', '<em style="font-family:\'Cormorant Garamond\',serif; font-style:italic; font-weight:300;">satisfaction</em>', e($storiesSection->title))
                 : 'The stories of <em style="font-family:\'Cormorant Garamond\',serif; font-style:italic; font-weight:300;">satisfaction</em>'
                 !!}
             </h2>

             <!-- Testimonial Content Row -->
             <div class="flex flex-col md:flex-row items-start gap-10 mb-0 relative">

                 <!-- Left: Avatar + Name -->
                 <div class="w-full md:w-1/4 flex flex-col gap-3">
                     <div class="rounded-full overflow-hidden border border-gray-200" style="width:64px; height:64px;">
                         <img id="testimonialAvatar"
                             src="{{ $storiesItems->first()->img_path ?? asset('assets/images/4.jpeg') }}"
                             alt="avatar"
                             class="w-full h-full object-cover transition-opacity duration-500"
                             onerror="this.src=''; this.parentElement.style.background='#d6cfc5';" />
                     </div>
                     <div>
                         <p id="testimonialName"
                             class="font-medium text-gray-900 text-lg transition-opacity duration-500"
                             style="font-family:'Jost',sans-serif; font-weight:500;">
                             {{ $storiesItems->first()->title ?? 'Md. Mamun Molla' }}
                         </p>
                         <p id="testimonialRole"
                             class="text-gray-600 text-sm mt-0.5 transition-opacity duration-500"
                             style="font-weight:300;">
                             {{ $storiesItems->first()->name ?? 'Professor' }}
                         </p>
                     </div>
                 </div>

                 <!-- Right: Quote -->
                 <div class="w-full md:w-3/4 relative ml-auto">
                     <span class="absolute -left-4 -top-2 text-gray-400 select-none"
                         style="font-size:52px; font-family:'Georgia',serif; line-height:1; opacity:0.6;">&ldquo;</span>

                     <p id="testimonialText"
                         class="text-gray-700 leading-relaxed pl-8 transition-opacity duration-500"
                         style="font-size:clamp(14px,1.3vw,17px); font-weight:300; line-height:1.95; max-width:780px;">
                         {!! $storiesItems->first()->body ?? '' !!}
                     </p>

                     <!-- Prev / Next arrows -->
                     <div class="flex gap-3 justify-end mt-6">
                         <button onclick="changeTestimonial(-1); resetAutoPlay()"
                            aria-label="Previous testimonial"
                            class="rounded-full border border-gray-400 flex items-center justify-center transition-all duration-300 hover:bg-gray-900 hover:border-gray-900 group"
                            style="width:44px; height:44px;">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                aria-hidden="true"
                                class="group-hover:stroke-white transition-colors duration-300">
                                <path d="M10 3L5 8L10 13" stroke="#555" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" class="group-hover:stroke-white" />
                            </svg>
                        </button>

                        <button onclick="changeTestimonial(1); resetAutoPlay()"
                            aria-label="Next testimonial"
                            class="rounded-full border border-gray-400 flex items-center justify-center transition-all duration-300 hover:bg-gray-900 hover:border-gray-900 group"
                            style="width:44px; height:44px;">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                aria-hidden="true"
                                class="group-hover:stroke-white transition-colors duration-300">
                                <path d="M6 3L11 8L6 13" stroke="#555" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" class="group-hover:stroke-white" />
                            </svg>
                        </button>
                     </div>
                 </div>
             </div>
         </div>

         <!-- Bottom Images -->
         <div class="flex w-full mt-10" style="height:clamp(320px,45vw,560px);">
             <div class="w-1/2 overflow-hidden">
                 <img src="{{ $storiesSection->img_path ?? asset('assets/images/test1.avif') }}"
                     alt="Interior" class="w-full object-cover"
                     onerror="this.parentElement.style.background='#c8c0b8'; this.style.display='none';" />
                 <p class="text-black font-body font-light leading-relaxed text-sm md:text-base">
                     {!! $storiesSection->body ?? 'Bhaiya Housing is devoted to designing inspiring residential and commercial spaces that transcend expectations.' !!}
                 </p>
             </div>
             <div class="w-1/2 overflow-hidden" style="margin-left:2px;">
                 <img src="{{ $sectionImages[0] ?? asset('assets/images/test2.avif') }}"
                     alt="Interior" class="w-full h-full object-cover"
                     onerror="this.parentElement.style.background='#bab4ac'; this.style.display='none';" />
             </div>
         </div>

     </div>
 </section>



 <!-- ===== NEWS & EVENTS ===== -->
<section class="py-16 md:py-20 px-4 sm:px-6 md:px-12 lg:px-24 overflow-hidden relative"
    style="background-color:#f2ede6; color:#2a2825;">

    <div class="container mx-auto flex flex-col md:flex-row gap-8 lg:gap-24 pt-12 md:pt-[100px]">

        <!-- Left Side: Title & Button -->
        <div class="w-full md:w-[30%] relative z-10">

            <!-- MOBILE: horizontal heading + button in a row -->
            <div class="flex md:hidden items-center justify-between mb-2">
                <h2 style="font-family:'Jost',sans-serif; font-weight:500; font-size:clamp(32px,8vw,52px); color:#1a1a1a; letter-spacing:-0.01em; line-height:1;">
                    News
                    <em style="font-family:'Cormorant Garamond',serif; font-style:italic; font-weight:300; font-size:0.85em; color:#3a3a3a; margin:0 4px;">&amp;</em>
                    Events
                </h2>

                <a href="/events"
                    class="flex items-center justify-center rounded-full flex-shrink-0"
                    style="width:90px; height:90px; border:1.5px solid #1a1a1a; font-size:11px; letter-spacing:0.08em; color:#1a1a1a; text-decoration:none; transition:background 0.3s, color 0.3s;"
                    onmouseover="this.style.background='#152018'; this.style.color='#f2ede6';"
                    onmouseout="this.style.background='transparent'; this.style.color='#1a1a1a';">
                    View All
                </a>
            </div>

                 <div class="w-40 flex-shrink-0">
                     <p class="text-xl text-[#54504a] font-medium mb-1">{{ $type }}</p>
                     @if($date)
                     <p class="text-sm text-[#5c5650]">{{ $date }}</p>
                     @endif
                 </div>
            <!-- DESKTOP: rotated vertical heading + circle button stacked -->
            <div class="hidden md:flex flex-row items-center justify-between min-h-[500px]">

                <div style="writing-mode:vertical-rl; transform:rotate(180deg); white-space:nowrap; display:flex; align-items:center; gap:4px;">
                    <span style="font-family:'Jost',sans-serif; font-weight:500; font-size:clamp(40px,5vw,72px); color:#1a1a1a; letter-spacing:-0.01em;">
                        News
                    </span>
                    <em style="font-family:'Cormorant Garamond',serif; font-style:italic; font-weight:300; font-size:clamp(32px,4vw,58px); color:#3a3a3a; margin:0 4px;">
                        &amp;
                    </em>
                    <span style="font-family:'Jost',sans-serif; font-weight:500; font-size:clamp(40px,5vw,72px); color:#1a1a1a; letter-spacing:-0.01em;">
                        Events
                    </span>
                </div>

                <a href="/events"
                    class="flex items-center justify-center rounded-full mt-8"
                    style="width:130px; height:130px; border:1.5px solid #1a1a1a; font-size:13px; letter-spacing:0.08em; color:#1a1a1a; text-decoration:none; flex-shrink:0; transition:background 0.3s, color 0.3s;"
                    onmouseover="this.style.background='#152018'; this.style.color='#f2ede6';"
                    onmouseout="this.style.background='transparent'; this.style.color='#1a1a1a';">
                    View All
                </a>
            </div>

        </div>

        <!-- Right Side: News & Events List -->
        <div class="w-full md:w-[70%] flex flex-col relative z-10">

            @forelse($newsEvents as $loop => $item)
            @php
            $isLast = $loop === count($newsEvents) - 1;
            $type = ucfirst($item->type);
            $date = $item->start_date
                ? \Carbon\Carbon::parse($item->start_date)->format('d F Y')
                : null;
            $url = $item->type === 'events'
                ? '/events/' . $item->id
                : '/news/' . $item->id;
            @endphp

            <a href="{{ $url }}"
                class="border-t {{ $isLast ? 'border-b' : '' }} border-[#ccc3b6] py-5 md:py-6 lg:py-8 flex flex-col sm:flex-row gap-2 sm:gap-12 items-start group hover:bg-[#e3dbcf] transition duration-300 px-3 sm:px-4 -mx-3 sm:-mx-4 cursor-pointer"
                style="text-decoration:none;">

                <div class="w-full sm:w-40 flex sm:flex-col flex-row gap-2 sm:gap-0 flex-shrink-0">
                    <p class="text-base md:text-xl text-[#54504a] font-medium">{{ $type }}</p>
                    @if($date)
                    <p class="text-xs md:text-sm text-[#857f77] sm:mt-1">{{ $date }}</p>
                    @endif
                </div>

                <div class="flex-1">
                    <h3 class="text-base md:text-xl lg:text-[1.35rem] text-[#2a2825] font-light leading-snug">
                        {{ $item->title }}
                    </h3>
                </div>

            </a>
            @empty
            <p class="text-[#857f77] py-10 text-center">কোনো News বা Events পাওয়া যায়নি।</p>
            @endforelse

        </div>
    </div>
</section>
 <!-- ===== PARTNERS / CTA ===== -->
 <section class="relative w-full py-20 px-6 md:px-12 lg:px-24 overflow-hidden" style="background:#f2ede6;">

     <!-- Map Background Image -->
     <div class="absolute inset-y-0 left-0 w-1/2 pointer-events-none" style="z-index:0;">
         <img src="/assets/images/partners-bg.png" alt="map"
             class="w-full object-cover opacity-50" style="height:550px;"
             onerror="this.style.display='none';" />
     </div>

     <!-- Content -->
     <div class="relative z-10 px-6 md:px-16 lg:px-24">

         <!-- Heading -->
         <h2 class="mb-16 font-light leading-tight text-gray-900" style="font-size:clamp(32px,4.5vw,64px);">
             @php

             $partnerTitle = $partners->title ?? 'Be a partner, be a patron';
             $titleParts = explode(',', $partnerTitle); 
             @endphp

             @if(count($titleParts) >= 2)
             {{-- Line 1: "Be a partner" --}}
             @php preg_match('/^(.*?)(\w+)$/u', trim($titleParts[0]), $m1); @endphp
             <span class="font-normal" style="font-family:'Jost',sans-serif;">{{ trim($m1[1] ?? '') }}</span>
             <em class="font-light italic" style="font-family:'Cormorant Garamond',serif;">{{ trim($m1[2] ?? $titleParts[0]) }}</em>
             <span class="font-normal" style="font-family:'Jost',sans-serif;">,</span><br />

             {{-- Line 2: "be a patron" --}}
             @php preg_match('/^(.*?)(\w+)$/u', trim($titleParts[1]), $m2); @endphp
             <span class="font-normal" style="font-family:'Jost',sans-serif;">{{ trim($m2[1] ?? '') }}</span>
             <em class="font-light italic" style="font-family:'Cormorant Garamond',serif;">{{ trim($m2[2] ?? $titleParts[1]) }}</em>
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
                         style="font-family:'Jost',sans-serif; font-size:clamp(18px,1.8vw,24px);">
                         {{ $partners->short ?? 'Contact as Landowner' }}
                     </h3>
                     <p class="text-sm font-light leading-relaxed text-gray-500 max-w-xs"
                         style="font-family:'Jost',sans-serif;">
                         {!! $partners->body ?? 'Partner with us to transform your property into a landmark development.' !!}
                     </p>
                 </div>
             </a>

             <!-- Card 2: Customer -->
             <a href="{{ $partners->extra ?? '/customer-contact' }}"
                 class="relative flex flex-col justify-between flex-1 cursor-pointer group overflow-hidden min-h-[520px] p-6"
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

                 <!-- Bottom text -->
                 <div class="relative z-10 mt-auto pt-8">
                     <h3 class="text-white font-normal mb-2"
                         style="font-family:'Jost',sans-serif; font-size:clamp(18px,1.8vw,24px);">
                         {{ $partners->location ?? 'Contact as Customer' }}
                     </h3>
                     <p class="text-sm font-light leading-relaxed text-white/80 max-w-xs"
                         style="font-family:'Jost',sans-serif;">
                         {!! $partners->body_2 ?? 'Get in touch to find your dream home with Bhaiya Housing.' !!}
                     </p>
                 </div>
             </a>

         </div>
     </div>
 </section>
 @if(count($storiesItems) > 0)
 <script>
     const testimonials = @json($storiesItems);

     let currentIndex = 0;
     let autoPlayTimer = null;

     function changeTestimonial(dir) {
         currentIndex = (currentIndex + dir + testimonials.length) % testimonials.length;
         const t = testimonials[currentIndex];

         const avatar = document.getElementById('testimonialAvatar');
         const name = document.getElementById('testimonialName');
         const role = document.getElementById('testimonialRole');
         const text = document.getElementById('testimonialText');

         [avatar, name, role, text].forEach(el => el.style.opacity = '0');

         setTimeout(() => {
             avatar.src = t.avatar;
             name.textContent = t.name;
             role.textContent = t.role;
             text.textContent = t.text;
             [avatar, name, role, text].forEach(el => el.style.opacity = '1');
         }, 350);
     }

     function resetAutoPlay() {
         clearInterval(autoPlayTimer);
         autoPlayTimer = setInterval(() => changeTestimonial(1), 5000);
     }

     resetAutoPlay();


 </script>
 @endif
 <script>
     function switchVideo(el) {
         // Video switch
         const video = document.getElementById('heroVideo');
         const source = document.getElementById('heroVideoSource');
         source.src = el.dataset.video;
         video.load();
         video.play();

         // Title & Address update
         document.getElementById('heroTitle').textContent = el.dataset.title;
         document.getElementById('heroAddress').textContent = el.dataset.address;

         // Learn More URL update
         document.getElementById('heroLearnMore').href = el.dataset.url;

         // Active thumbnail border toggle
         document.querySelectorAll('.thumb-item').forEach(t => {
             t.style.border = '2px solid rgba(255,255,255,0.3)';
             t.querySelector('img')?.classList.replace('opacity-90', 'opacity-70');
         });
         el.style.border = '2px solid rgba(255,255,255,0.8)';
         el.querySelector('img')?.classList.replace('opacity-70', 'opacity-90');
     }
      function openVideoModal() {
        const modal = document.getElementById('videoModal');
        const video = document.getElementById('modalVideo');
        modal.style.display = 'flex';
        video.currentTime   = 0;
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

 @endsection
