@extends('layouts.front')

@section('title', 'Other Projects')

@section('content')

{{-- HERO --}}
<section class="relative flex items-center justify-start border-b-2 gradient-x-border overflow-hidden h-[300px] md:h-[400px]">
    <img class="absolute inset-0 w-full h-full object-cover" alt="Other Projects"
        src="{{ $hero && $hero->img_path ? asset('/') . $hero->img_path : asset('frontend/images/project_bg.webp') }}">
    <div class="absolute inset-0 bg-black/60"></div>
    <div class="relative text-white px-4">
        <h1 class="lg:whitespace-nowrap font-medium mb-2 lg:mb-0 lg:text-7xl text-5xl">  {{ $hero->title ?? 'Other Projects' }}</h1>
        <p class="text-sm md:text-xl opacity-100"> {{ $hero->short ?? 'Checkout our other Incredible projects' }}</p>
    </div>
</section>

{{-- COMPANY INFO --}}
<section>
    <div class="container mx-auto lg:py-32 py-20 xl:px-0 px-4">
        <div class="flex md:flex-row flex-col items-center lg:gap-20 gap-6">
            <div class="basis-1/2 flex flex-col justify-center items-center">
                @if($companyInfo && $companyInfo->img_path)
                <img alt="Company Logo" src="{{ asset('/') }}{{ $companyInfo->img_path }}">
                @else
                <img alt="Intro Logo" src="{{ asset('frontend/images/logo.svg') }}">
                @endif
                <p class="font-medium text-[2.5rem] text-slate-950">Bhaiya Group</p>
                <h6 class="text-slate-950 tracking-widest font-medium">Since 1972</h6>
            </div>
            <div class="basis-1/2">
                <p class="lg:text-xl text-slate-600">
                    {{ $companyInfo->short ?? '' }}
                </p>
            </div>
        </div>
    </div>
</section>

{{-- INCREDIBLE PROJECTS --}}
<section>
    <div class="container mx-auto lg:pt-32 lg:pb-32 pb-20 xl:px-0 px-4">
        <div class="lg:mb-20 mb-12">
            <h2 class="md:text-6xl text-4xl text-slate-950 font-medium mb-2">Some of Our Incredible Projects</h2>
            <p class="lg:text-xl text-slate-600">Discover Bhaiya Group's Visionary Ventures in Real Estate, Hospitality, and Beyond</p>
        </div>

        <div class="flex flex-col lg:gap-20 gap-12">
         @foreach($incredibleProjects as $index => $project)
    @php $isEven = $index % 2 !== 0; @endphp

    <div class="flex lg:flex-row flex-col lg:gap-16 gap-8">

        {{-- IMAGE --}}
        @if($isEven)
            {{-- Even: image RIGHT --}}
            <div class="basis-5/12">
                <h2 class="md:text-6xl text-4xl text-slate-950 font-medium lg:mb-8 mb-4">{{ $project->title }}</h2>
                <div class="lg:text-xl text-slate-600 mb-6">{!! $project->body !!}</div>
                <div class="w-fit mt-8">
                    <a class="group relative flex items-center cursor-pointer rounded-full bg-brand-accent py-[15px] pr-6 pl-16 transition-all duration-500 hover:bg-slate-900"
                        href="{{ route('getintouch') }}">
                        <span class="absolute left-1 bg-white text-slate-900 p-1.5 rounded-full transition-all duration-500 z-20
                            group-hover:left-[77%] group-hover:bg-brand-accent group-hover:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="1.5" d="M14.43 5.93L20.5 12l-6.07 6.07M11.01 12h9.32M3.5 12h3.47"></path>
                            </svg>
                        </span>
                        <h6 class="text-[16px] leading-[14px] text-white whitespace-nowrap transition-all duration-500 z-10
                            group-hover:-translate-x-[60%] group-hover:text-brand-accent">Contact Us</h6>
                    </a>
                </div>
            </div>
            <div class="basis-7/12 rounded-[20px] overflow-hidden">
                @if($project->img_path)
                    <img alt="{{ $project->title }}" loading="lazy" class="w-full h-full object-cover"
                        src="{{ asset('/') }}{{ $project->img_path }}">
                @endif
            </div>
        @else
            {{-- Odd: image LEFT --}}
            <div class="basis-7/12 rounded-[20px] overflow-hidden">
                @if($project->img_path)
                    <img alt="{{ $project->title }}" loading="lazy" class="w-full h-full object-cover"
                        src="{{ asset('/') }}{{ $project->img_path }}">
                @endif
            </div>
            <div class="basis-5/12">
                <h2 class="md:text-6xl text-4xl text-slate-950 font-medium lg:mb-8 mb-4">{{ $project->title }}</h2>
                <div class="lg:text-xl text-slate-600 mb-6">{!! $project->body !!}</div>
                <div class="w-fit mt-8">
                    <a class="group relative flex items-center cursor-pointer rounded-full bg-brand-accent py-[15px] pr-6 pl-16 transition-all duration-500 hover:bg-slate-900"
                        href="{{ route('getintouch') }}">
                        <span class="absolute left-1 bg-white text-slate-900 p-1.5 rounded-full transition-all duration-500 z-20
                            group-hover:left-[77%] group-hover:bg-brand-accent group-hover:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="1.5" d="M14.43 5.93L20.5 12l-6.07 6.07M11.01 12h9.32M3.5 12h3.47"></path>
                            </svg>
                        </span>
                        <h6 class="text-[16px] leading-[14px] text-white whitespace-nowrap transition-all duration-500 z-10
                            group-hover:-translate-x-[60%] group-hover:text-brand-accent">Contact Us</h6>
                    </a>
                </div>
            </div>
        @endif

    </div>
