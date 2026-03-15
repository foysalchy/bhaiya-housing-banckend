<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'My Website')</title>

    {{-- CSS --}}
    @include('partials.header')

    @stack('styles')

</head>

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