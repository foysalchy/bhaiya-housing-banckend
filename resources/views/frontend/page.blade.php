@extends('layouts.front')
@section('meta')
    @include('partials.meta', [
        'pageKey' => 'pages',
        'title' => $page->meta_title ?? $page->title,
        'description' => $page->meta_description,
        'keywords' => $page->meta_keywords,
        'image' => asset($page->img_path),
    ])
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
                    <a href="{{ url('/') }}" aria-label="back url"
                        class="inline-block px-8 py-2.5 border border-gray-700 text-sm font-light text-gray-700 tracking-wide transition-all duration-300 hover:bg-gray-900 hover:text-white">
                        Back to Home
                    </a>
                </div>
            </div>

        </div>



    </section>
    <div class="cursor-dot" id="cursor-dot"></div>
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