@endforeach
        </div>
    </div>
</section>

{{-- OTHER PROJECTS SLIDER --}}
<section>
    <div class="lg:pt-32 lg:pb-32">
        <div class="md:text-center px-4 lg:mb-20 mb-10">
            <h2 class="md:text-6xl text-4xl text-slate-950 font-medium mb-2">Our Other Projects</h2>
            <p class="lg:text-xl text-slate-600">Explore our diverse portfolio of initiatives</p>
            <div class="md:mx-auto w-fit mt-6">
                <a class="group relative flex items-center cursor-pointer rounded-full bg-brand-accent py-[15px] pr-6 pl-16 transition-all duration-500 hover:bg-slate-900"
                    href="{{ route('invest') }}#invest-form">
                    <span class="absolute left-1 bg-white text-slate-900 p-1.5 rounded-full transition-all duration-500 z-20
                        group-hover:left-[77%] group-hover:bg-brand-accent group-hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="1.5" d="M14.43 5.93L20.5 12l-6.07 6.07M11.01 12h9.32M3.5 12h3.47"></path>
                        </svg>
                    </span>
                    <h6 class="text-[16px] leading-[14px] text-white whitespace-nowrap transition-all duration-500 z-10
                        group-hover:-translate-x-[60%] group-hover:text-brand-accent">Invest Now</h6>
                </a>
            </div>
        </div>

        <div class="xl:pl-40 md:pl-20">
            <div class="swiper" id="other-projects-swiper">
                <div class="swiper-wrapper">
                    @foreach($otherProjects as $project)
                    <div class="swiper-slide">
                        <div class="overflow-hidden sm:px-0 px-2">
                            @if($project->img_path)
                            <img alt="{{ $project->title }}" class="w-full h-full object-fit rounded-2xl"
                                src="{{ asset('/') }}{{ $project->img_path }}">
                            @endif
                            <div class="lg:px-8 pt-8 text-center">
                                <h2 class="text-2xl font-medium uppercase mb-2">{{ $project->title }}</h2>
                                <p class="mb-14 text-slate-600 md:px-12">{{ $project->short }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="flex flex-row justify-center items-center gap-6 mt-6">
            <button id="projects-prev" class="border border-slate-500 bg-slate-100 p-2 rounded-full hover:bg-slate-200 transition cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="1.5" d="M9.57 5.93L3.5 12l6.07 6.07M12.82 12H3.5M20.33 12h-3.48"></path>
                </svg>
            </button>
            <button id="projects-next" class="border border-slate-500 bg-slate-100 p-2 rounded-full hover:bg-slate-200 transition cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="1.5" d="M14.43 5.93L20.5 12l-6.07 6.07M11.01 12h9.32M3.5 12h3.47"></path>
                </svg>
            </button>
        </div>
    </div>
</section>

{{-- CONTACT US --}}
<section>
    <div class="container mx-auto px-4 lg:py-32 py-20">
        <div class="flex md:flex-row flex-col lg:gap-20 gap-6 lg:pb-32 pb-0">
            <div class="basis-1/2">
                <h2 class="md:text-6xl text-4xl text-slate-950 font-medium lg:mb-8 mb-4">Contact Us</h2>
                <p class="lg:text-xl text-slate-600 mb-6">Connect with Right Aid Hospital to explore lucrative investment opportunities.</p>
            </div>
            <div class="basis-1/2">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

                    {{-- Corporate + Hospital Address --}}
                    <div data-aos="fade-in" data-aos-delay="0" data-aos-offset="100">
                        <div class="p-2 bg-brand-primary/10 border-brand-primary/40 border-2 rounded-lg w-fit">
                            <svg class="text-brand-primary" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M15.119 10.311c0 1.72-1.39 3.12-3.12 3.12-1.73 0-3.12-1.39-3.12-3.12 0-1.73 1.4-3.12 3.12-3.12.34 0 .67.05.97.15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M5.98 4.3c4.37-4.11 12.84-2.7 14.4 4.21 1.15 5.08-2.01 9.38-4.78 12.04a5.193 5.193 0 0 1-7.21 0C5.63 17.88 2.46 13.58 3.62 8.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </div>
                        @if($setting && $setting->body_2)
                        <div>
                            <h3 class="text-xl text-slate-900 font-medium my-2">Corporate Office</h3>
                            <p class="text-slate-600">{!! $setting->body_2 !!}</p>
                        </div>
                        @endif
                        @if($setting && $setting->location)
                        <div>
                            <h3 class="text-xl text-slate-900 font-medium my-2">Hospital Address</h3>
                            <p class="text-slate-600">{!! $setting->location !!}</p>
                        </div>
                        @endif
                    </div>

                    {{-- Head Office --}}
                    <div data-aos="fade-in" data-aos-delay="200" data-aos-offset="100">
                        <div class="p-2 bg-brand-primary/10 border-brand-primary/40 border-2 rounded-lg w-fit">
                            <svg class="text-brand-primary" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M15.119 10.311c0 1.72-1.39 3.12-3.12 3.12-1.73 0-3.12-1.39-3.12-3.12 0-1.73 1.4-3.12 3.12-3.12.34 0 .67.05.97.15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M5.98 4.3c4.37-4.11 12.84-2.7 14.4 4.21 1.15 5.08-2.01 9.38-4.78 12.04a5.193 5.193 0 0 1-7.21 0C5.63 17.88 2.46 13.58 3.62 8.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </div>
                        @if($setting && $setting->body)
                        <div>
                            <h3 class="text-xl text-slate-900 font-medium my-2">Head Office</h3>
                            <p class="text-slate-600">{!! $setting->body !!}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="w-full h-[1px] bg-slate-200 my-8"></div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Hotline --}}
                    <div data-aos="fade-in" data-aos-delay="300" data-aos-offset="0">
                        <div class="p-2 bg-brand-primary/10 border-brand-primary/40 border-2 rounded-lg w-fit">
                            <svg class="text-brand-primary" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M9.39 6.01c.18.25.31.48.4.7.09.21.14.42.14.61 0 .24-.07.48-.21.71-.13.23-.32.47-.56.71l-.76.79c-.11.11-.16.24-.16.4 0 .08.01.15.03.23.03.08.06.14.08.2.18.33.49.76.93 1.28.45.52.93 1.05 1.45 1.58.54.53 1.06 1.02 1.59 1.47.52.44.95.74 1.29.92.05.02.11.05.18.08.08.03.16.04.25.04.17 0 .3-.06.41-.17l.76-.75c.25-.25.49-.44.72-.56.23-.14.46-.21.71-.21.19 0 .39.04.61.13.22.09.45.22.7.39l3.31 2.35c.26.18.44.39.55.64.1.25.16.5.16.78 0 .36-.08.73-.25 1.09-.17.36-.39.7-.68 1.02-.49.54-1.03.93-1.64 1.18-.6.25-1.25.38-1.95.38-1.02 0-2.11-.24-3.26-.73s-2.3-1.15-3.44-1.98a28.75 28.75 0 0 1-3.28-2.8 28.414 28.414 0 0 1-2.79-3.27c-.82-1.14-1.48-2.28-1.96-3.41C2.24 8.67 2 7.58 2 6.54c0-.68.12-1.33.36-1.93.24-.61.62-1.17 1.15-1.67C4.15 2.31 4.85 2 5.59 2c.28 0 .56.06.81.18.26.12.49.3.67.56" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </div>
                        @if($setting && $setting->extra)
                        <div>
                            <h3 class="text-xl text-slate-900 font-medium my-2">Hotline Number</h3>
                            <p class="text-slate-600">{{ $setting->extra }}</p>
                        </div>
                        @endif
                    </div>

                    {{-- Email --}}
                    <div data-aos="fade-in" data-aos-delay="301" data-aos-offset="0">
                        <div class="p-2 bg-brand-primary/10 border-brand-primary/40 border-2 rounded-lg w-fit">
                            <svg class="text-brand-primary" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M22 12.98v2.52c0 3.5-2 5-5 5H7c-3 0-5-1.5-5-5v-7c0-3.5 2-5 5-5h10c3 0 5 1.5 5 5" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="m17 9-3.13 2.5c-1.03.82-2.72.82-3.75 0L7 9" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </div>
                        @if($setting && $setting->short)
                        <div>
                            <h3 class="text-xl text-slate-900 font-medium my-2">Email</h3>
                            <a href="mailto:{{ $setting->short }}" class="text-slate-600 hover:text-brand-primary transition-colors duration-300">
                                {{ $setting->short }}
                            </a>
                        </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
   const swiper = new Swiper('#other-projects-swiper', {
    slidesPerView: 1.2,
    spaceBetween: 30,
    loop: true,          
    autoplay: {
        delay: 3000,     
        disableOnInteraction: false, 
    },
    breakpoints: {
        640:  { slidesPerView: 1.5 },
        1024: { slidesPerView: 2.2 },
        1280: { slidesPerView: 2.5 },
    },
    navigation: {
        nextEl: '#projects-next',
        prevEl: '#projects-prev',
    },
});
</script>
@endpush