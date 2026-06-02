<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bhaiya Housing')</title>
    <link rel="icon" type="image/webp" href="{{ asset('assets/images/fav.webp') }}">
    <!-- Facebook Pixel -->
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '1810581886992684');
        fbq('track', 'PageView');
        @stack('pixel_events')
    </script>
    <noscript>
        <img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=1810581886992684&ev=PageView&noscript=1" />
    </noscript>

    @yield('meta')

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />

    <!-- AOS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css" />

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Local CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/css/custom.css') }}?v=111111111111">

    <style>
        html.lenis {
            height: auto;
        }

        .lenis.lenis-smooth {
            scroll-behavior: auto;
        }

        .lenis.lenis-smooth [data-lenis-prevent] {
            overscroll-behavior: contain;
        }

        header {
            transition: transform 0.4s ease;
        }

        header.hide {
            transform: translateY(-100%);
        }

        /* ======= Custom Trailing Cursor CSS ======= */
        @media (pointer: fine) {

            /* body, a, button { cursor: none !important; } */

            .cursor-dot {
                position: fixed;
                top: 0;
                left: 0;
                width: 5px;
                height: 5px;
                background-color: #000000;
                border-radius: 50%;
                pointer-events: none;
                z-index: 999999;
                transform: translate(-50%, -50%);
                transition: width 0.3s ease, height 0.3s ease, background-color 0.3s ease;
                will-change: transform, width, height;
            }

            .cursor-dot.active {
                width: 15px;
                height: 15px;
                background-color: rgba(0, 0, 0, 0.5);
            }

            .cursor-dot.active-large {
                width: 50px;
                height: 50px;
                background-color: #000;

                backdrop-filter: blur(2px);
            }

        }

        @media (pointer: coarse) {
            .cursor-dot {
                display: none;
            }
        }

        .test-circle {
            width: 150px;
            height: 150px;
            border: 1px solid #ccc;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 50px auto;
            cursor: pointer;
            position: relative;
        }

        /* ========================================== */
    </style>

    @stack('styles')
</head>

<body>

    <!-- ======= Custom Cursor Element ======= -->
    <div class="cursor-dot" id="cursor-dot"></div>
    <!-- ===================================== -->

    @include('partials.header')

    <main>
        @yield('content')


    </main>

    @include('partials.floating')
    @include('partials.footer')
    @include('partials.scripts')

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- Lenis -->
    <script src="https://cdn.jsdelivr.net/npm/@studio-freight/lenis@1.0.42/dist/lenis.min.js"></script>

    <!-- Local JS -->
    <script src="{{ asset('frontend/js/main.js') }}"></script>

    <script>
        let lastScroll = 0;
        const header = document.querySelector('header');

        window.addEventListener('load', function() {

            // ── GSAP ScrollTrigger register ──
            gsap.registerPlugin(ScrollTrigger);

            if (window.innerWidth > 768) {
                const lenis = new Lenis({
                    duration: 1.4,
                    easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
                    smooth: true,
                });

                gsap.ticker.add((time) => lenis.raf(time * 1000));
                gsap.ticker.lagSmoothing(0);
                lenis.on('scroll', ScrollTrigger.update);

                lenis.on('scroll', ({
                    scroll
                }) => {
                    header.classList.toggle('hide', scroll > lastScroll && scroll > 80);
                    lastScroll = scroll;
                });
            } else {
                window.addEventListener('scroll', () => {
                    const s = window.scrollY;
                    header.classList.toggle('hide', s > lastScroll && s > 80);
                    lastScroll = s;
                });
            }

            // GSAP Parallax & Fade Up...
            gsap.utils.toArray('[data-speed]').forEach(el => {
                const speed = parseFloat(el.dataset.speed) || 1;
                gsap.to(el, {
                    y: () => (1 - speed) * ScrollTrigger.maxScroll(window) * 0.3,
                    ease: 'none',
                    scrollTrigger: {
                        trigger: el,
                        start: 'top bottom',
                        end: 'bottom top',
                        scrub: true,
                    }
                });
            });

            gsap.utils.toArray('[data-gsap="fade-up"]').forEach(el => {
                gsap.from(el, {
                    y: 60,
                    opacity: 0,
                    duration: 1,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: el,
                        start: 'top 85%',
                    }
                });
            });
        });

        // ==========================================
        // ── Custom Trailing & Magnetic Cursor Logic ──
        // ==========================================
        const dot = document.getElementById('cursor-dot');

        let mouseX = window.innerWidth / 2;
        let mouseY = window.innerHeight / 2;
        let dotX = window.innerWidth / 2;
        let dotY = window.innerHeight / 2;

        let magneticElement = null; // ম্যাগনেটিক ইফেক্টের জন্য ভ্যারিয়েবল

        if (window.matchMedia("(pointer: fine)").matches) {

            window.addEventListener('mousemove', (e) => {
                mouseX = e.clientX;
                mouseY = e.clientY;
            });

            function animateCursor() {
                let targetX = mouseX;
                let targetY = mouseY;

                // যদি magneticElement থাকে, তবে টার্গেট হবে ওই ইলিমেন্টের একদম সেন্টার
                if (magneticElement) {
                    const rect = magneticElement.getBoundingClientRect();
                    targetX = rect.left + (rect.width / 2);
                    targetY = rect.top + (rect.height / 2);
                }

                // 0.15 হলো স্পিড
                dotX += (targetX - dotX) * 0.15;
                dotY += (targetY - dotY) * 0.15;

                dot.style.transform = `translate(${dotX}px, ${dotY}px) translate(-50%, -50%)`;

                requestAnimationFrame(animateCursor);
            }
            animateCursor();

            // ── Event Delegation for Hover & Magnetic Logic ──
            document.addEventListener('mouseover', (e) => {
                const largeTarget = e.target.closest('.hover-lg');
                const normalTarget = e.target.closest('a, button, input[type="submit"], input[type="button"]');

                if (largeTarget) {
                    magneticElement = largeTarget; // ম্যাগনেট চালু
                    dot.classList.add('active-large');
                    dot.classList.remove('active');
                } else if (normalTarget) {
                    dot.classList.add('active');
                    dot.classList.remove('active-large');
                }
            });

            document.addEventListener('mouseout', (e) => {
                const largeTarget = e.target.closest('.hover-lg');
                const normalTarget = e.target.closest('a, button, input[type="submit"], input[type="button"]');

                if (largeTarget) {
                    magneticElement = null; // ম্যাগনেট বন্ধ (মাউসের কাছে ফিরে যাবে)
                    dot.classList.remove('active-large');
                } else if (normalTarget) {
                    dot.classList.remove('active');
                }
            });
        }
        // ==========================================
    </script>

    @stack('scripts')

</body>

</html>