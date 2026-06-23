<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bhaiya Housing')</title>
    <link rel="icon" type="image/webp" href="{{ asset('assets/images/fav.webp') }}">
    <!-- Facebook Pixel -->
    <script>
        function loadPixel() {
            if (window.fbLoaded) return;
            ! function(f, b, e, v, n, t, s) {
                if (f.fbq) return;
                n = f.fbq = function() {
                    n.callMethod ? n.callMethod.apply(n, arguments) : n.queue.push(arguments)
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
            }(window, document, 'script', 'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '1810581886992684');
            fbq('track', 'PageView');
            window.fbLoaded = true;
        }
        ['mouseover', 'scroll', 'touchstart'].forEach(event => {
            window.addEventListener(event, loadPixel, {
                once: true
            });
        });
    </script>

    <noscript>
        <img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=1810581886992684&ev=PageView&noscript=1" />
    </noscript>

    @yield('meta')

    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">


    <link rel="preload" as="image" href="{{ $hero->img_path ?? '' }}" fetchpriority="high">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
    @stack('scripts')

    <script src="{{ asset('frontend/js/main.js') }}"></script>


</body>

</html>
