<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bhaiya Housing')</title>

    <!-- Facebook Pixel -->
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '749680890686257');
        fbq('track', 'PageView');
        @stack('pixel_events')
    </script>
    <noscript>
        <img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=749680890686257&ev=PageView&noscript=1"/>
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
    <link rel="stylesheet" href="{{ asset('frontend/css/custom.css') }}">

    <style>
        html.lenis { height: auto; }
        .lenis.lenis-smooth { scroll-behavior: auto; }
        .lenis.lenis-smooth [data-lenis-prevent] { overscroll-behavior: contain; }

        header {
            transition: transform 0.4s ease;
        }
        header.hide {
            transform: translateY(-100%);
        }
    </style>

    @stack('styles')
</head>

<body>

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
        let lenis;
        let lastScroll = 0;
        const header = document.querySelector('header');

        window.addEventListener('load', function () {

            // ── Lenis smooth scroll (desktop only) ──
            if (window.innerWidth > 768) {
                lenis = new Lenis({
                    duration: 1.4,
                    easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
                    smooth: true,
                });

                function raf(time) {
                    lenis.raf(time);
                    requestAnimationFrame(raf);
                }
                requestAnimationFrame(raf);

                // ── Header hide/show on Lenis scroll ──
                lenis.on('scroll', ({ scroll }) => {
                    if (scroll > lastScroll && scroll > 80) {
                        header.classList.add('hide');
                    } else {
                        header.classList.remove('hide');
                    }
                    lastScroll = scroll;
                });

            } else {
                // ── Mobile: normal scroll header hide/show ──
                window.addEventListener('scroll', () => {
                    const currentScroll = window.scrollY;
                    if (currentScroll > lastScroll && currentScroll > 80) {
                        header.classList.add('hide');
                    } else {
                        header.classList.remove('hide');
                    }
                    lastScroll = currentScroll;
                });
            }

        });
    </script>

    @stack('scripts')

</body>

</html>