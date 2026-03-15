<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Right Aid Hospital</title>

  <!-- AOS -->
  <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css" />
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />

  <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}"> 
  
  <!-- Swiper CSS -->
<link
  rel="stylesheet"href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css"/>

<style>
  /* Hero Section Pagination */
  .heroSwiper .swiper-pagination-bullet {
    width: 100px !important; height: 2px !important;
    border-radius: 99px !important;
    background: rgba(255,255,255,0.5) !important;
    opacity: 1 !important; transition: all 0.3s ease;
  }
  .heroSwiper .swiper-pagination-bullet-active {
    background: #fff !important; width: 80px !important;
  }

  /* Testimonial Section Pagination (Fixed Width issue) */
  .testi-pagination {
    width: fit-content !important;
    position: relative !important;
  }
  .testi-pagination .swiper-pagination-bullet {
    width: 24px !important;
    height: 2px !important;
    background: rgba(255, 255, 255, 0.3) !important;
    border-radius: 99px !important;
    opacity: 1 !important;
    margin: 0 !important; 
    transition: all 0.2s ease;
  }
  .testi-pagination .swiper-pagination-bullet-active {
    background: #ffffff !important;
    width: 40px !important;
  }
</style>

</head>

<body class="geist_2ae47f08-module__h69qWW__variable geist_mono_eb58308d-module__w_p2Lq__variable antialiased"
    data-aos-easing="ease-in-out" data-aos-duration="700" data-aos-delay="0" cz-shortcut-listen="true">
    <div hidden=""></div>

