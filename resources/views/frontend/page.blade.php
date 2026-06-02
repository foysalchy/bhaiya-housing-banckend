@extends('layouts.front')
@section('title', $page->title ?? 'Page')
@section('meta')
@php
$pageTitle = ($page->title ?? 'Page') . ' – ' . ($setting->title ?? 'Bhaiya Housing Ltd.');

// ডেসক্রিপশন সেট করা
$pageDesc = isset($page->body) && !empty($page->body)
    ? Str::limit(strip_tags($page->body), 160)
    : 'Read more about Bhaiya Housing Ltd., shaping the future of real estate in Bangladesh.';

$pageUrl = url()->current();
// ডিফল্ট কোনো লোগো বা ব্যানার ইমেজ
$pageImage = asset('assets/images/logo.png');

// সোশ্যাল লিংক হ্যান্ডেল করা
$socialLinks = isset($socials) ? $socials->map(fn($s) => $s->url)->filter()->values()->toArray() : [];

$schema = [
    "page" => [
        "description" => $pageDesc,
        "keywords" => implode(', ', array_filter([
            $page->title ?? 'Page',
            'Bhaiya Housing',
            'Bhaiya Housing Ltd',
            'real estate Bangladesh',
            'property developer Dhaka'
        ])),
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
                ["@type" => "ListItem", "position" => 2, "name" => $page->title ?? 'Page', "item" => $pageUrl],
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

{{-- SCHEMAS --}}
<script type="application/ld+json">
    {!! json_encode($schema['organization'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>

<script type="application/ld+json">
    {!! json_encode($schema['webPage'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
@endsection

@section('content')


<section class="hero-fixed fixed top-0 left-0 w-full overflow-hidden h-[400px] md:h-[500px]"
    style="z-index:1; transform-origin:top center; will-change:transform;">

    {{-- Background --}}
    <div class="absolute inset-0" style="background:#1B281F;"></div>

    {{-- Subtle texture/overlay --}}
    <div class="absolute inset-0 opacity-20"
        style="background: radial-gradient(ellipse at 70% 50%, #2d4a33, transparent 70%);"></div>

    {{-- Content --}}
    <div class="absolute inset-0 flex items-center">
        <div class="container mx-auto px-6 lg:px-14">
            <div class="flex flex-col md:flex-row justify-between items-end">

                {{-- Title --}}
                <div>
                    <h1 class="text-white mb-6 pt-24" style="font-size:3.85vw; font-weight:300;">
                        <span class="font-migra-italic">{{ $page->title }}</span>
                    </h1>
                    <div style="border-top:1px solid rgba(255,255,255,0.4); width:min(600px, 80vw);"></div>
                </div>

            </div>
        </div>
    </div>

</section>
<div class="w-full pointer-events-none h-[400px] md:h-[500px]"></div>


<!-- DETAIL CONTENT -->
<section class="relative z-10 w-full py-16 md:py-24 bg-white overflow-hidden">
    <div class="container mx-auto px-4 sm:px-6 lg:px-14">
        
        <div class="max-w-4xl mx-auto">
            <div class="prose prose-sm md:prose-base max-w-none page-body text-gray-800 leading-relaxed">
                {!! $page->body !!}
            </div>

            <!-- Back to Home Button -->
            <div class="mt-12">
                <a href="{{ url('/') }}"
                    class="inline-block px-8 py-2.5 border border-gray-700 text-sm font-light text-gray-700 tracking-wide transition-all duration-300 hover:bg-gray-900 hover:text-white">
                    Back to Home
                </a>
            </div>
        </div>

    </div>

   

</section>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Facebook ViewContent Event Tracking for Dynamic Pages
        if (typeof fbq !== 'undefined') {
            fbq('track', 'ViewContent', {
                content_name: '{{ addslashes($page->title) }}',
                content_category: 'Information Page',
                content_type: 'page'
            });
        }
    });
</script>
@endpush