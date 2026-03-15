@extends('layouts.front')

@section('title', 'News And Gallery')

@section('content')

{{-- HERO --}}
<section class="relative flex items-center justify-start border-b-2 gradient-x-border overflow-hidden transition-all duration-[3000ms] ease-in-out h-[300px] md:h-[400px]">
    <img class="absolute inset-0 w-full h-full object-cover" alt="News And Gallery"
        src="{{ $hero && $hero->img_path ? asset('/') . $hero->img_path : asset('frontend/images/invest-hero.webp') }}">
    <div class="absolute inset-0 bg-black/60"></div>
    <div class="relative text-white px-4">
        <h1 class="lg:whitespace-nowrap font-medium mb-2 lg:mb-0 lg:text-7xl text-5xl transition-all duration-[3000ms]">
            {{ $hero->title ?? ' News And Galler' }} y
        </h1>
        <p class="text-sm md:text-xl transition-all delay-200 duration-[4000ms] opacity-100">{{ $hero->short ?? 'Stay updated with our latest milestones and visuals' }}</p>
    </div>
</section>

{{-- NEWS SECTION --}}
<section class="lg:py-32 py-20 lg:px-28 px-4 overflow-hidden">
    <div class="lg:text-center lg:mb-20 mb-12">
        <h2 class="md:text-6xl text-4xl text-slate-950 font-medium mb-2">
            {{ $newsSection->title ?? 'Latest News & Articles' }}
        </h2>
        <p class="lg:text-xl text-slate-600">
            {{ $newsSection->short ?? 'Bringing you updates on Hospital & Medical Care' }}
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:gap-20 gap-10">
        @foreach($newsList as $index => $news)
        @php $isOdd = $index % 2 !== 0; @endphp
        <div data-aos="{{ $isOdd ? 'fade-left' : 'fade-right' }}" data-aos-offset="100"
            class="overflow-hidden {{ $isOdd ? 'md:mt-[100px]' : 'mt-0' }} aos-init">

            <div class="rounded-2xl overflow-hidden relative group/newsOverlay">
                <a href="#"
                    class="absolute inset-0 flex justify-center items-center bg-black/30 backdrop-blur-xl opacity-0 group-hover/newsOverlay:opacity-100 group-focus/newsOverlay:opacity-100 group-active/newsOverlay:opacity-100 focus:outline-none transition-all duration-500 ease">
                    <p class="text-white text-xl flex items-center gap-1">Read More
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M13 11l8.2-8.2M22 6.8V2h-4.8M2 12.99V15c0 5 2 7 7 7h6c5 0 7-2 7-7v-2M11 2H9C4 2 2 4 2 9"></path>
                        </svg>
                    </p>
                </a>
                @if($news->img_path)
                <img alt="{{ $news->title }}" class="w-full object-cover"
                    src="{{ asset('/') }}{{ $news->img_path }}">
                @endif
            </div>

            <div class="pt-4">
                <p class="text-sm text-slate-600 mb-4">
                    {{ $news->start_date ? \Carbon\Carbon::parse($news->start_date)->format('d-m-Y') : $news->created_at->format('d-m-Y') }}
                    @if($news->short) • {{ $news->short }} min read @endif
                </p>
                <a class="text-2xl text-slate-900 hover:text-brand-primary focus:text-brand-primary transition-colors duration-300"
                    href="#">
                    {{ $news->title }}
                </a>
            </div>
        </div>
        @endforeach
    </div>
</section>

