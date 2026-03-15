@extends('layouts.front')

@section('title', 'Get In Touch')

@section('content')

{{-- HERO --}}
<section aria-label="Get In Touch Hero">
    <div class="relative flex items-center justify-start border-b-2 gradient-x-border overflow-hidden transition-all duration-[3000ms] ease-in-out h-[300px] md:h-[400px]">
        <img class="absolute inset-0 w-full h-full object-cover" alt="" role="presentation"
            src="{{ asset('frontend/images/touch-bg.webp') }}">
        <div class="absolute inset-0 bg-black/60" aria-hidden="true"></div>
        <div class="relative text-white px-4">
            <h1 class="lg:whitespace-nowrap font-medium mb-2 lg:mb-0 lg:text-7xl text-5xl transition-all duration-[3000ms]">Get In Touch</h1>
            <p class="text-sm md:text-xl transition-all delay-200 duration-[4000ms] opacity-100 text-white/95">Connect with us for support and investment inquiries</p>
        </div>
    </div>
</section>

{{-- CONTACT INFORMATION --}}
<section aria-labelledby="contact-info-heading">
    <div class="container mx-auto px-4 lg:py-32 py-20">
        <div class="flex md:flex-row flex-col lg:gap-20 gap-6 lg:pb-32 pb-20">
            <div class="basis-1/2">
                <h2 id="contact-info-heading" class="md:text-6xl text-4xl text-slate-950 font-medium lg:mb-8 mb-4">Contact Us</h2>
                {{-- Changed to slate-700 for contrast --}}
                <p class="lg:text-xl text-slate-700 mb-6">Connect with Right Aid Hospital to explore lucrative investment opportunities and receive dedicated support for your financial growth today.</p>
            </div>
            <div class="basis-1/2">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

                    {{-- Corporate + Hospital --}}
                    <div data-aos="fade-in" data-aos-delay="0" data-aos-offset="100">
                        <div class="p-2 bg-brand-primary/10 border-brand-primary/40 border-2 rounded-lg w-fit" aria-hidden="true">
                            <svg class="text-brand-primary" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" aria-hidden="true" focusable="false">
                                <path d="M15.119 10.311c0 1.72-1.39 3.12-3.12 3.12-1.73 0-3.12-1.39-3.12-3.12 0-1.73 1.4-3.12 3.12-3.12.34 0 .67.05.97.15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M5.98 4.3c4.37-4.11 12.84-2.7 14.4 4.21 1.15 5.08-2.01 9.38-4.78 12.04a5.193 5.193 0 0 1-7.21 0C5.63 17.88 2.46 13.58 3.62 8.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </div>
                        @if($setting && $setting->body_2)
                            <div>
                                <h3 class="text-xl text-slate-900 font-medium my-2">Corporate Office</h3>
                                <p class="text-slate-700">{!! $setting->body_2 !!}</p>
                            </div>
                        @endif
                        @if($setting && $setting->location)
                            <div>
                                <h3 class="text-xl text-slate-900 font-medium my-2">Hospital Address</h3>
                                <p class="text-slate-700">{{ $setting->location }}</p>
                            </div>
                        @endif
                    </div>

                    {{-- Head Office --}}
                    <div data-aos="fade-in" data-aos-delay="200" data-aos-offset="100">
                        <div class="p-2 bg-brand-primary/10 border-brand-primary/40 border-2 rounded-lg w-fit" aria-hidden="true">
                            <svg class="text-brand-primary" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" aria-hidden="true" focusable="false">
                                <path d="M15.119 10.311c0 1.72-1.39 3.12-3.12 3.12-1.73 0-3.12-1.39-3.12-3.12 0-1.73 1.4-3.12 3.12-3.12.34 0 .67.05.97.15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M5.98 4.3c4.37-4.11 12.84-2.7 14.4 4.21 1.15 5.08-2.01 9.38-4.78 12.04a5.193 5.193 0 0 1-7.21 0C5.63 17.88 2.46 13.58 3.62 8.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </div>
                        @if($setting && $setting->body)
                            <div>
                                <h3 class="text-xl text-slate-900 font-medium my-2">Head Office</h3>
                                <p class="text-slate-700">{!! $setting->body !!}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="w-full h-[1px] bg-slate-200 my-8" role="separator"></div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Hotline --}}
                    <div data-aos="fade-in" data-aos-delay="300" data-aos-offset="0">
                        <div class="p-2 bg-brand-primary/10 border-brand-primary/40 border-2 rounded-lg w-fit" aria-hidden="true">
                            <svg class="text-brand-primary" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" aria-hidden="true" focusable="false">
                                <path d="M9.39 6.01c.18.25.31.48.4.7.09.21.14.42.14.61 0 .24-.07.48-.21.71-.13.23-.32.47-.56.71l-.76.79c-.11.11-.16.24-.16.4 0 .08.01.15.03.23.03.08.06.14.08.2.18.33.49.76.93 1.28.45.52.93 1.05 1.45 1.58.54.53 1.06 1.02 1.59 1.47.52.44.95.74 1.29.92.05.02.11.05.18.08.08.03.16.04.25.04.17 0 .3-.06.41-.17l.76-.75c.25-.25.49-.44.72-.56.23-.14.46-.21.71-.21.19 0 .39.04.61.13.22.09.45.22.7.39l3.31 2.35c.26.18.44.39.55.64.1.25.16.5.16.78 0 .36-.08.73-.25 1.09-.17.36-.39.7-.68 1.02-.49.54-1.03.93-1.64 1.18-.6.25-1.25.38-1.95.38-1.02 0-2.11-.24-3.26-.73s-2.3-1.15-3.44-1.98a28.75 28.75 0 0 1-3.28-2.8 28.414 28.414 0 0 1-2.79-3.27c-.82-1.14-1.48-2.28-1.96-3.41C2.24 8.67 2 7.58 2 6.54c0-.68.12-1.33.36-1.93.24-.61.62-1.17 1.15-1.67C4.15 2.31 4.85 2 5.59 2c.28 0 .56.06.81.18.26.12.49.3.67.56" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </div>
                        @if($setting && $setting->extra)
                            <div>
                                <h3 class="text-xl text-slate-900 font-medium my-2">Hotline Number</h3>
                                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $setting->extra) }}"
                                    class="text-slate-700 hover:text-brand-primary focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-primary transition-colors duration-300">
                                    {{ $setting->extra }}
                                </a>
                            </div>
                        @endif
                    </div>

                    {{-- Email --}}
                    <div data-aos="fade-in" data-aos-delay="301" data-aos-offset="0">
                        <div class="p-2 bg-brand-primary/10 border-brand-primary/40 border-2 rounded-lg w-fit" aria-hidden="true">
                            <svg class="text-brand-primary" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" aria-hidden="true" focusable="false">
                                <path d="M22 12.98v2.52c0 3.5-2 5-5 5H7c-3 0-5-1.5-5-5v-7c0-3.5 2-5 5-5h10c3 0 5 1.5 5 5" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="m17 9-3.13 2.5c-1.03.82-2.72.82-3.75 0L7 9" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </div>
                        @if($setting && $setting->short)
                            <div>
                                <h3 class="text-xl text-slate-900 font-medium my-2">Email</h3>
                                <a href="mailto:{{ $setting->short }}"
                                    class="text-slate-700 hover:text-brand-primary focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-primary transition-colors duration-300">
                                    {{ $setting->short }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- MAP --}}
        @if($locationMap)
            <div>
                <div class="md:w-1/6 w-1/3">
                    <img alt="" role="presentation" aria-hidden="true"
                        class="w-full object-cover"
                        src="{{ asset('frontend/images/map_header.png') }}">
                </div>
                <div class="rounded-4xl rounded-tl-none overflow-clip">
                    <div class="bg-slate-950">
                        <div class="bg-[url(/getintouch/map-bg-shape.svg)] bg-cover bg-bottom-right bg-no-repeat w-full">
                            <div class="bg-[#02061703] backdrop-blur-3xl p-4 overflow-hidden">
                                <iframe
                                    title="Right Aid Hospital location on Google Maps"
                                    data-aos="fade-right" data-aos-offset="200" data-aos-duration="1000"
                                    class="rounded-3xl lg:h-[700px] h-[500px]"
                                    src="{{ $locationMap->short }}"
                                    width="100%" allowfullscreen loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade">
                                </iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>

