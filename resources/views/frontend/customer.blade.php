 @extends('layouts.front')
 @section('title', 'Home page')

 @section('title', 'Contact Us & Customer Inquirie')
 @section('meta')
 @php
 $pageTitle = 'Contact Us & Customer Inquiries – ' . ($setting->title ?? 'Bhaiya Housing Ltd.');
 $pageDesc = 'Get in touch with Bhaiya Housing Ltd. for customer inquiries, property bookings, and support. We are here to assist you with finding your dream real estate property in Bangladesh.';
 $pageUrl = url()->current();
 $pageImage = isset($contactHero->img_path) ? asset($contactHero->img_path) : asset('assets/images/contact-customer.jpg');

 // Safe fallback for socials
 $socialLinks = isset($socials) ? $socials->map(fn($s) => $s->url)->filter()->values()->toArray() : [];

 $schema = [
 "page" => [
 "description" => $pageDesc,
 "keywords" => implode(', ', [
 'Contact Bhaiya Housing',
 'real estate customer support Dhaka',
 'property inquiries Bangladesh',
 'buy flat contact Dhaka',
 'real estate developer contact number',
 'Bhaiya Group office address',
 'apartment booking inquiries'
 ]),
 "robots" => "index, follow, max-image-preview:large",
 "canonical" => $pageUrl,
 ],
 "openGraph" => [
 "type" => "website",
 "title" => $pageTitle,
 "description" => $pageDesc,
 "url" => $pageUrl,
 "site_name" => $setting->title ?? 'Bhaiya Housing Ltd.',
 "image" => $pageImage,
 "locale" => "en_US",
 ],
 "twitter" => [
 "card" => "summary_large_image",
 "title" => $pageTitle,
 "description" => $pageDesc,
 "image" => $pageImage,
 ],
 "organization" => [
 "@context" => "https://schema.org",
 "@type" => ["RealEstateBuilder", "Organization", "LocalBusiness"],
 "@id" => url('/') . '#organization',
 "name" => $setting->title ?? 'Bhaiya Housing Ltd.',
 "url" => url('/'),
 "logo" => [
 "@type" => "ImageObject",
 "url" => asset('assets/images/logo.png'),
 "width" => 200,
 "height" => 60,
 ],
 "telephone" => $setting->extra ?? '',
 "email" => $setting->body ?? '', // Fallback based on your UI setup
 "address" => [
 "@type" => "PostalAddress",
 "streetAddress" => $setting->short ?? 'Dhaka, Bangladesh',
 "addressLocality" => "Dhaka",
 "addressCountry" => "BD"
 ],
 "contactPoint" => [
 "@type" => "ContactPoint",
 "telephone" => $setting->extra ?? '',
 "contactType" => "customer service",
 "email" => $setting->body ?? '',
 "availableLanguage" => ["English", "Bengali"]
 ],
 "sameAs" => $socialLinks,
 ],
 "webPage" => [
 "@context" => "https://schema.org",
 "@type" => "ContactPage",
 "@id" => $pageUrl . '#webpage',
 "name" => $pageTitle,
 "description" => $pageDesc,
 "url" => $pageUrl,
 "inLanguage" => "en-US",
 "isPartOf" => ["@id" => url('/') . '#website'],
 "about" => ["@id" => url('/') . '#organization'],
 "breadcrumb" => [
 "@type" => "BreadcrumbList",
 "itemListElement" => [
 ["@type" => "ListItem", "position" => 1, "name" => "Home", "item" => url('/')],
 ["@type" => "ListItem", "position" => 2, "name" => "Contact Us", "item" => $pageUrl],
 ],
 ],
 ]
 ];
 @endphp

 {{-- META --}}
 <meta name="description" content="{{ $schema['page']['description'] }}">
 <meta name="keywords" content="{{ $schema['page']['keywords'] }}">
 <meta name="robots" content="{{ $schema['page']['robots'] }}">
 <link rel="canonical" href="{{ $schema['page']['canonical'] }}">

 {{-- OPEN GRAPH --}}
 <meta property="og:type" content="{{ $schema['openGraph']['type'] }}">
 <meta property="og:title" content="{{ $schema['openGraph']['title'] }}">
 <meta property="og:description" content="{{ $schema['openGraph']['description'] }}">
 <meta property="og:url" content="{{ $schema['openGraph']['url'] }}">
 <meta property="og:site_name" content="{{ $schema['openGraph']['site_name'] }}">
 <meta property="og:image" content="{{ $schema['openGraph']['image'] }}">
 <meta property="og:locale" content="{{ $schema['openGraph']['locale'] }}">

 {{-- TWITTER --}}
 <meta name="twitter:card" content="{{ $schema['twitter']['card'] }}">
 <meta name="twitter:title" content="{{ $schema['twitter']['title'] }}">
 <meta name="twitter:description" content="{{ $schema['twitter']['description'] }}">
 <meta name="twitter:image" content="{{ $schema['twitter']['image'] }}">

 {{-- SCHEMAS --}}
 <script type="application/ld+json">
     {
         !!json_encode($schema['organization'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!
     }
 </script>

 <script type="application/ld+json">
     {
         !!json_encode($schema['webPage'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!
     }
 </script>
 @endsection
 @section('content')

 {{-- ===== HERO ===== --}}
 <section class="hero-fixed fixed top-0 left-0 w-full overflow-hidden
                h-[85vh]"> <img src="{{ $contactHero?->img_path ?? asset('assets/images/contact-customer.jpg') }}"
         alt="Contact" class="absolute inset-0 w-full h-full object-cover" />
     <div class="absolute inset-0 bg-black/50"></div>

     <div class="absolute inset-0 flex items-center px-10 md:px-20">
         <h2 class="text-white font-light md:pl-12 md:pt-32" style="font-size:3.85vw; line-height:1.2; font-weight:500;">
             We're here to assist you <br> with <span class="font-migra-italic">any inquiries</span>

         </h2>
     </div>

 </section>
 <div class="h-[85vh] w-full pointer-events-none"
     style="position: relative; z-index: 2;"></div>

 {{-- ── Top Bar ── --}}
 <div class="w-full relative z-10 flex flex-col md:flex-row md:items-center gap-4 md:gap-6 py-8 md:py-0 md:h-40 px-6 sm:px-10 md:px-16 lg:px-[100px]"
     style="background:#152018;">

     <p class="text-white font-medium text-xl md:text-2xl md:mr-auto">Let's talk!</p>

     <div class="flex flex-col sm:flex-row flex-wrap gap-4 md:gap-6">

         @if($setting?->body)
         <div class="flex items-center gap-2 text-white text-base md:text-xl font-light opacity-80">
             <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                 <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0118 0z" />
                 <circle cx="12" cy="10" r="3" />
             </svg>
             <span>{!! $setting->body !!}</span>
         </div>
         @endif

         @if($setting?->extra)
         <div class="flex items-center gap-2 text-white text-base md:text-xl font-light opacity-80">
             <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                 <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81 19.79 19.79 0 01.19 1.22 2 2 0 012.18 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.91 7.09a16 16 0 006 6l.56-.56a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z" />
             </svg>
             <span>{{ $setting->extra }}</span>
         </div>
         @endif

         @if($setting?->short)
         <div class="flex items-center gap-2 text-white text-base md:text-xl font-light opacity-80">
             <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                 <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                 <polyline points="22,6 12,13 2,6" />
             </svg>
             <span>{{ $setting->short }}</span>
         </div>
         @endif

     </div>
 </div>

 {{-- ── Main Section ── --}}
 <section class="relative w-full overflow-hidden py-20" style="background:#F6F6F6;">
     <div class="absolute inset-0 pointer-events-none" style="z-index:0;">
         <img src="/assets/images/bg-news.png" alt=""
             class="w-1/3 h-full object-cover opacity-50"
             onerror="this.style.display='none';" />
     </div>

     <div class="relative z-10 container mx-auto px-6 lg:px-14">
         <div class="flex flex-col md:flex-row gap-16 items-start">

             <!-- ── Left: Images ── -->
             <div class="w-full md:w-5/12 relative" style="height:360px; flex-shrink:0;">

                 <!-- Image 1: back-left -->
                 <div class="absolute overflow-hidden shadow-xl"
                     style="width:260px; height:310px; left:0; top:30px; z-index:1;">
                     <img src="{{ $contactImages[1]->img_path ?? asset('assets/images/contact-bottom.jpg') }}"
                         alt="{{ $contactImages[1]->title ?? 'Interior' }}"
                         class="w-full h-full object-cover"
                         onerror="this.parentElement.style.background='#b8b0a8'; this.style.display='none';" />
                 </div>
                 <div class="absolute overflow-hidden shadow-xl scroll-move" data-axis="Y"
                     style=" left:180px; top:80px; z-index:2;">
                     <img src="{{  asset('assets/images/middle-stone.png') }}"
                         alt="leaf"
                         class="w-full h-full object-cover"
                         onerror="this.parentElement.style.background='#b8b0a8'; this.style.display='none';" />
                 </div>

                 <!-- Image 2: front-right -->
                 <div class="absolute overflow-hidden shadow-2xl ml-16"
                     style="width:260px; height:310px; left:250px; top:80px; z-index:2;">
                     <img src="{{ $contactImages[0]->img_path ?? asset('assets/images/contact-top.jpg') }}"
                         alt="{{ $contactImages[0]->title ?? 'Dining' }}"
                         class="w-full h-full object-cover"
                         onerror="this.parentElement.style.background='#9a9290'; this.style.display='none';" />
                 </div>

             </div>


             <!-- ── Right: Contact Form ── -->
<div id="contact-section" class="w-full md:flex-1 pt-2">
                 <div class="absolute -right-32 -top-32 inset-y-0 mt-32 font-migra-italic  opacity-80 scroll-move" data-axis="-X" style="z-index:0;">
                     <span style=" font-size:clamp(80px,15vw,220px); font-weight:700; color:rgba(0,0,0,0.045);  letter-spacing: 4px; white-space:nowrap;">GetIn</span>

                 </div>

                 {{-- ── Success Message ── --}}
                 @if(session('success'))
                 <div id="successMsg"
                     class="flex items-center gap-3 mt-6 px-5 py-4 text-sm font-light"
                     style="background:#e6f0e7; border-left:3px solid #152018; color:#152018;">
                     <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                         <polyline points="20 6 9 17 4 12" />
                     </svg>
                     {{ session('success') }}
                 </div>
                 @endif
                 <form id="contactForm"
                     action="{{ route('contact.store') }}"
                     method="POST"
                     novalidate>
                     @csrf

                     {{-- Name --}}
                     <div class="mb-6" style="border-bottom:1px solid {{ $errors->has('name') ? '#c0392b' : '#b8b0a8' }};">
                         <input type="text" name="name"
                             value="{{ old('name') }}"
                             placeholder="Name *"
                             class="w-full bg-transparent text-sm font-light text-gray-700 py-3 outline-none placeholder-gray-400" />
                         @error('name')
                         <p class="text-xs mt-1" style="color:#c0392b;">{{ $message }}</p>
                         @enderror
                     </div>

                     {{-- Email + Phone --}}
                     <div class="flex gap-6 mb-6">
                         <div class="flex-1" style="border-bottom:1px solid {{ $errors->has('email') ? '#c0392b' : '#b8b0a8' }};">
                             <input type="email" name="email"
                                 value="{{ old('email') }}"
                                 placeholder="Email *"
                                 class="w-full bg-transparent text-sm font-light text-gray-700 py-3 outline-none placeholder-gray-400" />
                             @error('email')
                             <p class="text-xs mt-1" style="color:#c0392b;">{{ $message }}</p>
                             @enderror
                         </div>
                         <div class="flex-1" style="border-bottom:1px solid {{ $errors->has('phone') ? '#c0392b' : '#b8b0a8' }};">
                             <input type="tel" name="phone"
                                 value="{{ old('phone') }}"
                                 placeholder="Contact Number *"
                                 class="w-full bg-transparent text-sm font-light text-gray-700 py-3 outline-none placeholder-gray-400" />
                             @error('phone')
                             <p class="text-xs mt-1" style="color:#c0392b;">{{ $message }}</p>
                             @enderror
                         </div>
                     </div>

                     {{-- Subject --}}
                     <div class="mb-6" style="border-bottom:1px solid {{ $errors->has('subject') ? '#c0392b' : '#b8b0a8' }};">
                         <input type="text" name="subject"
                             value="{{ old('subject') }}"
                             placeholder="Subject *"
                             class="w-full bg-transparent text-sm font-light text-gray-700 py-3 outline-none placeholder-gray-400" />
                         @error('subject')
                         <p class="text-xs mt-1" style="color:#c0392b;">{{ $message }}</p>
                         @enderror
                     </div>

                     {{-- Message --}}
                     <div class="mb-8" style="border-bottom:1px solid {{ $errors->has('message') ? '#c0392b' : '#b8b0a8' }};">
                         <textarea rows="3" name="message"
                             placeholder="Message *"
                             class="w-full bg-transparent text-sm font-light text-gray-700 py-3 outline-none placeholder-gray-400 resize-none">{{ old('message') }}</textarea>
                         @error('message')
                         <p class="text-xs mt-1" style="color:#c0392b;">{{ $message }}</p>
                         @enderror
                     </div>

                     {{-- Submit --}}
                     <button type="submit"
                         class="px-10 py-3 text-sm font-light tracking-widest text-white transition-all duration-300 hover:opacity-80"
                         style="background:#152018; letter-spacing:0.08em;">
                         Submit
                     </button>
                     <div class="absolute right-32 -bottom-64 mt-64 inset-y-0  font-migra-italic opacity-80 scroll-move" data-axis="X" style="z-index:0;">

                         <span style="font-size:clamp(80px,15vw,220px); font-weight:700; color:rgba(0,0,0,0.045); line-height:0.9; white-space:nowrap;">Touch</span>
                     </div>
                 </form>

             </div>
         </div>
     </div>
 </section>

 @if($errors->any() || session('success'))
 <script>
     document.addEventListener('DOMContentLoaded', function() {
         const form = document.getElementById('contactForm');
         if (form) {
             form.scrollIntoView({
                 behavior: 'smooth',
                 block: 'start'
             });
         }
     });
 </script>
 @endif






 @endsection

 @push('scripts')
 <script>
     document.addEventListener('DOMContentLoaded', function() {

         if (typeof fbq !== 'undefined') {
             fbq('track', 'ViewContent', {
                 content_name: 'Contact Page',
                 content_category: 'Customer Support'
             });
         }

     });
 </script>
 @endpush

 @push('pixel_events')
 @if(session('success'))
 fbq('track', 'Contact');
 @endif
 @endpush