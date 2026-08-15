@extends('layouts.front')
@section('meta')
    @include('partials.meta', [
        'pageKey' => 'events',
        'title' => $item->meta_title ?? $item->title,
        'description' => $item->meta_description ?? $item->body,
        'keywords' => $item->meta_keywords,
        'image' => asset($item->img_path),
    ])
@endsection

@section('content')
    @php
        $extra = is_array($item->extra) ? $item->extra : json_decode($item->extra, true) ?? [];
        $isAdmin = auth()->check();

        $canSeeBody = !empty(trim(strip_tags($item->body))) && (($extra['status_body'] ?? '1') == '1' || $isAdmin);
        $canSeeBody2 =
            !empty(trim(strip_tags($item->body_2))) && (($extra['status_body_2'] ?? '1') == '1' || $isAdmin);
        $canSeeBody3 =
            !empty(trim(strip_tags($item->body_3))) && (($extra['status_body_3'] ?? '1') == '1' || $isAdmin);
     @endphp
    <!-- ===== HERO ===== -->
    <section class="hero-fixed fixed top-0 left-0 w-full overflow-hidden
                    h-[500px] sm:h-[600px] md:h-[700px] lg:h-[900px]">
        <!-- Background Image -->
        <img src="{{ asset('images/event.webp') }}" alt="event" class="absolute inset-0 w-full h-full object-cover" />

        <!-- Dark Overlay -->
        <div class="absolute inset-0 bg-black/50"></div>

        <!-- Text -->
        <div class="absolute inset-0 flex items-center px-6 sm:px-10 md:px-20">
            <h1 class="text-white font-light pl-4 sm:pl-8 md:pl-20 pt-16 sm:pt-24 md:pt-32"
                style="font-size: clamp(32px, 3.85vw, 90px); line-height: 1.2;">
                Stay informed with<br>
                <span class="font-migra-italic">Bhaiya Housing Ltd.</span>
            </h1>
        </div>
    </section>

    <div class="h-[500px] sm:h-[600px] md:h-[700px] lg:h-[900px] w-full pointer-events-none"
        style="position: relative; z-index: 2;"></div>

    @php
        $type = $item->type;
        $date = $item->start_date ? \Carbon\Carbon::parse($item->start_date)->format('d F Y') : null;
        $endDate =
            $type === 'events' && $item->end_date ? \Carbon\Carbon::parse($item->end_date)->format('d F Y') : null;
        $shareUrl = urlencode(request()->fullUrl());
        $shareTitle = urlencode($item->title);
     @endphp

    <section class="w-full min-h-screen py-12 md:py-20 relative z-10"
        style="background: #f2ede6; font-family: 'Jost', sans-serif;">
        <div class="container mx-auto px-4 sm:px-6 lg:px-14">

            <div class="flex flex-col md:flex-row gap-8 md:gap-16 items-start">

                <!-- ── Left: Meta ── -->
                <div class="w-full md:w-[30%] flex-shrink-0 md:sticky md:top-24">

                    <!-- Back -->
                    <!-- ── Header: Back & Edit Button ── -->
                    <div class="flex items-center justify-between mb-6 md:mb-8">
                        <!-- Back Link -->
                        <a href="javascript:history.back()" aria-label="back"
                            class="flex items-center gap-2 text-sm text-gray-700 hover:text-gray-900 transition-colors duration-200"
                            style="font-weight: 300; letter-spacing: 0.05em;">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M10 3L5 8l5 5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            Back
                        </a>

                        <!-- Edit Button (Only for Admin) -->
                        @auth
                            <a href="{{ route('content.edit', ['type' => $item->type, 'id' => $item->id]) }}"
                                class="flex items-center gap-1.5 px-3 py-1.5 bg-black text-white text-sm uppercase tracking-widest rounded shadow-sm hover:bg-gray-800 transition-all duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Edit Content
                            </a>
                        @endauth
                    </div>


                    <!-- Title -->
                    <h1 class="font-light text-gray-900 mb-4" style="font-family: 'Cormorant Garamond', serif;
                               font-size: clamp(24px, 4vw, 52px);
                               font-weight: 300; line-height: 1.2;">
                        {{ $item->title }}
                    </h1>

                    <!-- Type + Date -->
                    <p class="text-sm text-gray-700 mb-6 leading-relaxed" style="font-weight: 300;">
                        {{ ucfirst($type) }}
                        @if ($date)
                            <span class="opacity-50 mx-1">|</span> {{ $date }}
                        @endif
                        @if ($endDate)
                            <span class="opacity-50 mx-1">—</span> {{ $endDate }}
                        @endif
                    </p>

                    @if ($type === 'events' && $item->location)
                        <p class="text-sm text-gray-700 mb-4 flex items-center gap-2" style="font-weight: 300;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.8">
                                <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0118 0z" />
                                <circle cx="12" cy="10" r="3" />
                            </svg>
                            {{ $item->location }}
                        </p>
                    @endif

                    @if ($type === 'news' && $item->short)
                        <p class="text-xs text-gray-600 mb-6" style="letter-spacing: 0.08em;">
                            {{ $item->short }} min read
                        </p>
                    @endif

                    <!-- Share -->
                    <div class="mt-2">
                        <p class="text-xs text-gray-600 mb-3 tracking-widest uppercase">Share</p>
                        <div class="flex items-center gap-3">

                            {{-- Facebook --}}
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                                aria-label="Share on Facebook" target="_blank" rel="noopener"
                                class="w-9 h-9 rounded-full border border-gray-300 flex items-center justify-center hover:border-blue-600 hover:bg-blue-600 transition-all duration-300 group">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-600 group-hover:text-white"
                                    fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z" />
                                </svg>
                            </a>

                            {{-- Twitter / X --}}
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($item->title ?? '') }}"
                                aria-label="Share on X (Twitter)" target="_blank" rel="noopener"
                                class="w-9 h-9 rounded-full border border-gray-300 flex items-center justify-center hover:border-black hover:bg-black transition-all duration-300 group">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-600 group-hover:text-white"
                                    fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                                </svg>
                            </a>

                        </div>
                    </div>

                </div>

                <!-- ── Right: Content ── -->
                <div class="flex-1 min-w-0">

                    {{-- Thumbnail --}}
                    @if ($item->img_path)
                        <div class="w-full overflow-hidden mb-8 md:mb-10 " style="height: clamp(220px, 40vw, 500px);">
                            <img src="{{ asset($item->img_path) }}" alt="{{ $item->title }}"
                                class="h-full object-contain object-left"
                                onerror="this.parentElement.style.background='#d6cfc5'; this.style.display='none';" />
                        </div>
                    @endif

                    {{-- Body --}}
                    @if ($canSeeBody)
                        <div class="prose prose-sm max-w-none text-gray-700 leading-loose mb-8 {{ $isAdmin && ($extra['status_body'] ?? '1') == '0' ? 'border-2 border-dashed border-red-300 p-3' : '' }}"
                            style="font-size: clamp(14px, 1.2vw, 16px); font-weight: 300; line-height: 2;">
                            @if ($isAdmin && ($extra['status_body'] ?? '1') == '0')
                                <div class="text-xs text-red-500 font-semibold mb-1 uppercase"></div>
                            @endif
                            {!! $item->body !!}
                        </div>
                    @endif

                    {{-- Body 2 --}}
                    @if ($canSeeBody2)
                        <div
                            class="prose prose-sm max-w-none text-gray-700 mb-8 {{ $isAdmin && ($extra['status_body_2'] ?? '1') == '0' ? 'border-2 border-dashed border-red-300 p-3' : '' }}">
                            @if ($isAdmin && ($extra['status_body_2'] ?? '1') == '0')
                                <div class="text-xs text-red-500 font-bold mb-1 uppercase"></div>
                            @endif
                            {!! $item->body_2 !!}
                        </div>
                    @endif

                    {{-- Body 3 (events only) --}}
                    @if ($canSeeBody3)
                        <div
                            class="prose prose-sm max-w-none text-gray-700 mb-8 {{ $isAdmin && ($extra['status_body_3'] ?? '1') == '0' ? 'border-2 border-dashed border-red-300 p-3' : '' }}">
                            @if ($isAdmin && ($extra['status_body_3'] ?? '1') == '0')
                                <div class="text-xs text-red-500 font-bold mb-1 uppercase"></div>
                            @endif
                            {!! $item->body_3 !!}
                        </div>
                    @endif

                    {{-- Event Photos --}}
                    @if ($type === 'events' && count($imgPaths) > 0)
                        <div class="mt-8 md:mt-10">
                            <p class="text-sm font-light text-gray-700 mb-4 tracking-widest uppercase">Photos</p>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-2 md:gap-3">
                                @foreach ($imgPaths as $img)
                                    {{-- এখানে href এবং glightbox ক্লাস যোগ করা হয়েছে --}}
                                    <a href="{{ asset($img) }}" class="glightbox block overflow-hidden rounded-lg shadow-sm"
                                        style="height: clamp(140px, 18vw, 200px);">
                                        <img src="{{ asset($img) }}" alt="Event photo"
                                            class="w-full h-full object-cover hover:scale-110 transition-transform duration-700 cursor-zoom-in"
                                            onerror="this.parentElement.style.background='#c8c0b8'; this.style.display='none';" />
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Map (events only) --}}
                    @if ($type === 'events' && $item->short)
                        <div class="mt-8 md:mt-10" style="height: clamp(220px, 35vw, 300px);">
                            <iframe src="{{ $item->short }}" class="w-full h-full border-0" allowfullscreen loading="lazy">
                            </iframe>
                        </div>
                    @endif

                    {{-- Related --}}
                    @if ($related->isNotEmpty())
                        <div class="mt-12 md:mt-16 pt-8 md:pt-10" style="border-top: 1px solid #c8c0b4;">
                            <p class="text-sm font-light text-gray-700 mb-6 md:mb-8 tracking-widest uppercase">
                                More {{ ucfirst($type) }}
                            </p>
                            <div class="flex flex-col gap-0">
                                @foreach ($related as $rel)
                                    @php
                                        $relSlug = $rel->name ?? $rel->id;
                                        $relPath =
                                            $rel->type === 'events' || $rel->type === 'event' ? 'event' : 'news';
                                     @endphp
                                    <a href="{{ url("/{$relPath}/{$relSlug}") }}" aria-label="related news" class="flex flex-col sm:flex-row gap-2 sm:gap-8 items-start py-4 md:py-5
                                               hover:bg-white/60 px-3 -mx-3 transition-colors duration-200"
                                        style="border-bottom: 1px solid #c8c0b4; text-decoration: none;">
                                        <div class="w-full sm:w-32 flex-shrink-0">
                                            <p class="text-xs sm:text-sm text-gray-500 font-light">
                                                {{ $rel->start_date ? \Carbon\Carbon::parse($rel->start_date)->format('d F Y') : '' }}
                                            </p>
                                        </div>
                                        <p class="text-gray-900 font-light" style="font-size: clamp(14px, 1.2vw, 18px);">
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
@push('scripts')
<script>
    (function() {
        function trackEvent() {
            if (typeof fbq === 'function') {
                fbq('track', 'ViewContent', {
                    content_name: '{{ $item->title }}',
                    content_category: 'Event',
                    content_type: 'event',
                    content_ids: ['{{ $item->id }}']
                });
            } else {
                setTimeout(trackEvent, 500);
            }
        }
        trackEvent();
    })();
</script>
@endpush
