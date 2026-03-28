 @extends('layouts.front')
 @section('title', 'News & Events')

 @section('meta')
 @php
 $pageTitle = 'News & Events – ' . ($setting->title ?? 'Bhaiya Housing Ltd.');
 $pageDesc = 'Stay informed with the latest updates, press releases, and upcoming events from Bhaiya Housing Ltd. Discover our continuous journey in shaping modern real estate in Bangladesh.';
 $pageUrl = url()->current();
 $pageImage = isset($eventHero->img_path) ? asset($eventHero->img_path) : asset('assets/images/event.jpg');

 // Safe fallback for socials
 $socialLinks = isset($socials) ? $socials->map(fn($s) => $s->url)->filter()->values()->toArray() : [];

 $schema = [
 "page" => [
 "description" => $pageDesc,
 "keywords" => implode(', ', [
 'Bhaiya Housing news',
 'real estate events Bangladesh',
 'property development updates Dhaka',
 'Bhaiya Group press release',
 'upcoming housing events BD',
 'real estate latest news',
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
 "@type" => "CollectionPage",
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
 ["@type" => "ListItem", "position" => 2, "name" => "News & Events", "item" => $pageUrl],
 ],
 ],
 ],
 "newsEventList" => [
 "@context" => "https://schema.org",
 "@type" => "ItemList",
 "name" => "Bhaiya Housing News and Events",
 "url" => $pageUrl,
 "numberOfItems" => isset($newsEvents) ? count($newsEvents) : 0,
 "itemListElement" => isset($newsEvents) ? collect($newsEvents)->map(fn($item, $i) => [
 "@type" => "ListItem",
 "position" => $i + 1,
 "item" => [
 // Dynamically set schema type based on item type
 "@type" => (isset($item['type']) && $item['type'] === 'events') ? "Event" : "NewsArticle",
 "headline" => $item['title'] ?? ($item->title ?? ''),
 "url" => $item['url'] ?? url('/' . ($item['type'] ?? 'news') . '/' . ($item['id'] ?? '')),
 "datePublished" => $item['date'] ?? ($item->start_date ?? null),
 "publisher" => ["@id" => url('/') . '#organization']
 ],
 ])->values()->toArray() : [],
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

 @if(isset($newsEvents) && count($newsEvents) > 0)
 <script type="application/ld+json">
     {
         !!json_encode($schema['newsEventList'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!
     }
 </script>
 @endif
 @endsection
 @section('content')

 <!-- ===== HERO ===== -->
<section class="relative w-full overflow-hidden" style="height: clamp(320px, 45vw, 560px);">

    <!-- Background Image -->
    <img src="{{  asset('assets/images/event.jpg') }}" alt="interior"
        class="absolute inset-0 w-full h-full object-cover" />

    <!-- Dark Overlay -->
    <div class="absolute inset-0 bg-black/50"></div>

    <!-- Text -->
    <div class="absolute inset-0 flex items-center px-6 sm:px-10 md:px-20">
        <h2 class="text-white font-light" style="font-size:clamp(18px,3.5vw,52px); line-height:1.2;">
            <span style="font-family:'Jost',sans-serif; font-weight:400;">Where </span>
            <em style="font-family:'Cormorant Garamond',serif; font-style:italic; font-weight:300;">Stay informed with
            </em>
            <span style="font-family:'Jost',sans-serif; font-weight:400;"><br> </span>
            <em style="font-family:'Cormorant Garamond',serif; font-style:italic; font-weight:300;">Bhaiya Housing Ltd.
            </em>
        </h2>
    </div>

</section>

@php
    $type = $item->type;
    $date = $item->start_date
                ? \Carbon\Carbon::parse($item->start_date)->format('d F Y')
                : null;
    $endDate = ($type === 'events' && $item->end_date)
                ? \Carbon\Carbon::parse($item->end_date)->format('d F Y')
                : null;
    $shareUrl   = urlencode(request()->fullUrl());
    $shareTitle = urlencode($item->title);
@endphp

<section class="w-full min-h-screen py-20" style="background:#f2ede6; font-family:'Jost',sans-serif;">
    <div class="container mx-auto px-6 lg:px-14">

        <div class="flex flex-col md:flex-row gap-16 items-start">

            <!-- ── Left: Meta ── -->
            <div class="w-full md:w-[30%] flex-shrink-0 sticky top-24">

                <!-- Back -->
                <a href="javascript:history.back()"
                    class="flex items-center gap-2 text-sm text-gray-700 hover:text-gray-900 transition-colors duration-200 mb-8"
                    style="font-weight:300; letter-spacing:0.05em;">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M10 3L5 8l5 5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Back
                </a>

                <!-- Title -->
                <h1 class="font-light text-gray-900 mb-4"
                    style="font-family:'Cormorant Garamond',serif; font-size:clamp(28px,4vw,52px); font-weight:300; line-height:1.2;">
                    {{ $item->title }}
                </h1>

                <!-- Type + Date -->
                <p class="text-sm text-gray-700 mb-6" style="font-weight:300;">
                    {{ ucfirst($type) }}
                    @if($date) <span class="opacity-50 mx-1">|</span> {{ $date }} @endif
                    @if($endDate) <span class="opacity-50 mx-1">—</span> {{ $endDate }} @endif
                </p>

                @if($type === 'events' && $item->location)
                <p class="text-sm text-gray-700 mb-4 flex items-center gap-2" style="font-weight:300;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/>
                    </svg>
                    {{ $item->location }}
                </p>
                @endif

                @if($type === 'news' && $item->short)
                <p class="text-xs text-gray-600 mb-6" style="letter-spacing:0.08em;">
                    {{ $item->short }} min read
                </p>
                @endif

                <!-- Share -->
                <div class="mt-2">
                    <p class="text-xs text-gray-600 mb-3 tracking-widest uppercase">Share</p>
                    <div class="flex items-center gap-3">

                       @foreach($socials as $social)
                        <a href="{{ $social->url }}" aria-label="{{ $social->title }}" target="_blank" rel="noopener"
                        class="w-9 h-9 rounded-full border border-gray-300 flex items-center justify-center hover:border-gray-900 hover:bg-gray-900 transition-all duration-300 group">
                            {!! $social->short !!}
                        </a>
                        @endforeach

                    </div>
                </div>

            </div>

            <!-- ── Right: Content ── -->
            <div class="flex-1 min-w-0">

                {{-- Thumbnail --}}
                @if($item->img_path)
                <div class="w-full overflow-hidden mb-10" style="height:clamp(260px,40vw,500px);">
                    <img src="{{ asset($item->img_path) }}" alt="{{ $item->title }}"
                        class="w-full h-full object-cover"
                        onerror="this.parentElement.style.background='#d6cfc5'; this.style.display='none';" />
                </div>
                @endif

                {{-- Body --}}
                @if($item->body)
                <div class="prose prose-sm max-w-none text-gray-700 leading-loose mb-8"
                    style="font-size:clamp(14px,1.2vw,16px); font-weight:300; line-height:2;">
                    {!! $item->body !!}
                </div>
                @endif

                {{-- Body 2 (events only) --}}
                @if($type === 'events' && $item->body_2)
                <div class="prose prose-sm max-w-none text-gray-700 leading-loose mb-8"
                    style="font-size:clamp(14px,1.2vw,16px); font-weight:300; line-height:2;">
                    {!! $item->body_2 !!}
                </div>
                @endif

                {{-- Event Photos --}}
                @if($type === 'events' && count($imgPaths) > 0)
                <div class="mt-10">
                    <hp class="text-sm font-light text-gray-700 mb-4 tracking-widest uppercase">Photos</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach($imgPaths as $img)
                        <div class="overflow-hidden" style="height:200px;">
                            <img src="{{ asset($img) }}" alt="Event photo"
                                class="w-full h-full object-cover hover:scale-105 transition-transform duration-500"
                                onerror="this.parentElement.style.background='#c8c0b8'; this.style.display='none';" />
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Map (events only) --}}
                @if($type === 'events' && $item->extra)
                <div class="mt-10" style="height:300px;">
                    <iframe src="{{ $item->extra }}"
                        class="w-full h-full border-0"
                        allowfullscreen loading="lazy">
                    </iframe>
                </div>
                @endif

                {{-- Related --}}
                @if($related->isNotEmpty())
                <div class="mt-16 pt-10" style="border-top:1px solid #c8c0b4;">
                    <p class="text-sm font-light text-gray-700 mb-8 tracking-widest uppercase">
                        More {{ ucfirst($type) }}
                    </p>
                    <div class="flex flex-col gap-0">
                        @foreach($related as $rel)
                        <a href="/{{ $rel->type }}/{{ $rel->id }}"
                            class="flex gap-8 items-start py-5 hover:bg-white/60 px-3 -mx-3 transition-colors duration-200"
                            style="border-bottom:1px solid #c8c0b4; text-decoration:none;">
                            <div class="w-32 flex-shrink-0">
                                <p class="text-sm text-gray-700 font-light">
                                    {{ $rel->start_date ? \Carbon\Carbon::parse($rel->start_date)->format('d F Y') : '' }}
                                </p>
                            </div>
                            <p class="text-gray-900 font-light" style="font-size:clamp(15px,1.2vw,18px);">
                                {{ $rel->title }}
                            </p>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

            </div>

        </div>
    </div>
</section>






 @endsection
