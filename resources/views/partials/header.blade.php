<!-- ── Header ── -->
<header id="site-header" class="fixed top-0 left-0 w-full z-50 px-6 md:px-12 py-4 md:py-6 flex items-center justify-between"
    style="transition: transform 0.4s ease, background 0.4s ease; transform: translateZ(0); z-index: 50;">

    <!-- Logo -->
<a href="/" class="z-50 flex-shrink-0">
    <img src="{{ asset($setting->img_path ?? 'images/logo.svg') }}"
        alt="{{ $setting->title ?? 'Bhaiya' }}"
        class="h-8 w-24 sm:h-10 sm:w-40 md:h-12 md:w-48 lg:w-64 object-contain"
        onerror="this.style.display='none'; this.nextElementSibling.style.display='block';" />
    <span class="hidden text-white font-semibold tracking-widest text-base md:text-xl"
        style="font-family:'Jost',sans-serif;">
        {{ strtoupper($setting->title ?? 'BHAIYA HOUSING') }}
    </span>
</a>
    <!-- Hamburger -->
    <button id="menuToggle" onclick="openMenu()"
        class="z-50 flex flex-col gap-1.5 group cursor-pointer p-1" aria-label="Open menu">
        <span class="w-7 md:w-8 h-px bg-white transition-all duration-300 group-hover:w-9 md:group-hover:w-10"></span>
        <span class="w-4 md:w-5 h-px bg-white transition-all duration-300 group-hover:w-9 md:group-hover:w-10"></span>
        <span class="w-7 md:w-8 h-px bg-white transition-all duration-300 group-hover:w-9 md:group-hover:w-10"></span>
    </button>

</header>

<!-- ── Full Screen Menu Overlay ── -->
<div id="menuOverlay" class="fixed inset-0 z-[100] flex flex-col pointer-events-none"
    style="background:#0f2018;">

    <!-- BG texture -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <img src="/images/dynamic/menu/menu-bg.png" alt=""
            class="w-full h-full object-cover opacity-15"
            onerror="this.style.display='none';" />
    </div>

    <!-- Right side bg image -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden" style="z-index:0;">
        <div class="absolute right-0 top-0 w-1/2 h-full opacity-50"
            style="background-image: url('/assets/images/bg-news.png'); background-repeat: repeat-y; background-size: 100% auto;">
        </div>
    </div>

    <!-- Top bar -->
    <div class="relative z-10 flex items-center justify-between px-6 sm:px-8 md:px-14 py-5 md:py-7 flex-shrink-0">
        <a href="/">
            <img src="{{ asset($setting->img_path ?? 'images/logo.svg') }}"
                alt="{{ $setting->title ?? 'Bhaiya' }}"
                class="h-8 md:h-10 w-auto"
                onerror="this.style.display='none'; this.nextElementSibling.style.display='block';" />
            <span class="hidden text-white font-semibold text-lg tracking-widest"
                style="font-family:'Jost',sans-serif;">
                {{ strtoupper($setting->title ?? 'BHAIYA HOUSING') }}
            </span>
        </a>
        <button onclick="closeMenu()" aria-label="Close menu"
            class="text-white opacity-70 hover:opacity-100 transition-opacity duration-300 cursor-pointer p-1">
            <svg width="24" height="24" viewBox="0 0 28 28" fill="none" stroke="white"
                stroke-width="1.5" stroke-linecap="round" aria-hidden="true">
                <line x1="4" y1="4" x2="24" y2="24" />
                <line x1="24" y1="4" x2="4" y2="24" />
            </svg>
        </button>
    </div>

    <!-- Body: Image left + Nav right -->
    <div class="relative z-10 flex flex-1 items-center justify-center md:justify-around px-6 sm:px-8 md:px-14 gap-8 overflow-hidden">

        <!-- Left: Hover Image — hidden on mobile -->
        <div class="hidden md:block w-5/12 flex-shrink-0 pr-8 lg:pr-16">
            <div class="overflow-hidden" style="height:clamp(220px,38vw,500px);" id="menuImageWrap">
                <img id="menuImage"
                    src="{{ asset('assets/images/m3.jpg') }}"
                    alt="nav image"
                    class="w-full h-full object-cover transition-all duration-500"
                    style="transform:scale(1.05);"
                    onerror="this.parentElement.style.background='#1a3020'; this.style.display='none';" />
            </div>
        </div>

        <!-- Right: Nav links -->
        <div class="flex flex-1 items-center justify-center md:justify-end">
            <div class="flex flex-col justify-end gap-1 sm:gap-2 w-full max-w-xs md:max-w-none nav-container">

                @php
                $staticLinks = [
                    ['href' => '/',          'label' => 'Home',           'key' => 'home'],
                    ['href' => '/about',     'label' => 'About Us',       'key' => 'about'],
                    ['href' => '/projects',  'label' => 'Projects',       'key' => 'projects'],
                    ['href' => '/concerns',  'label' => 'Other Concerns', 'key' => 'concerns'],
                    ['href' => '/career',    'label' => 'Career',         'key' => 'career'],
                    ['href' => '/events',    'label' => 'News & Events',  'key' => 'events'],
                ];
                @endphp

                @foreach($staticLinks as $link)
                <a href="{{ $link['href'] }}"
                    class="header-menu-list group transition-opacity duration-300 hover:opacity-100 flex items-center gap-3 md:gap-4 md:ml-32"
                    data-img="{{ isset($menuImages[$link['key']]) ? asset($menuImages[$link['key']]->img_path) : asset('assets/images/m1.jpg') }}"
                    onmouseover="hoverLink(this)"
                    onmouseout="unhoverLink(this)">
                    <span class="block h-px bg-white w-0 group-hover:w-16 md:group-hover:w-24 transition-all duration-500 ease-out opacity-0 group-hover:opacity-100 flex-shrink-0"></span>
                    <span>{{ $link['label'] }}</span>
                </a>
                @endforeach

                <!-- Contact Us -->
                <a href="#"
                    class="header-menu-list group transition-opacity duration-300 hover:opacity-100 flex items-center gap-3 md:gap-4 md:ml-32"
                    data-img="{{ isset($menuImages['contact']) ? asset($menuImages['contact']->img_path) : asset('assets/images/m1.jpg') }}"
                    onmouseover="hoverLink(this)"
                    onmouseout="unhoverLink(this)">
                    <span class="block h-px bg-white w-0 group-hover:w-16 md:group-hover:w-24 transition-all duration-500 ease-out opacity-0 group-hover:opacity-100 flex-shrink-0"></span>
                    <span>Contact Us</span>
                </a>

                <!-- Sub links -->
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 sm:gap-8 pl-1 mt-1 md:ml-48">
                    <a href="/landowner-contact"
                        class="group text-white/50 hover:text-white transition-colors duration-200 flex items-center gap-2"
                        style="font-family:'Jost',sans-serif; font-size:12px; font-weight:300; letter-spacing:0.08em;">
                        <span class="block h-px bg-white/40 w-0 group-hover:w-6 transition-all duration-300 ease-out flex-shrink-0"></span>
                        As A Landowner
                    </a>
                    <a href="/customer-contact"
                        class="group text-white/50 hover:text-white transition-colors duration-200 flex items-center gap-2"
                        style="font-family:'Jost',sans-serif; font-size:12px; font-weight:300; letter-spacing:0.08em;">
                        <span class="block h-px bg-white/40 w-0 group-hover:w-6 transition-all duration-300 ease-out flex-shrink-0"></span>
                        As A Customer
                    </a>
                </div>

            </div>
        </div>

        <!-- Vertical line — hidden on mobile -->
        <div class="hidden md:block self-stretch w-px ml-4 lg:ml-8 flex-shrink-0"
            style="background:rgba(255,255,255,0.2);"></div>

    </div>

