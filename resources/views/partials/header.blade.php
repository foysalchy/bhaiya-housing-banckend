<!-- ── Header ── -->
<header class="fixed top-0 left-0 w-full z-50 px-6 md:px-12 py-6 flex items-center justify-between">

    <!-- Logo -->
    <a href="/" class="z-50 flex-shrink-0">
        <img src="{{ $setting->img_path ?? asset('images/logo-white.png') }}"
            alt="{{ $setting->title ?? 'Bhaiya Housing' }}"
            class="h-10 w-auto"
            onerror="this.style.display='none'; this.nextElementSibling.style.display='block';" />
        <span class="hidden text-white font-semibold text-lg tracking-widest"
            style="font-family:'Jost',sans-serif;">
            {{ strtoupper($setting->title ?? 'BHAIYA HOUSING') }}
        </span>
    </a>

    <!-- Hamburger -->
    <button id="menuToggle" onclick="openMenu()"
        class="z-50 flex flex-col gap-1.5 group cursor-pointer" aria-label="Open menu">
        <span class="w-8 h-px bg-white transition-all duration-300 group-hover:w-10"></span>
        <span class="w-5 h-px bg-white transition-all duration-300 group-hover:w-10"></span>
        <span class="w-8 h-px bg-white transition-all duration-300 group-hover:w-10"></span>
    </button>

</header>

<!-- ── Full Screen Menu Overlay ── -->
<div id="menuOverlay" class="fixed inset-0 z-[100] flex flex-col pointer-events-none"
    style="background:#0f2018; opacity:0; transition: opacity 0.5s ease;">

    <!-- BG texture -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <img src="/images/dynamic/menu/menu-bg.png" alt=""
            class="w-full h-full object-cover opacity-15"
            onerror="this.style.display='none';" />
    </div>

    <!-- Top bar -->
    <div class="relative z-10 flex items-center justify-between px-8 md:px-14 py-7 flex-shrink-0">
        <!-- Logo -->
        <a href="/">
            <img src="{{ $setting->img_path ?? asset('images/logo-white.png') }}"
                alt="{{ $setting->title ?? 'Bhaiya Housing' }}"
                class="h-10 w-auto"
                onerror="this.style.display='none'; this.nextElementSibling.style.display='block';" />
            <span class="hidden text-white font-semibold text-lg tracking-widest"
                style="font-family:'Jost',sans-serif;">
                {{ strtoupper($setting->title ?? 'BHAIYA HOUSING') }}
            </span>
        </a>
        <!-- Close -->
        <button onclick="closeMenu()"
            aria-label="Close menu"
            class="text-white opacity-70 hover:opacity-100 transition-opacity duration-300 cursor-pointer">
            <svg width="28" height="28" viewBox="0 0 28 28" fill="none" stroke="white"
                stroke-width="1.5" stroke-linecap="round" aria-hidden="true">
                <line x1="4" y1="4" x2="24" y2="24" />
                <line x1="24" y1="4" x2="4" y2="24" />
            </svg>
        </button>
    </div>

    <!-- Body: Image left + Nav right -->
    <div class="relative z-10 flex flex-1 items-center justify-around px-8 md:px-14 gap-10 overflow-hidden">

        <!-- Left: Hover Image -->
        <div class="hidden md:block w-5/12 flex-shrink-0 pr-16">
            <div class="overflow-hidden" style="height:clamp(280px,42vw,500px);" id="menuImageWrap">
                <img id="menuImage"
                    src="{{ asset('assets/images/m3.jpg') }}"
                    alt="nav image"
                    class="w-full h-full object-cover transition-all duration-500"
                    style="transform:scale(1.05);"
                    onerror="this.parentElement.style.background='#1a3020'; this.style.display='none';" />
            </div>
        </div>

        <!-- Right: Nav links -->
        <div class="flex flex-1 items-center justify-around gap-0">
            <nav class="flex flex-col justify-end gap-2">

                {{-- Static fixed links --}}
                @php
                $staticLinks = [
                ['href' => '/', 'label' => 'Home', 'key' => 'home'],
                ['href' => '/about', 'label' => 'About Us', 'key' => 'about'],
                ['href' => '/projects', 'label' => 'Projects', 'key' => 'projects'],
                ['href' => '/concerns', 'label' => 'Other Concerns', 'key' => 'concerns'],
                ['href' => '/career', 'label' => 'Career', 'key' => 'career'],
                ['href' => '/events', 'label' => 'News & Events', 'key' => 'events'],
                ];
                @endphp

                @foreach($staticLinks as $link)
                <a href="{{ $link['href'] }}"
                    class="menu-link block text-white transition-opacity duration-300"
                    style="font-family:'Cormorant Garamond',serif; font-style:italic; font-weight:300; font-size:clamp(36px,5.5vw,72px); line-height:1.25; opacity:0.5;"
                    data-img="{{ isset($menuImages[$link['key']]) ? asset($menuImages[$link['key']]->img_path) : asset('assets/images/m1.jpg') }}"
                    onmouseover="hoverLink(this)"
                    onmouseout="unhoverLink(this)">
                    {{ $link['label'] }}
                </a>
                @endforeach

    

                <!-- Contact Us -->
                <a href="/contact"
                    class="menu-link block text-white transition-opacity duration-300"
                    style="font-family:'Cormorant Garamond',serif; font-style:italic; font-weight:300; font-size:clamp(36px,5.5vw,72px); line-height:1.25; opacity:0.5;"
                    data-img="{{ isset($menuImages['contact']) ? asset($menuImages['contact']->img_path) : asset('assets/images/m1.jpg') }}"
                    onmouseover="hoverLink(this)"
                    onmouseout="unhoverLink(this)">
                    Contact Us
                </a>

                <div class="flex items-center gap-10 pl-1" style="margin-top:-4px;">
                    <a href="/contact-landowner"
                        class="text-white/50 hover:text-white transition-colors duration-200 flex items-center gap-2"
                        style="font-family:'Jost',sans-serif; font-size:13px; font-weight:300; letter-spacing:0.08em;">
                        <span class="block w-6 h-px bg-white/40"></span>
                        As A Landowner
                    </a>
                    <a href="/contact-customer"
                        class="text-white/50 hover:text-white transition-colors duration-200 flex items-center gap-2"
                        style="font-family:'Jost',sans-serif; font-size:13px; font-weight:300; letter-spacing:0.08em;">
                        <span class="block w-6 h-px bg-white/40"></span>
                        As A Customer
                    </a>
                </div>

            </nav>

            <!-- Vertical line -->
            <div class="self-stretch w-px ml-8 flex-shrink-0"
                style="background:rgba(255,255,255,0.2);"></div>
        </div>
    </div>

</div>