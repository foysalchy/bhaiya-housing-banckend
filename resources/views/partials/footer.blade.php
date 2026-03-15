<footer class="bg-slate-950">
    <div class="bg-cover bg-bottom-right bg-no-repeat w-full"
        style="background-image: url('{{ asset('frontend/images/cta_footer_section_bg_shape.webp') }}')">
        <div class="bg-[#02061703] backdrop-blur-3xl pb-16">

            {{-- CTA Top Section --}}
            @isset($footerCapsule)

            <div class="lg:py-80 md:py-60 py-20 w-full relative overflow-hidden">
                <div class="mb-20">
                    <h2 class="peer hover:opacity-0 transition duration-500 w-fit mx-auto text-center text-white z-10 md:text-6xl text-4xl font-medium leading-16 underline underline-offset-6 decoration-5 mb-6">
                        {{ $footerCapsule->title }} <br class="lg:block hidden"> {{ $footerCapsule->meta_title }}

                    </h2>
                    <h2 class="absolute -z-10 top-[34%] xl:left-[35%] lg:left-[30%] opacity-0 peer-hover:opacity-100 transition-all duration-500 w-fit mx-auto text-center text-slate-950 md:text-6xl text-4xl font-medium leading-16 underline underline-offset-6 decoration-5 mb-6">
                        Invest Now on <br class="lg:block hidden"> Right Aid Hospital
                    </h2>
                    <p class="text-xl text-brand-tertiary text-center peer-hover:text-slate-900 transition duration-500">
                        {{$footerCapsule->short}}
                    </p>
                    <div class="absolute -z-20 inset-0 bg-transparent peer-hover:bg-white transition-all duration-700"></div>
                    <div class="xl:w-[44%] md:w-[50%] w-3/5 absolute -z-20 xl:top-20 top-28 xl:-right-60 md:-right-40 -right-20 peer-hover:right-[30%] peer-hover:opacity-10 transition-all duration-700">
                        <img alt="Footer capsul" loading="lazy" width="1281" height="1143" decoding="async"
                            src="{{ asset('frontend/images/cta_footer_image2.webp') }}">
                    </div>
                </div>

                {{-- Download Brochure Button --}}
                <div class="mx-auto w-fit">
                    <a href="{{ asset('frontend/files/Brochure.pdf') }}" download="Brochure_Right_Aid_Hospital.pdf"
                        class="group relative flex items-center cursor-pointer rounded-full focus:outline-none bg-brand-primary py-[15px] pr-6 pl-16 transition-all duration-500 hover:bg-slate-900 max-lg:focus:bg-slate-900">
                        <span class="absolute left-1 bg-white text-slate-900 p-1.5 rounded-full transition-all duration-500 z-20
                        group-hover:left-[83%] max-lg:group-focus:left-[83%]
                        group-hover:bg-brand-primary max-lg:group-focus:bg-brand-primary
                        group-hover:text-white max-lg:group-focus:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-miterlimit="10" stroke-width="1.5"
                                    d="M18.07 14.43L12 20.5l-6.07-6.07M12 12v8.33M12 3.5v4.53"></path>
                            </svg>
                        </span>
                        <h6 class="text-[16px] leading-[14px] text-white transition-all duration-500 z-10
                        group-hover:-translate-x-[36%] max-lg:group-focus:-translate-x-[36%]
                        group-hover:text-brand-primary max-lg:group-focus:text-brand-primary">
                            Download Brochure
                        </h6>
                    </a>
                </div>
            </div>
            @endisset


            {{-- Footer Info Card --}}
            <div class="lg:mx-20 mx-2 pt-20">
                <div class="bg-white rounded-4xl overflow-clip">
                    <div class="xl:p-20 lg:p-12 p-4 md:mb-0 mb-6">

                        {{-- Logo + Tagline --}}
                        <div class="flex justify-between md:flex-row flex-col md:gap-0 gap-4">
                            <div class="md:w-1/2 w-3/5">
                                @if($setting && $setting->img_path)
                                <img src="{{ asset('/') }}{{ $setting->img_path }}" alt="{{ $setting->title ?? 'Logo' }}">
                                @else
                                <img src="{{ asset('frontend/images/logo.png') }}" alt="Footer Logo">
                                @endif
                            </div>
                            <p class="text-slate-600 xl:w-[520px] md:w-1/2 w-full">
                                {{ $setting->name ?? 'Right Aid Hospital delivers cutting-edge care in Tongi, opening 2026, with advanced facilities and a 10-12% ROI for investors.' }}
                            </p>
                        </div>

                        <div class="w-full h-[1px] bg-slate-300 my-12"></div>

                        {{-- Address + Social + QR --}}
                        <div class="flex justify-between md:flex-row flex-col md:gap-0 gap-8">
                            <div class="md:flex gap-6">

                                {{-- Addresses --}}
                                <div class="xl:w-2/5 w-full lg:space-y-10 space-y-6">
                                    {{-- Corporate Office --}}
                                    @if($setting && $setting->body_2)
                                    <div>
                                        <h4 class="text-xl font-medium text-slate-900 mb-2">Corporate Office</h4>
                                        <p class="text-slate-600">{!! $setting->body_2 !!}</p>
                                    </div>
                                    @endif

                                    {{-- Head Office --}}
                                    @if($setting && $setting->body)
                                    <div>
                                        <h4 class="text-xl font-medium text-slate-900 mb-2">Head Office</h4>
                                        <p class="text-slate-600">{!! $setting->body !!}</p>
                                    </div>
                                    @endif
                                    @if($setting && $setting->location)
                                    <div>
                                        <h4 class="text-xl font-medium text-slate-900 mb-2">Hospital Address</h4>
                                        <p class="text-slate-600">{{ $setting->location }}</p>
                                    </div>
                                    @endif
                                </div>

                                {{-- Contact --}}
                                <div class="xl:w-1/5 w-full lg:space-y-10 space-y-6">
                                    @if($setting && $setting->short)
                                    <div class="max-sm:mt-6">
                                        <h4 class="text-xl font-medium text-slate-900 mb-2">Email</h4>
                                        <a href="mailto:{{ $setting->short }}"
                                            class="text-slate-600 transition-all hover:text-slate-900 duration-300">
                                            {{ $setting->short }}
                                        </a>
                                    </div>
                                    @endif
                                    @if($setting && $setting->extra)
                                    <div>
                                        <h4 class="text-xl font-medium text-slate-900 mb-2">Hotline Number</h4>
                                        <a href="tel:{{ preg_replace('/[^0-9]/', '', $setting->extra) }}"
                                            class="text-slate-600 transition-all hover:text-slate-900 duration-300">
                                            {{ $setting->extra }}
                                        </a>
                                    </div>
                                    @endif
                                </div>

                                {{-- Social Links --}}
                                <div class="xl:w-2/5 w-full max-sm:mt-6">
                                    <h4 class="text-xl font-medium text-slate-900 mb-4">Social Links</h4>
                                    <div class="flex flex-col gap-4">
                                        @foreach($socials as $social)
                                        <a href="{{ $social->url }}" target="_blank"
                                            class="text-slate-600 transition-all hover:text-slate-900 hover:translate-x-1 duration-300 w-fit">
                                            {{ $social->name }}
                                        </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            {{-- Project Of + QR --}}
                            <div class="flex 2xl:flex-row flex-col items-center 2xl:gap-10 gap-6">
                                <div class="2xl:w-1/2 w-full flex flex-col justify-center items-center">
                                    <h4 class="text-xl font-medium text-slate-900 mb-4">Project Of</h4>
                                    <a href="https://bhaiya-group.com/" target="_blank" class="2xl:w-2/3">
                                        <img src="{{ asset('frontend/images/logo.svg') }}" alt="Bhaiya Group Logo">
                                    </a>
                                    <p class="font-medium text-slate-950">Bhaiya Group</p>
                                </div>
                                <div class="flex flex-col items-center 2xl:w-1/2">
                                    <img src="{{ asset('frontend/images/footer_section_qr_code.svg') }}" alt="QR Code">
                                    @if($setting && $setting->url)
                                    <div class="w-fit mt-4">
                                        <a href="{{ $setting->url }}" target="_blank"
                                            class="group relative flex items-center cursor-pointer rounded-full focus:outline-none bg-brand-accent py-[15px] pr-6 pl-16 transition-all duration-500 hover:bg-slate-900 focus:bg-slate-900">
                                            <span class="absolute left-1 bg-white text-slate-900 p-1.5 rounded-full transition-all duration-500 z-20
                                                group-hover:left-[83%] group-focus:left-[83%]
                                                group-hover:bg-brand-accent group-focus:bg-brand-accent
                                                group-hover:text-white group-focus:text-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-miterlimit="10" stroke-width="1.5"
                                                        d="M14.43 5.93L20.5 12l-6.07 6.07M11.01 12h9.32M3.5 12h3.47"></path>
                                                </svg>
                                            </span>
                                            <h6 class="text-[16px] leading-[14px] text-white whitespace-nowrap transition-all duration-500 z-10
                                                group-hover:!-translate-x-[32%] group-focus:!-translate-x-[32%]
                                                group-hover:text-brand-accent group-focus:text-brand-accent">
                                                Visit Location in Map
                                            </h6>
                                        </a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="w-full h-[1px] bg-slate-300 my-12"></div>

                        {{-- Quick Links --}}
                        <div>
                            <h4 class="text-xl font-medium text-slate-900 mb-4">Quick Links</h4>
                            <div class="flex lg:justify-between justify-around">
                                <div class="flex lg:flex-row flex-col xl:gap-8 gap-4">
                                    <a href="{{ route('home') }}"
                                        class="transition-all hover:translate-x-1 duration-300 w-fit
                                        {{ request()->routeIs('home') ? 'text-brand-primary' : 'text-slate-600 hover:text-slate-900' }}">
                                        Home
                                    </a>
                                    <a href="{{ route('facilities') }}"
                                        class="transition-all hover:translate-x-1 duration-300 w-fit
                                        {{ request()->routeIs('facilities') ? 'text-brand-primary' : 'text-slate-600 hover:text-slate-900' }}">
                                        Facilities
                                    </a>
                                    <a href="{{ route('about') }}"
                                        class="transition-all hover:translate-x-1 duration-300 w-fit
                                        {{ request()->routeIs('about') ? 'text-brand-primary' : 'text-slate-600 hover:text-slate-900' }}">
                                        About Us
                                    </a>
                                    <a href="{{ route('newsandgallery') }}"
                                        class="transition-all hover:translate-x-1 duration-300 w-fit
                                        {{ request()->routeIs('newsandgallery') ? 'text-brand-primary' : 'text-slate-600 hover:text-slate-900' }}">
                                        News &amp; Gallery
                                    </a>
                                    <a href="{{ route('getintouch') }}"
                                        class="transition-all hover:translate-x-1 duration-300 w-fit
                                        {{ request()->routeIs('getintouch') ? 'text-brand-primary' : 'text-slate-600 hover:text-slate-900' }}">
                                        Get in Touch
                                    </a>
                                </div>
                                <div class="flex lg:flex-row flex-col xl:gap-8 gap-4">
                                    @foreach($pages as $page)
                                    <a href="{{ route('page', $page->name) }}"
                                        class="transition-all hover:translate-x-1 duration-300 w-fit text-slate-600 hover:text-slate-900">
                                        {{ $page->title }}
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- Bottom Bar --}}
                    <div class="flex justify-between items-center md:flex-row flex-col md:gap-0 gap-6 lg:px-20 px-2">
                        <p class="text-sm text-slate-600">© {{ date('Y') }} {{ $setting->title ?? 'Right Aid Hospital' }}. All rights reserved.</p>
                        <div class="relative max-md:order-last">
                            <img src="{{ asset('frontend/images/footer_section_custom_shape.svg') }}"
                                class="w-full h-full object-cover md:-mb-1.5 -mb-[6px]"
                                alt="Project of Bhaiya Group">
                            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-center">
                                <p class="text-sm text-slate-400">Project of</p>
                                <h4 class="text-xl font-medium text-white">BHAIYA GROUP</h4>
                            </div>
                        </div>
                        <p class="text-sm text-slate-400">
                            Developed By
                            <a href="#" class="text-slate-900 font-semibold transition-all duration-300 hover:text-brand-primary">
                                Nexkraft Limited
                            </a>
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>

</footer>