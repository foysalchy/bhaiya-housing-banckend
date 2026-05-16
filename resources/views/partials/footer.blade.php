<footer class="w-full relative z-10" style="background:#0f2018; font-family:'Jost',sans-serif;">

  <!-- Main Footer Content -->
  <div class="container mx-auto px-6 lg:px-14 pt-16 pb-10">
    <div class="flex flex-col md:flex-row justify-between gap-16">

      <!-- ── Left: Logo + Contact ── -->
      <div class="max-w-sm">

        <!-- Logo -->
        <div class="mb-10">
          <img src="{{ $setting?->img_path ? asset($setting->img_path) : asset('images/logo-white.png') }}"
            alt="{{ $setting?->title ?? 'Bhaiya Housing' }}" class="h-14 w-auto"
            onerror="this.style.display='none'; this.nextElementSibling.style.display='block';" />
          <span class="hidden text-white text-2xl font-semibold tracking-widest">
            {{ strtoupper($setting?->title ?? 'BHAIYA HOUSING') }}
          </span>
        </div>

        <!-- Phone -->
        @if($setting?->extra)
        <p class="text-white text-sm font-normal tracking-wide mb-3">
          {{ $setting->extra }}
        </p>
        @endif

        <!-- Email -->
        @if($setting?->short)
        <div class="mb-6">
          <a href="mailto:{{ $setting->short }}"
            class="text-white text-sm font-light opacity-80 hover:opacity-100 transition-opacity duration-200 no-underline">
            {{ $setting->short }}
          </a>
        </div>
        @endif

        <!-- Corporate Office -->
        @if($setting?->body_2)
        <div class="mb-5">
          <p class="text-white text-xs font-medium mb-1">Corporate Office:</p>
          <p class="text-white text-xs font-light opacity-60 leading-relaxed">
            {!! $setting->body_2 !!}
          </p>
        </div>
        @endif

        <!-- Head Office -->
        @if($setting?->body)
        <div class="mb-8">
          <p class="text-white text-xs font-medium mb-1">Head Office:</p>
          <p class="text-white text-xs font-light opacity-60 leading-relaxed">
            {!! $setting->body !!}
          </p>
        </div>
        @endif

        <!-- Social Icons -->
        @if($socials->isNotEmpty())
        <div class="flex items-center gap-5">
          @foreach($socials as $social)
          <a href="{{ $social->url }}" target="_blank" rel="noopener"
            aria-label="{{ $social->title ?? $social->name }}"
            class="text-white opacity-60 hover:opacity-100 transition-opacity duration-200">

          </a>
          @endforeach
        </div>
        @endif

      </div>

      <!-- ── Right: Description + Nav ── -->
      <div class="flex flex-col justify-between max-w-xl">

        <!-- Description / Slogan -->
        @if($setting?->name)
        <p class="text-white text-xs font-light opacity-60 leading-loose">
          {{ $setting->name }}
        </p>
        @endif

        <!-- Nav Links -->
        <nav class="flex flex-wrap gap-x-10 gap-y-3 mt-12 md:mt-0">
          <a href="/" class="text-white text-sm font-light opacity-75 hover:opacity-100 transition-opacity duration-200 no-underline">Home</a>
          <a href="/about" class="text-white text-sm font-light opacity-75 hover:opacity-100 transition-opacity duration-200 no-underline">About Us</a>
          <a href="/projects" class="text-white text-sm font-light opacity-75 hover:opacity-100 transition-opacity duration-200 no-underline">Projects</a>
          <a href="/news" class="text-white text-sm font-light opacity-75 hover:opacity-100 transition-opacity duration-200 no-underline">Events &amp; News</a>
          <a href="/contact" class="text-white text-sm font-light opacity-75 hover:opacity-100 transition-opacity duration-200 no-underline">Contacts</a>


        </nav>

      </div>

    </div>
  </div>

  <!-- ── Bottom Bar ── -->
  <div class="border-t border-white border-opacity-10">
    <div class="max-w-screen-xl mx-auto px-6 lg:px-14 py-5 flex items-center justify-between flex-wrap gap-3">
      <p class="text-white text-xs font-light">
        &copy; {{ date('Y') }} {{ $setting?->title ?? 'Bhaiya Housing Ltd.' }}
      </p>
      <p class="flex items-center gap-2 text-white text-xs font-light">
        Site by Dcastalia
        <span class="w-4 h-4 rounded-full bg-indigo-600 flex items-center justify-center">
          <svg width="6" height="6" viewBox="0 0 10 10" fill="white">
            <circle cx="5" cy="5" r="4" />
          </svg>
        </span>
      </p>
    </div>
  </div>

</footer>
