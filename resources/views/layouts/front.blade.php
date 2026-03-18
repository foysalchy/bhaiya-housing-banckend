<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'My Website')</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!-- Facebook Pixel Code -->
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
    <!-- End Facebook Pixel Code -->
    <title>Bhaiya Housing</title>
    {{-- All SEO meta, OG, Twitter, Schema injects here --}}
    @yield('meta')

    <!-- Outfit Font -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet" />

    <!-- Outfit Font -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet" />
    <!-- AOS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css" />
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
      <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>


    <!-- Local CSS (Tailwind compiled output) -->
    <link rel="stylesheet" href="{{ asset('frontend/css/custom.css') }}">
    <script src="{{ asset('frontend/js/main.js') }}" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- CSS --}}
    @include('partials.header')

    @stack('styles')

</head>
<!DOCTYPE html>
<html lang="en">



<body>




    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>
    @include('partials.floating')
    {{-- Footer --}}
    @include('partials.footer')

    {{-- Scripts --}}
    @include('partials.scripts')

    @stack('scripts')

</body>

</html>