</div>

<style>
    #menuOverlay {
        clip-path: inset(0 0 100% 0);
        transition: clip-path 0.8s cubic-bezier(0.77, 0, 0.175, 1);
    }
    #menuOverlay.is-open {
        clip-path: inset(0 0 0 0);
    }

    .nav-container > a, 
    .nav-container > div {
        opacity: 0;
        transform: translateY(80px); 
        transition: opacity 0.3s ease, transform 0.3s ease; 
    }

    #menuOverlay.is-open .nav-container > a, 
    #menuOverlay.is-open .nav-container > div {
        opacity: 1;
        transform: translateY(0);
        transition: opacity 0.8s ease, transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    }

    #menuOverlay.is-open .nav-container > a:nth-child(1) { transition-delay: 0.30s; }
    #menuOverlay.is-open .nav-container > a:nth-child(2) { transition-delay: 0.40s; }
    #menuOverlay.is-open .nav-container > a:nth-child(3) { transition-delay: 0.50s; }
    #menuOverlay.is-open .nav-container > a:nth-child(4) { transition-delay: 0.60s; }
    #menuOverlay.is-open .nav-container > a:nth-child(5) { transition-delay: 0.70s; }
    #menuOverlay.is-open .nav-container > a:nth-child(6) { transition-delay: 0.80s; }
    #menuOverlay.is-open .nav-container > a:nth-child(7) { transition-delay: 0.90s; } /* Contact Us */
    #menuOverlay.is-open .nav-container > div:nth-child(8) { transition-delay: 1.00s; } /* Sub-links */

    #menuImageWrap {
        opacity: 0;
        transform: translateY(60px);
        transition: all 0.4s ease;
    }
    #menuOverlay.is-open #menuImageWrap {
        opacity: 1;
        transform: translateY(0);
        transition: all 1s cubic-bezier(0.16, 1, 0.3, 1);
        transition-delay: 0.4s;
    }

    .header-menu-list {
        font-size: clamp(28px, 4.5vw, 58px);
        font-weight: 300;
        color: white;
        letter-spacing: 0.02em;
        line-height: 1.15;
        opacity: 0.85;
        text-decoration: none;
    }
    .header-menu-list:hover {
        opacity: 1;
    }
</style>

<script>
    function openMenu() {
        const overlay = document.getElementById('menuOverlay');
        overlay.classList.add('is-open'); 
        overlay.style.pointerEvents = 'all';
        document.body.style.overflow = 'hidden';
    }

    function closeMenu() {
        const overlay = document.getElementById('menuOverlay');
        overlay.classList.remove('is-open'); 
        overlay.style.pointerEvents = 'none';
        document.body.style.overflow = '';
    }

    function hoverLink(el) {
        const img = el.getAttribute('data-img');
        if (img) {
            const menuImg = document.getElementById('menuImage');
            if (menuImg) menuImg.src = img;
        }
    }

    function unhoverLink(el) {}

    (function () {
        let lastScroll = 0;
        const header = document.getElementById('site-header');

        window.addEventListener('scroll', function () {
            const current = window.scrollY;
            if (current > 80 && current > lastScroll) {
                header.style.transform = 'translateY(-100%)';
                header.style.background = 'transparent';
            } else {
                header.style.transform = 'translateY(0)';
                header.style.background = current > 80 ? '#152018' : 'transparent';
            }
            lastScroll = current;
        }, { passive: true });
    })();
</script>