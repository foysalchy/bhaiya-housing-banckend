<footer class="w-full relative z-10 mt-0 pt-0" style="background:#0f2018;">

  <style>
    /* ─── ১. মোবাইল ভিউ সিএসএস (শুধুমাত্র মোবাইলের জন্য) ─── */
    @media (max-width: 1023px) {
      .mobile-nav-link {
        font-size: 24px !important;
        font-weight: 300 !important;
        color: #ffffff !important;
        text-decoration: none !important;
        transition: color 0.3s ease, padding-left 0.3s ease;
      }
      .mobile-nav-link:hover {
        color: #C0A46F !important;
        padding-left: 6px;
      }
      .mobile-corp-address,
      .mobile-corp-address *,
      .mobile-head-office-address,
      .mobile-head-office-address * {
        color: #C0A46F !important; /* গোল্ডেন কালার */
        font-size: 18px !important;
        font-weight: 300 !important;
        line-height: 1.7 !important;
        transition: color 0.3s ease;
      }
      .mobile-corp-address:hover,
      .mobile-corp-address:hover *,
      .mobile-head-office-address:hover,
      .mobile-head-office-address:hover * {
        color: #ffffff !important;
      }
      
      /* আইকনের শেইপ নিখুঁত রাখার জন্য fill: currentColor রিমুভ করা হয়েছে */
      .mobile-social-link svg, 
      .mobile-social-link i {
        width: 24px !important;
        height: 24px !important;
        font-size: 24px !important;
        display: inline-block;
        vertical-align: middle;
        transition: transform 0.3s ease, color 0.3s ease;
      }
      .mobile-social-link:hover svg,
      .mobile-social-link:hover i {
        color: #C0A46F !important;
        transform: scale(1.15);
      }
    }

    /* ─── ২. ডেস্কটপ ভিউ সিএসএস (প্রথম প্রম্পটের অরিজিনাল স্টাইল) ─── */
    @media (min-width: 1024px) {
      .desktop-corp-address,
      .desktop-corp-address *,
      .desktop-head-office-address,
      .desktop-head-office-address * {
        color: white !important;
        transition: color 0.3s ease;
      }
      .desktop-corp-address:hover,
      .desktop-corp-address:hover *,
      .desktop-head-office-address:hover,
      .desktop-head-office-address:hover * {
        color: #C0A46F !important;
      }
      .cc .text-sm {
        font-size: 17px !important;
      }
      .desktop-social-link svg,
      .desktop-social-link i {
        width: 20px !important;
        height: 20px !important;
        font-size: 20px !important;
        display: inline-block;
        vertical-align: middle;
        transition: opacity 0.2s;
      }
    }
  </style>

  <div class="container mx-auto px-6 lg:px-14 pt-16 pb-10">
    
    <!-- ================================================================= -->
    <!-- ─── ১. মোবাইল ভিউ (lg:hidden) ─── -->
    <!-- ================================================================= -->
    <div class="lg:hidden">
      
      <!-- Top Row: Navigation Left + Socials Right -->
      <div class="flex justify-between items-start gap-6 mb-10">
        <!-- Navigation Menu -->
        <nav class="flex flex-col gap-6">
          <a href="/about" class="mobile-nav-link">About Us</a>
          <a href="/projects" class="mobile-nav-link">Projects</a>
          <a href="/event" class="mobile-nav-link">Events &amp; News</a>
          <a href="/customer-contact" class="mobile-nav-link">Contacts</a>
          <a href="/blog" class="mobile-nav-link">Blog</a>
          @foreach($pages as $page)
          <a href="{{ route('page.show', $page->name) }}" class="mobile-nav-link">
            {{ $page->title }}
          </a>
          @endforeach
        </nav>

        <!-- Social Icons (ডান পাশে ফাঁকা অংশসহ অরিজিনাল আইকন শেইপ দেখাবে) -->
        @if($socials->isNotEmpty())
        <div class="flex flex-col gap-8 pt-2 items-center">
          @foreach($socials as $social)
          <a href="{{ $social->url }}" target="_blank" rel="noopener"
            aria-label="{{ $social->title ?? $social->name }}"
            class="mobile-social-link text-white opacity-85 hover:opacity-100">
            {!! $social->short !!}
          </a>
          @endforeach
        </div>
        @endif
      </div>

      <!-- Horizontal Divider Line -->
      <div class="w-full h-[1px] bg-white/20 mb-10"></div>

      <!-- Contact Info Section -->
      <div class="space-y-8 text-left">
        @if($setting?->extra)
        <p class="text-white text-[20px] font-normal tracking-wide transition-colors duration-300 hover:text-[#C0A46F]">
          <a href="tel:{{ preg_replace('/[^0-9+]/', '', $setting->extra) }}" class="no-underline text-white hover:text-[#C0A46F]">
            {{ $setting->extra }}
          </a>
        </p>
        @endif

        @if($setting?->short)
        <p class="text-white text-[20px] font-light transition-colors duration-300 hover:text-[#C0A46F]">
          <a href="mailto:{{ $setting->short }}" class="no-underline text-white hover:text-[#C0A46F]">
            {{ $setting->short }}
          </a>
        </p>
        @endif

        @if($setting?->body_2)
        <div>
          <p class="text-white text-lg font-medium mb-1.5">Corporate Office:</p>
          <div class="mobile-corp-address">
            {!! $setting->body_2 !!}
          </div>
        </div>
        @endif

        @if($setting?->body)
        <div>
          <p class="text-white text-lg font-medium mb-1.5">Head Office:</p>
          <div class="mobile-head-office-address">
            {!! $setting->body !!}
          </div>
        </div>
        @endif
      </div>

    </div>


    <!-- ================================================================= -->
    <!-- ─── ২. ডেস্কটপ ভিউ (hidden lg:flex) ─── -->
    <!-- ================================================================= -->
    <div class="hidden lg:flex lg:flex-row lg:items-stretch gap-12 lg:gap-20">

      <!-- ── Left: Logo + Contact ── -->
      <div class="w-full lg:max-w-sm cc">

        <!-- Logo -->
        <div class="mb-8">
          <img src="{{ $setting?->img_path ? asset($setting->img_path) : asset('images/logo-white.png') }}"
            alt="{{ $setting?->title ?? 'Bhaiya Housing' }}" class="w-[180px]"
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
          <div class="desktop-corp-address text-sm font-light leading-relaxed">
            {!! $setting->body_2 !!}
          </div>
        </div>
        @endif

        <!-- Head Office -->
        @if($setting?->body)
        <div class="mb-8">
          <p class="text-white text-sm font-medium mb-1">Head Office:</p>
          <div class="desktop-head-office-address text-sm font-light leading-relaxed">
            {!! $setting->body !!}
          </div>
        </div>
        @endif

        <!-- Social Icons (Desktop: Horizontal) -->
        @if($socials->isNotEmpty())
        <div class="flex items-center gap-5 mt-2">
          @foreach($socials as $social)
          <a href="{{ $social->url }}" target="_blank" rel="noopener"
            aria-label="{{ $social->title ?? $social->name }}"
            class="desktop-social-link text-white opacity-60 hover:opacity-100 transition-opacity duration-200">
            {!! $social->short !!}
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
          <a href="/event" class="text-white text-xl font-light transition-colors duration-300 no-underline hover:text-[#C0A46F]">Events &amp; News</a>
          <a href="/customer-contact" class="text-white text-xl font-light transition-colors duration-300 no-underline hover:text-[#C0A46F]">Contacts</a>
          <a href="/blog" class="text-white text-xl font-light transition-colors duration-300 no-underline hover:text-[#C0A46F]">Blog</a>
          @foreach($pages as $page)
          <a href="{{ route('page.show', $page->name) }}"
            class="text-white text-xl font-light transition-colors duration-300 no-underline hover:text-[#C0A46F]">
            {{ $page->title }}
          </a>
          @endforeach
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
    Design & Develop By  <a href="https://www.bhaiya.digital/" target="_blank" rel="noopener noreferrer" class="text-white hover:text-[#C0A46F]">Bhaiya Digital</a>
      </p>
    </div>
  </div>

</footer>