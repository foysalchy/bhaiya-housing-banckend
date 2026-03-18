<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'My Website')</title>
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