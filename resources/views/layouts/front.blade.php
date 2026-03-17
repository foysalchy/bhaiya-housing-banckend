<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'My Website')</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bhaiya Housing</title>

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

    <!-- Local CSS (Tailwind compiled output) -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/custom.css">
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