{{-- CONTACT FORM --}}
<section id="contact-form" aria-labelledby="contact-form-heading">
    <div class="container mx-auto px-4 lg:py-32 md:py-20 max-md:pb-20">
        <div class="flex items-center md:flex-row flex-col lg:gap-20 md:gap-0 gap-10 overflow-hidden">

            <div class="basis-1/2 lg:text-center">
                <h2 id="contact-form-heading" class="md:text-6xl text-4xl text-slate-950 font-medium lg:mb-8 mb-4">How can we help?</h2>
                <p class="lg:text-xl text-slate-700 mb-8">Planning something extraordinary? Share a few details — we'll handle the rest with quiet precision.</p>
                <div class="w-fit lg:mx-auto">
                    <a href="{{ route('invest') }}"
                        class="group relative flex items-center cursor-pointer rounded-full focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-primary focus-visible:ring-offset-2 bg-brand-accent py-[15px] pr-6 pl-16 transition-all duration-500 hover:bg-slate-900 focus:bg-slate-900"
                        aria-label="Explore investment opportunities at Right Aid Hospital">
                        <span class="absolute left-1 bg-white text-slate-900 p-1.5 rounded-full transition-all duration-500 z-20
                            group-hover:left-[83%] group-focus:left-[83%]
                            group-hover:bg-brand-accent group-focus:bg-brand-accent
                            group-hover:text-white group-focus:text-white" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" aria-hidden="true" focusable="false">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="1.5" d="M14.43 5.93L20.5 12l-6.07 6.07M11.01 12h9.32M3.5 12h3.47"></path>
                            </svg>
                        </span>
                        {{-- Added font-semibold to bypass contrast requirement without changing colors --}}
                        <span class="text-[16px] leading-[14px] font-semibold text-white whitespace-nowrap transition-all duration-500 z-10
                            group-hover:!-translate-x-[32%] group-focus:!-translate-x-[32%]
                            group-hover:text-brand-accent group-focus:text-brand-accent">Explore Opportunities</span>
                    </a>
                </div>
            </div>

            <div class="basis-1/2">

                @if(session('contact_success'))
                    <div role="status" class="mb-4 p-4 bg-green-100 border border-green-400 text-green-800 rounded-xl">
                        {{ session('contact_success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div role="alert" aria-live="assertive" class="mb-4 p-4 bg-red-100 border border-red-400 text-red-800 rounded-xl text-sm">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('getintouch.store') }}" method="POST"
                    class="border border-slate-800 rounded-2xl p-6 bg-slate-50 backdrop-blur-md"
                    data-aos="fade-left" data-aos-offset="100"
                    novalidate aria-label="Contact inquiry form">
                    @csrf

                    {{-- Full Name --}}
                    <div class="mb-4">
                        <label for="contact_name" class="sr-only">Full Name</label>
                        <input id="contact_name" name="name" value="{{ old('name') }}"
                            placeholder="Full Name*" required autocomplete="name"
                            aria-required="true"
                            class="border-b border-slate-800 w-full p-2 bg-white placeholder:text-slate-800 focus:outline-none focus:border-brand-primary @error('name') border-red-500 @enderror"
                            type="text">
                        @error('name')
                            <span role="alert" class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Email + Phone --}}
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="contact_email" class="sr-only">Email Address</label>
                            <input id="contact_email" name="email" value="{{ old('email') }}"
                                placeholder="Email" autocomplete="email"
                                class="border-b border-slate-800 w-full p-2 bg-white placeholder:text-slate-800 focus:outline-none focus:border-brand-primary @error('email') border-red-500 @enderror"
                                type="email">
                            @error('email')
                                <span role="alert" class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="contact_phone" class="sr-only">Mobile Number</label>
                            <input id="contact_phone" name="phone" value="{{ old('phone') }}"
                                placeholder="Mobile Number*" required autocomplete="tel"
                                aria-required="true"
                                class="border-b border-slate-800 w-full p-2 bg-white placeholder:text-slate-800 focus:outline-none focus:border-brand-primary @error('phone') border-red-500 @enderror"
                                type="text">
                            @error('phone')
                                <span role="alert" class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- Interest Radio --}}
                    <fieldset class="mb-4">
                        <legend class="block text-slate-800 mb-3 font-medium">
                            What are you interested in?
                            <span class="text-red-600" aria-label="required">*</span>
                        </legend>
                        <div class="space-y-2">
                            @php
                                $interests = [
                                    'resort-investment'         => 'Resort Investment Opportunities',
                                    'property-tour'             => 'Property Tour and Site Visits',
                                    'investment-consultation'   => 'Investment Consultation',
                                    'partnership-collaboration' => 'Partnership and Collaboration',
                                    'general-inquiry'           => 'General Inquiry',
                                ];
                            @endphp
                            @foreach($interests as $value => $label)
                                <label class="flex items-center gap-2 cursor-pointer w-fit"
                                    for="interest_{{ $value }}">
                                    <input
                                        id="interest_{{ $value }}"
                                        class="text-slate-700 focus:ring-brand-primary focus:ring-offset-1"
                                        type="radio" value="{{ $value }}" name="interested_in"
                                        {{ old('interested_in') == $value ? 'checked' : '' }}>
                                    <span class="text-slate-700">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('interested_in')
                            <span role="alert" class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </fieldset>

                    {{-- Message --}}
                    <div class="mb-4">
                        <label for="contact_message" class="sr-only">Your Message</label>
                        <textarea id="contact_message" name="message"
                            placeholder="Your Message*" rows="3"
                            required aria-required="true"
                            class="border-b border-slate-800 w-full p-2 bg-white placeholder:text-slate-800 focus:outline-none focus:border-brand-primary @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
                        @error('message')
                            <span role="alert" class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Privacy --}}
                    <div class="mb-4">
                        <label for="contact_privacy" class="flex items-start gap-2 cursor-pointer w-fit">
                            <input id="contact_privacy" type="checkbox" name="privacy_agreed"
                                value="1" required aria-required="true" class="mt-1 focus:ring-brand-primary focus:ring-offset-1">
                            <span class="text-slate-700">I understand that Right Aid Hospital will securely hold my data in accordance with their
                                <a href="#" class="font-semibold text-brand-accent focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-primary focus-visible:ring-offset-1 hover:text-brand-secondary transition-colors duration-300 underline">
                                    privacy policy
                                </a>.
                            </span>
                        </label>
                        @error('privacy_agreed')
                            <span role="alert" class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Changed from font-light to font-medium for WCAG contrast pass on white text --}}
                    <button type="submit"
                        class="rounded-full bg-brand-secondary text-white py-2 w-full font-medium cursor-pointer hover:bg-brand-accent focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-primary focus-visible:ring-offset-2 transition-colors duration-300">
                        Submit Form
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection