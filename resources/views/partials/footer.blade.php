<footer class="w-full relative z-10 mt-0 pt-0" style="background:#0f2018;">

  <style>
    .head-office-address, .head-office-address * {
      color: white !important;
      transition: color 0.3s ease;
    }
    .head-office-address:hover, .head-office-address:hover * {
      color: #C0A46F !important;
    }
    .corp-address, .corp-address * {
      color: white !important;
      transition: color 0.3s ease;
    }
    .corp-address:hover, .corp-address:hover * {
      color: #C0A46F !important;
    }
  </style>

  <div class="container mx-auto px-6 lg:px-14 pt-16 pb-10">
    <div class="flex flex-col lg:flex-row lg:items-stretch gap-12 lg:gap-20">

      <!-- ── Left: Logo + Contact ── -->
      <div class="w-full lg:max-w-sm">

        <!-- Logo -->
        <div class="mb-8">
          <img src="{{ $setting?->img_path ? asset($setting->img_path) : asset('images/logo-white.png') }}"
            alt="{{ $setting?->title ?? 'Bhaiya Housing' }}" class="h-12 w-auto"
            onerror="this.style.display='none'; this.nextElementSibling.style.display='block';" />
          <span class="hidden text-white text-2xl font-semibold tracking-widest">
            {{ strtoupper($setting?->title ?? 'BHAIYA HOUSING') }}
          </span>
        </div>

        <!-- Phone -->
        @if($setting?->extra)
        <p class="text-white text-sm font-normal tracking-wide mb-3 transition-colors duration-300 hover:text-[#C0A46F]">
          {{ $setting->extra }}
        </p>
        @endif

        <!-- Email -->
        @if($setting?->short)
        <div class="mb-6">
          <a href="mailto:{{ $setting->short }}"
            class="text-white text-sm font-light transition-colors duration-300 no-underline hover:text-[#C0A46F]">
            {{ $setting->short }}
          </a>
        </div>
        @endif

        <!-- Corporate Office -->
        @if($setting?->body_2)
        <div class="mb-5">
          <p class="text-white text-sm font-medium mb-1">Corporate Office:</p>
          <div class="corp-address text-sm font-light leading-relaxed">
            {!! $setting->body_2 !!}
          </div>
        </div>
        @endif

        <!-- Head Office -->
        @if($setting?->body)
        <div class="mb-8">
          <p class="text-white text-sm font-medium mb-1">Head Office:</p>
          <div class="head-office-address text-sm font-light leading-relaxed">
            {!! $setting->body !!}
          </div>
        </div>
        @endif

        <!-- Social Icons -->
        @if($socials->isNotEmpty())
        <div class="flex items-center gap-5 mt-2">
          @foreach($socials as $social)
          <a href="{{ $social->url }}" target="_blank" rel="noopener"
            aria-label="{{ $social->title ?? $social->name }}"
            class="text-white opacity-60 hover:opacity-100 transition-opacity duration-200">
          </a>
          @endforeach
        </div>
        @endif

      </div>

      <!-- ── Right: Slogan top, Nav bottom ── -->
      <div class="flex flex-col justify-between flex-1 gap-10 lg:gap-0">

        <!-- Slogan -->
        @if($setting?->name)
        <p class="text-white text-sm font-light md:mt-16 leading-loose ">
          {{ $setting->name }}
        </p>
        @endif

        <!-- Nav -->
        <nav class="flex flex-wrap gap-x-8 gap-y-4">
          <a href="/" class="text-white text-xl font-light transition-colors duration-300 no-underline hover:text-[#C0A46F]">Home</a>
          <a href="/about" class="text-white text-xl font-light transition-colors duration-300 no-underline hover:text-[#C0A46F]">About Us</a>
          <a href="/projects" class="text-white text-xl font-light transition-colors duration-300 no-underline hover:text-[#C0A46F]">Projects</a>
          <a href="/news" class="text-white text-xl font-light transition-colors duration-300 no-underline hover:text-[#C0A46F]">Events &amp; News</a>
          <a href="/contact" class="text-white text-xl font-light transition-colors duration-300 no-underline hover:text-[#C0A46F]">Contacts</a>
        </nav>

      </div>
    </div>
  </div>

  <!-- ── Bottom Bar ── -->
  <div class="border-t border-white border-opacity-10 mt-6">
    <div class="container mx-auto px-6 lg:px-14 py-5 flex flex-col sm:flex-row items-center justify-between gap-3">
      <p class="text-white text-xs font-light text-center sm:text-left">
        &copy; {{ date('Y') }} {{ $setting?->title ?? 'Bhaiya Housing Ltd.' }}
      </p>
      <p class="flex items-center gap-2 text-white text-xs font-light">
        Site by Bhaiya Digital
        <span class="w-4 h-4 rounded-full bg-indigo-600 flex items-center justify-center">
          <svg width="6" height="6" viewBox="0 0 10 10" fill="white">
            <circle cx="5" cy="5" r="4" />
          </svg>
        </span>
      </p>
    </div>
  </div>

</footer>