@extends('layouts.front')
@section('meta')
    @include('partials.meta', ['pageKey' => 'blog'])
@endsection


@section('content')
    <section class="hero-fixed fixed top-0 left-0 w-full overflow-hidden h-[600px] md:h-[700px] lg:h-[900px]"
        style="z-index:1; transform-origin:top center; will-change:transform;">

        <img src="{{ asset('images/event.webp') }}" alt="interior" class="absolute inset-0 w-full h-full object-cover" />

        <div class="absolute inset-0 bg-black/50"></div>

        <div class="absolute inset-0 flex items-center px-6 sm:px-10 md:px-20">
            <h1 class="text-white md:pl-12 pt-20 md:pt-32 font-light tracking-normal md:tracking-[-4px]"
                style="font-size: clamp(32px, 3.85vw, 74px); line-height: 1.2;">
                Explore <span class="font-migra-italic">Our </span>
                Blog
            </h1>
        </div>

    </section>
    <div class="h-[600px] md:h-[700px] lg:h-[900px] w-full pointer-events-none" style="position: relative; z-index: 2;">
    </div>
    <section class="relative z-10 w-full py-10 bg-white overflow-hidden">
        <div class="min-h-screen p-8">
            <div class="container  mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($blogs as $blog)
                        <a href="{{ route('blog.details', $blog->name) }}" aria-label="blog single page route"
                            data-page="blog" style="text-decoration: none;">
                            <div
                                class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300 group cursor-pointer">
                                <div class="relative  overflow-hidden">
                                    <img style="padding:10px;border-radius:15px" src="{{ asset($blog->img_path) }}"
                                        alt="Hotel"
                                        class="w-full h-full object-cover group-hover:scale-95 transition-transform duration-300">
                                </div>
                                <div class="p-6">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-2 leading-tight">
                                        {{ $blog->title }}
                                    </h3>
                                    <p class="text-sm text-gray-400 mb-3">
                                        {{ $blog->created_at ? \Carbon\Carbon::parse($blog->created_at)->format('d M Y') : '' }}
                                    </p>
                                    <p class="text-gray-600 text-sm mb-4">
                                        {{ $blog->short }}
                                    </p>
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs text-gray-500"></span>
                                        <span
                                            class="px-4 py-2 text-sm font-medium text-white bg-black rounded-md
                     group-hover:bg-gray-800 transition duration-300">
                                            Read More →
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>

                    @empty
                        <div class="col-span-full flex flex-col items-center justify-center py-16 text-center">
                            <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="text-base font-medium text-gray-500">No Blogs Found</p>
                            <p class="text-sm text-gray-400 mt-1">Please check back later for new content</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
    <x-extra-content :data="$content" />
    <div class="cursor-dot" id="cursor-dot"></div>
@endsection