<header class="w-full relative top-0 z-50 bg-white border-brand-tertiary border-b-2">
    <div class="flex items-center justify-between">

        {{-- Logo --}}
        <div class="flex lg:justify-center items-center lg:w-1/6 w-full">
            <a class="w-40 p-2 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-primary rounded-lg" href="{{ route('front.home') }}" aria-label="Right Aid Hospital Home">
                <img src="{{ asset('frontend/images/nav_logo.svg') }}" alt="Right Aid Hospital Logo" class="w-full h-auto">
            </a>
        </div>

        {{-- Desktop Nav --}}
        <div class="hidden 2xl:flex items-center justify-center w-4/6 border-x-2 border-brand-tertiary py-4">
            <nav class="flex items-center justify-between" aria-label="Main Navigation">

                {{-- Home --}}
                <a class="group px-5 font-clashDisplay focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-primary rounded-lg" href="{{ route('front.home') }}">
                    <span class="{{ request()->routeIs('front.home')
                        ? 'text-brand-primary bg-slate-900 px-2.5 pt-1 pb-1.5 rounded-[4px] font-semibold'
                        : 'text-slate-950 group-hover:text-brand-primary group-focus:text-brand-primary font-medium' }} transition-colors duration-200">
                        Home
                    </span>
                </a>

                {{-- Facilities --}}
                <a class="group px-5 font-clashDisplay focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-primary rounded-lg" href="{{ route('facilities') }}">
                    <span class="{{ request()->routeIs('facilities')
                        ? 'text-brand-primary bg-slate-900 px-2.5 pt-1 pb-1.5 rounded-[4px] font-semibold'
                        : 'text-slate-950 group-hover:text-brand-primary group-focus:text-brand-primary font-medium' }} transition-colors duration-200">
                        Facilities
                    </span>
                </a>

                {{-- Invest --}}
                <a class="group px-5 font-clashDisplay focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-primary rounded-lg" href="{{ route('invest') }}">
                    <span class="{{ request()->routeIs('invest')
                        ? 'text-brand-primary bg-slate-900 px-2.5 pt-1 pb-1.5 rounded-[4px] font-semibold'
                        : 'text-slate-950 group-hover:text-brand-primary group-focus:text-brand-primary font-medium' }} transition-colors duration-200">
                        Invest
                    </span>
                </a>

                {{-- About Us --}}
                <a class="group px-5 font-clashDisplay focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-primary rounded-lg" href="{{ route('about') }}">
                    <span class="{{ request()->routeIs('about')
                        ? 'text-brand-primary bg-slate-900 px-2.5 pt-1 pb-1.5 rounded-[4px] font-semibold'
                        : 'text-slate-950 group-hover:text-brand-primary group-focus:text-brand-primary font-medium' }} transition-colors duration-200">
                        About Us
                    </span>
                </a>

                {{-- News & Gallery --}}
                <a class="group px-5 font-clashDisplay focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-primary rounded-lg" href="{{ route('newsandgallery') }}">
                    <span class="{{ request()->routeIs('newsandgallery')
                        ? 'text-brand-primary bg-slate-900 px-2.5 pt-1 pb-1.5 rounded-[4px] font-semibold'
                        : 'text-slate-950 group-hover:text-brand-primary group-focus:text-brand-primary font-medium' }} transition-colors duration-200">
                        News &amp; Gallery
                    </span>
                </a>

                {{-- Get in Touch --}}
                <a class="group px-5 font-clashDisplay focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-primary rounded-lg" href="{{ route('getintouch') }}">
                    <span class="{{ request()->routeIs('getintouch')
                        ? 'text-brand-primary bg-slate-900 px-2.5 pt-1 pb-1.5 rounded-[4px] font-semibold'
                        : 'text-slate-950 group-hover:text-brand-primary group-focus:text-brand-primary font-medium' }} transition-colors duration-200">
                        Get in Touch
                    </span>
                </a>

                {{-- Other Projects --}}
                <a class="group px-5 font-clashDisplay focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-primary rounded-lg" href="{{ route('projects') }}">
                    <span class="{{ request()->routeIs('projects')
                        ? 'text-brand-primary bg-slate-900 px-2.5 pt-1 pb-1.5 rounded-[4px] font-semibold'
                        : 'text-slate-950 group-hover:text-brand-primary group-focus:text-brand-primary font-medium' }} transition-colors duration-200">
                        Other Projects
                    </span>
                </a>

            </nav>

            {{-- Book Appointment Button --}}
            <div class="hidden lg:flex items-center gap-4">
                <a class="relative px-4 py-2 rounded-lg font-medium bg-[linear-gradient(90deg,#0088CD_0%,#A855F7_100%)] text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-primary focus-visible:ring-offset-2"
                    href="{{ route('appointment') }}">
                    <!-- Changed from h6 to span.block -->
                    <span class="block font-semibold">Book Appointment</span>
                </a>
            </div>
        </div>

        {{-- Right Side: Invest Now + Mobile Menu --}}
        <div class="flex items-center 2xl:justify-center justify-end gap-3 w-1/6 2xl:pr-0 pr-4">

            {{-- Invest Now (Desktop) --}}
            <div class="hidden 2xl:flex">
                <a class="group relative flex items-center cursor-pointer rounded-full focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-primary focus-visible:ring-offset-2 bg-brand-accent py-[15px] pr-6 pl-16 transition-all duration-500 hover:bg-slate-900 focus:bg-slate-900"
                    href="{{ route('invest') }}#invest-form" aria-label="Invest Now">
                    <span class="absolute left-1 bg-white text-slate-900 p-1.5 rounded-full transition-all duration-500 z-20
                        group-hover:left-[77%] group-focus:left-[77%]
                        group-hover:bg-brand-accent group-focus:bg-brand-accent
                        group-hover:text-white group-focus:text-white" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" aria-hidden="true" focusable="false">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-miterlimit="10" stroke-width="1.5"
                                d="M14.43 5.93L20.5 12l-6.07 6.07M11.01 12h9.32M3.5 12h3.47"></path>
                        </svg>
                    </span>
                    <!-- Changed from h6 to span.block and added font-semibold for contrast -->
                    <span class="block text-[16px] leading-[14px] font-semibold text-white whitespace-nowrap transition-all duration-500 z-10
                        group-hover:-translate-x-[60%] group-focus:-translate-x-[60%]
                        group-hover:text-brand-accent group-focus:text-brand-accent">
                        Invest Now
                    </span>
                </a>
            </div>

            {{-- Mobile Hamburger --}}
            <div class="2xl:hidden">
                <button aria-label="Toggle navigation menu" aria-controls="mobileMenu" aria-expanded="false" class="p-2 cursor-pointer focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-primary rounded-lg"
                    onclick="const menu = document.getElementById('mobileMenu'); menu.classList.toggle('hidden'); this.setAttribute('aria-expanded', !menu.classList.contains('hidden'));">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" aria-hidden="true" focusable="false">
                        <path d="M3 7h18M9.49 12H21M3 12h2.99M3 17h18" stroke="currentColor" stroke-width="1.5"
                            stroke-linecap="round"></path>
                    </svg>
                </button>
            </div>

        </div>
    </div>

    {{-- Mobile Menu --}}
    <div id="mobileMenu" class="hidden 2xl:hidden bg-white border-t-2 border-brand-tertiary px-6 py-6 flex flex-col gap-4">
        <a href="{{ route('front.home') }}"
            class="font-clashDisplay text-lg focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-primary rounded {{ request()->routeIs('home') ? 'text-brand-primary font-semibold' : 'text-slate-950 font-medium' }}">
            Home
        </a>
        <a href="{{ route('facilities') }}"
            class="font-clashDisplay text-lg focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-primary rounded {{ request()->routeIs('facilities') ? 'text-brand-primary font-semibold' : 'text-slate-950 font-medium' }}">
            Facilities
        </a>
        <a href="{{ route('invest') }}"
            class="font-clashDisplay text-lg focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-primary rounded {{ request()->routeIs('invest') ? 'text-brand-primary font-semibold' : 'text-slate-950 font-medium' }}">
            Invest
        </a>
        <a href="{{ route('about') }}"
            class="font-clashDisplay text-lg focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-primary rounded {{ request()->routeIs('about') ? 'text-brand-primary font-semibold' : 'text-slate-950 font-medium' }}">
            About Us
        </a>
        <a href="{{ route('newsandgallery') }}"
            class="font-clashDisplay text-lg focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-primary rounded {{ request()->routeIs('newsandgallery') ? 'text-brand-primary font-semibold' : 'text-slate-950 font-medium' }}">
            News &amp; Gallery
        </a>
        <a href="{{ route('getintouch') }}"
            class="font-clashDisplay text-lg focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-primary rounded {{ request()->routeIs('getintouch') ? 'text-brand-primary font-semibold' : 'text-slate-950 font-medium' }}">
            Get in Touch
        </a>
        <a href="{{ route('projects') }}"
            class="font-clashDisplay text-lg focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-primary rounded {{ request()->routeIs('projects') ? 'text-brand-primary font-semibold' : 'text-slate-950 font-medium' }}">
            Other Projects
        </a>
        <a href="{{ route('appointment') }}"
            class="mt-2 text-center px-4 py-2 rounded-lg font-semibold bg-[linear-gradient(90deg,#0088CD_0%,#A855F7_100%)] text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-primary focus-visible:ring-offset-2">
            Book Appointment
        </a>
        <a href="{{ route('invest') }}#invest-form"
            class="text-center px-4 py-2 rounded-full font-semibold bg-brand-accent text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-primary focus-visible:ring-offset-2">
            Invest Now
        </a>
    </div>

</header>