{{-- GALLERY SECTION --}}
<section class="lg:py-32 max-lg:pb-20 mt-16">
    <div>
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 lg:mb-20 md:mb-0 mb-4">
            <div class="lg:pl-40 md:pl-10 pl-4">
                <h2 class="md:text-6xl text-4xl text-slate-950 font-medium mb-2">
                    {{ $gallerySection->title ?? 'Gallery' }}
                </h2>
                <p class="lg:text-xl text-slate-600">
                    {{ $gallerySection->short ?? 'A Visual Glimpse of Your Investment' }}
                </p>
                <div class="flex gap-3 mt-4 bg-slate-900 w-fit p-1 rounded-full">
                    <button id="photos-btn"
                        class="px-4 py-1 text-xl rounded-full border transition-all duration-300 cursor-pointer bg-brand-accent text-white border-0">Photos</button>
                    <button id="videos-btn"
                        class="px-4 py-1 text-xl rounded-full border transition-all duration-300 cursor-pointer text-white bg-transparent border-0">Videos</button>
                </div>
            </div>
            <div class="hidden md:flex gap-3 lg:pr-40 md:pr-10">
                <button class="custom-swiper-prev border border-slate-500 bg-slate-100 p-2 rounded-full hover:bg-slate-200 transition cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="1.5" d="M9.57 5.93L3.5 12l6.07 6.07M12.82 12H3.5M20.33 12h-3.48"></path>
                    </svg>
                </button>
                <button class="custom-swiper-next border border-slate-500 bg-slate-100 p-2 rounded-full hover:bg-slate-200 transition cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="1.5" d="M14.43 5.93L20.5 12l-6.07 6.07M11.01 12h9.32M3.5 12h3.47"></path>
                    </svg>
                </button>
            </div>
        </div>

        <div class="relative md:ml-10 max-md:px-2 mt-8">

            {{-- PHOTOS SWIPER --}}
            <div id="photos-gallery" class="swiper overflow-hidden">
                <div class="swiper-wrapper">
                    @forelse($galleryPhotos as $photo)
                    <div class="swiper-slide">
                        <div class="flex items-center justify-center h-[500px]">
                            <img alt="{{ $photo->title ?? 'Gallery Photo' }}"
                                class="max-h-[500px] w-auto object-contain rounded-xl mx-auto"
                                src="{{ asset('/') }}{{ $photo->img_path }}">
                        </div>
                    </div>
                    @empty
                    <div class="swiper-slide">
                        <div class="flex items-center justify-center h-[500px] text-slate-400">No photos available</div>
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- VIDEOS SWIPER --}}
            <div id="videos-gallery" class="hidden swiper overflow-hidden">
                <div class="swiper-wrapper">
                    @forelse($galleryVideos as $video)
                    <div class="swiper-slide">
                        <div class="flex items-center justify-center h-[500px]">
                            <video controls class="max-h-[500px] w-auto object-contain rounded-xl mx-auto">
                                <source src="{{ asset('/') }}{{ $video->video_path }}" type="video/webm">
                                <source src="{{ asset('/') }}{{ $video->video_path }}" type="video/mp4">
                            </video>
                        </div>
                    </div>
                    @empty
                    <div class="swiper-slide">
                        <div class="flex items-center justify-center h-[500px] text-slate-400">No videos available</div>
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- Mobile Buttons --}}
            <div class="flex md:hidden justify-center gap-4 mt-6">
                <button class="custom-swiper-prev border border-slate-500 bg-slate-100 p-2 rounded-full hover:bg-slate-200 transition cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="1.5" d="M9.57 5.93L3.5 12l6.07 6.07M12.82 12H3.5M20.33 12h-3.48"></path>
                    </svg>
                </button>
                <button class="custom-swiper-next border border-slate-500 bg-slate-100 p-2 rounded-full hover:bg-slate-200 transition cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="1.5" d="M14.43 5.93L20.5 12l-6.07 6.07M11.01 12h9.32M3.5 12h3.47"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const photosBtn = document.getElementById('photos-btn');
        const videosBtn = document.getElementById('videos-btn');
        const photosGallery = document.getElementById('photos-gallery');
        const videosGallery = document.getElementById('videos-gallery');

        // Grab exact bg color of active btn on load
        const activeStyle = window.getComputedStyle(photosBtn).backgroundColor;

        const swiperConfig = {
            slidesPerView: 1,
            spaceBetween: 20,
            breakpoints: {
                640: {
                    slidesPerView: 2
                },
                1024: {
                    slidesPerView: 3
                },
            }
        };

        const photosSwiper = new Swiper('#photos-gallery', swiperConfig);
        let videosSwiper = null;
        let currentSwiper = photosSwiper;

        document.querySelectorAll('.custom-swiper-prev').forEach(btn => {
            btn.addEventListener('click', () => currentSwiper.slidePrev());
        });
        document.querySelectorAll('.custom-swiper-next').forEach(btn => {
            btn.addEventListener('click', () => currentSwiper.slideNext());
        });

        function setActive(activeBtn, inactiveBtn) {
            activeBtn.style.backgroundColor = activeStyle;
            inactiveBtn.style.backgroundColor = 'transparent';
        }

        function showPhotos() {
            photosGallery.style.display = 'block';
            videosGallery.style.display = 'none';
            videosGallery.querySelectorAll('video').forEach(v => v.pause());
            setActive(photosBtn, videosBtn);
            currentSwiper = photosSwiper;
            photosSwiper.update();
        }

        function showVideos() {
            videosGallery.style.display = 'block';
            photosGallery.style.display = 'none';
            setActive(videosBtn, photosBtn);
            setTimeout(function() {
                if (!videosSwiper) {
                    videosSwiper = new Swiper('#videos-gallery', swiperConfig);
                } else {
                    videosSwiper.update();
                }
                currentSwiper = videosSwiper;
            }, 50);
        }

        photosBtn.addEventListener('click', showPhotos);
        videosBtn.addEventListener('click', showVideos);

        // Default: show photos
        showPhotos();
    });
</script>
@endpush