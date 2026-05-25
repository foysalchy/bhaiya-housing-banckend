 @extends('layouts.front')
 @section('title', $project->title ?? 'Premium Project')
 @section('meta')
 @php
 $projectName = $project->title ?? 'Premium Project';
 $pageTitle = $projectName . ' – ' . ($setting->title ?? 'Bhaiya Housing Ltd.');

 // Create a strong description based on available project data
 $pageDesc = isset($project->short) && !empty($project->short)
 ? strip_tags($project->short)
 : "Explore {$projectName}, a premium real estate project by Bhaiya Housing Ltd." . (isset($project->location) ? " located in {$project->location}." : " offering modern facilities for comfortable living.");

 $pageUrl = url()->current();
 $pageImage = isset($imgPaths[0]) ? asset($imgPaths[0]) : asset('assets/images/d1.avif');

 // Safe fallback for socials
 $socialLinks = isset($socials) ? $socials->map(fn($s) => $s->url)->filter()->values()->toArray() : [];

 // Base Project Schema
 $projectSchema = [
 "@context" => "https://schema.org",
 "@type" => ["ApartmentComplex", "RealEstateListing", "Place"],
 "name" => $projectName,
 "description" => $pageDesc,
 "image" => $pageImage,
 "url" => $pageUrl,
 "address" => [
 "@type" => "PostalAddress",
 "addressLocality" => $project->location ?? 'Bangladesh',
 "addressCountry" => "BD"
 ],
 ];

 // Add optional properties if they exist
 if (!empty($extra['map_url'])) {
 $projectSchema['hasMap'] = $extra['map_url'];
 }
 if (!empty($extra['size'])) {
 $projectSchema['tourBookingPage'] = url('/customer-contact'); // General CTA
 }

 $schema = [
 "page" => [
 "description" => Str::limit($pageDesc, 160),
 "keywords" => implode(', ', array_filter([
 $projectName,
 isset($project->location) ? "luxury apartments in {$project->location}" : null,
 isset($project->location) ? "real estate {$project->location}" : null,
 'Bhaiya Housing projects',
 isset($extra['status']) ? $extra['status'] . ' projects in Bangladesh' : null,
 'buy flat Dhaka',
 'premium residential properties'
 ])),
 "robots" => "index, follow, max-image-preview:large",
 "canonical" => $pageUrl,
 ],
 "openGraph" => [
 "type" => "article",
 "title" => $pageTitle,
 "description" => Str::limit($pageDesc, 160),
 "url" => $pageUrl,
 "site_name" => $setting->title ?? 'Bhaiya Housing Ltd.',
 "image" => $pageImage,
 "locale" => "en_US",
 ],
 "twitter" => [
 "card" => "summary_large_image",
 "title" => $pageTitle,
 "description" => Str::limit($pageDesc, 160),
 "image" => $pageImage,
 ],
 "organization" => [
 "@context" => "https://schema.org",
 "@type" => ["RealEstateBuilder", "Organization"],
 "@id" => url('/') . '#organization',
 "name" => $setting->title ?? 'Bhaiya Housing Ltd.',
 "url" => url('/'),
 "logo" => [
 "@type" => "ImageObject",
 "url" => asset('assets/images/logo.png'),
 "width" => 200,
 "height" => 60,
 ],
 "sameAs" => $socialLinks,
 ],
 "webPage" => [
 "@context" => "https://schema.org",
 "@type" => "ItemPage",
 "@id" => $pageUrl . '#webpage',
 "name" => $pageTitle,
 "description" => Str::limit($pageDesc, 160),
 "url" => $pageUrl,
 "inLanguage" => "en-US",
 "isPartOf" => ["@id" => url('/') . '#website'],
 "about" => ["@id" => url('/') . '#organization'],
 "breadcrumb" => [
 "@type" => "BreadcrumbList",
 "itemListElement" => [
 ["@type" => "ListItem", "position" => 1, "name" => "Home", "item" => url('/')],
 ["@type" => "ListItem", "position" => 2, "name" => "Projects", "item" => url('/projects')],
 ["@type" => "ListItem", "position" => 3, "name" => $projectName, "item" => $pageUrl],
 ],
 ],
 ],
 "project" => $projectSchema,
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

 <script type="application/ld+json">
     {
         !!json_encode($schema['project'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!
     }
 </script>
 @endsection
 @section('content')
 <section class="hero-fixed fixed top-0 left-0 w-full overflow-hidden
                h-[600px] md:h-[700px] lg:h-[900px]">
     <img src="{{ $imgPaths[0] ?? asset('assets/images/d1.avif') }}"
         alt="{{ $project->title }}"
         class="absolute inset-0 w-full h-full object-cover" />
     <div class="absolute inset-0 bg-black/50"></div>
     <div class="absolute inset-0 flex items-center px-6 sm:px-10 md:px-20">
         <h2 class="text-white font-light pl-4 sm:pl-8 md:pl-12 pt-16 sm:pt-24 md:pt-32"
             style="font-size: clamp(32px, 3.85vw, 90px); line-height: 1.2;">
             {{$project->title}}
         </h2>
     </div>
 </section>
 <div class="h-[600px] md:h-[700px] lg:h-[900px] w-full pointer-events-none"
     style="position: relative; z-index: 2;"></div>

 {{-- ===== AT A GLANCE ===== --}}
 <section class="relative z-10 w-full" style="background:#ffffff; font-family:'Jost',sans-serif;">


     <div class="absolute inset-0 pointer-events-none overflow-hidden" style="z-index:0;">
         <div class="absolute right-0 top-0 w-1/3 h-full opacity-50"
             style="background-image: url('/assets/images/bg-news.png'); background-repeat: repeat-y; background-size: 100% auto;">
         </div>
     </div>
     <div class="container mx-auto px-6 lg:px-14 py-20">
         <div class="flex flex-col md:flex-row gap-16 items-start">

             <!-- Left: Content -->
             <div class="w-full md:w-1/2">
                 <p class="text-sm font-light text-gray-500 mb-6 tracking-wide">
                     @if($project->body_3)
                     {{ $project->body_3 }}
                     @else
                 {{ $project->title }}
                 @endif
                 </p>
                 <h2 class="font-light text-gray-700 mb-12"
                     style="font-size:clamp(36px,5vw,72px); font-family:'Jost',sans-serif; font-weight:300;">
                     At a glance
                 </h2>

                 <div style="border-top:1px solid #e0dbd4;">

                     @if($project->location)
                     <div class="flex gap-8 py-4" style="border-bottom:1px solid #e0dbd4;">
                         <p class="text-sm font-light text-gray-500 w-40 flex-shrink-0">Location</p>
                         <p class="text-sm font-light text-gray-700">{{ $project->location }}</p>
                     </div>
                     @endif

                     @if($project->short)
                     <div class="flex gap-8 py-4" style="border-bottom:1px solid #e0dbd4;">
                         <p class="text-sm font-light text-gray-500 w-40 flex-shrink-0">Project Type</p>
                         <p class="text-sm font-light text-gray-700">{{ $project->short }}</p>
                     </div>
                     @endif

                     @if(!empty($extra['size']))
                     <div class="flex gap-8 py-4" style="border-bottom:1px solid #e0dbd4;">
                         <p class="text-sm font-light text-gray-500 w-40 flex-shrink-0">Size</p>
                         <div class="text-sm font-light text-gray-700">
                             @php
                             $sizes = is_array($extra['size']) ? $extra['size'] : [$extra['size']];
                             $sizes = array_filter($sizes, fn($v) => trim($v) !== '');
                             @endphp
                             @foreach($sizes as $size)
                             <p class="mb-1">{{ $size }}</p>
                             @endforeach
                         </div>
                     </div>
                     @endif

                     @if(!empty($extra['building_height']))
                     <div class="flex gap-8 py-4" style="border-bottom:1px solid #e0dbd4;">
                         <p class="text-sm font-light text-gray-500 w-40 flex-shrink-0">Building Height</p>
                         <p class="text-sm font-light text-gray-700">{{ $extra['building_height'] }}</p>
                     </div>
                     @endif

                     @if(!empty($extra['facing']))
                     <div class="flex gap-8 py-4" style="border-bottom:1px solid #e0dbd4;">
                         <p class="text-sm font-light text-gray-500 w-40 flex-shrink-0">Facing</p>
                         <p class="text-sm font-light text-gray-700">{{ $extra['facing'] }}</p>
                     </div>
                     @endif

                     @if(!empty($extra['status']))
                     <div class="flex gap-8 py-4" style="border-bottom:1px solid #e0dbd4;">
                         <p class="text-sm font-light text-gray-500 w-40 flex-shrink-0">Status</p>
                         <p class="text-sm font-light text-gray-700">{{ ucfirst($extra['status']) }}</p>
                     </div>
                     @endif

                 </div>
             </div>

             <!-- Right: Image -->
             <div class="hidden md:block md:w-1/3 h-[350px] md:h-[600px] relative scroll-move" data-axis="Y" style="margin-top: -20%;z-index:100">
                 <img src="{{ $imgPaths[1] ?? asset('assets/images/d1.avif') }}"
                     alt="{{ $project->title }}"
                     class="w-full object-cover shadow-2xl"
                     style="height: clamp(500px, 70vh, 800px);"
                     onerror="this.parentElement.style.background='#c0b8b0'; this.style.display='none';" />
             </div>

         </div>
     </div>
 </section>

 {{-- ===== GALLERY (2 images) ===== --}}
 @if(!empty($imgPaths[2]) || !empty($imgPaths[3]))
 <section class="relative z-10 w-full overflow-hidden py-10 md:py-16" style="background:#ffffff;">
     <div class="container mx-auto px-6 lg:px-14">
         <div class="relative flex flex-col md:flex-row gap-6 md:gap-8 items-start">

             <!-- Left Image -->
             <div class="relative w-full md:w-1/2">
                 <img src="{{ $imgPaths[2] ?? asset('assets/images/g1.avif') }}"
                     alt="Gallery 1"
                     class="w-full object-cover shadow-lg"
                     style="height: clamp(220px, 40vw, 500px);"
                     onerror="this.parentElement.style.background='#c0b8b0'; this.style.display='none';" />

                 <!-- Left stone -->
                 <img src="/assets/images/projectDetailsLeft-stone.png" alt=""
                     class="absolute pointer-events-none float-down scroll-move"
                     data-axis="Y"
                     style="width: clamp(60px, 8vw, 150px);
                           height: clamp(60px, 8vw, 150px);
                           bottom: clamp(-30px, -3vw, -20px);
                           left: clamp(-20px, -3vw, -60px);
                           z-index: 2;"
                     onerror="this.style.display='none';" />
             </div>

             <!-- Right Image -->
             <div class="relative w-full md:w-1/2">
                 <img src="{{ $imgPaths[3] ?? asset('assets/images/g2.avif') }}"
                     alt="Gallery 2"
                     class="w-full object-cover shadow-lg"
                     style="height: clamp(220px, 40vw, 500px);"
                     onerror="this.parentElement.style.background='#b0b8b8'; this.style.display='none';" />

                 <!-- Right stone -->
                 <img src="/assets/images/projectDetailsRight-stone.png" alt=""
                     class="absolute pointer-events-none float-up scroll-move"
                     data-axis="Y"
                     style="width: clamp(60px, 8vw, 150px);
                           height: clamp(60px, 8vw, 150px);
                           top: clamp(-16px, -2vw, -24px);
                           right: clamp(-16px, -3vw, -50px);
                           z-index: 2;"
                     onerror="this.style.display='none';" />
             </div>

         </div>
     </div>
 </section>
 @endif
 <section class="relative z-10 w-full overflow-hidden" style="font-family:'Jost',sans-serif;">

     <!-- BG Image -->
     <div class="absolute inset-0" style="z-index:0;">
         <img src="/assets/images/bg1.jpg" alt="" class="w-full h-full object-cover"
             onerror="this.style.display='none';" />
         <div class="absolute inset-0" style="background:rgba(13,26,17,0.88);"></div>
     </div>

     <!-- Content -->
     <div class="relative z-10 container mx-auto px-6 lg:px-14 pt-16 pb-0">

         <!-- Heading -->
         <h2 class="text-white font-light mb-16" style="font-size:clamp(24px,4vw,56px); font-weight:300;">
             Modern facilities for comfortable living
         </h2>

         <!-- Grid -->
         <div class="w-full" style="border-top:1px solid rgba(255,255,255,0.15);">

             <!-- Row 1 -->
             <div class="flex" style="border-bottom:1px solid rgba(255,255,255,0.15);">

                 <!-- Spacious Apartments -->
                 <div
                     class="flex-1 flex flex-col justify-between py-10 pr-8 hover:bg-white/5 transition-all duration-300 cursor-pointer"
                     style="border-right:1px solid rgba(255,255,255,0.15);">
                     <svg class="w-8 h-8 mb-16 opacity-80" viewBox="0 0 32 32" fill="none" stroke="white" stroke-width="1.5"
                         stroke-linecap="round" stroke-linejoin="round">
                         <rect x="4" y="8" width="24" height="20" rx="1" />
                         <path d="M10 28V20h12v8" />
                         <path d="M4 14h24" />
                         <path d="M13 8V4h6v4" />
                     </svg>
                     <p class="text-white text-xs font-light uppercase opacity-80"
                         style="letter-spacing:0.1em; line-height:1.8;">Spacious 2,250 Sq. Ft.<br />Apartments</p>
                 </div>

                 <!-- Smart Access -->
                 <div
                     class="flex-1 flex flex-col justify-between py-10 px-8 hover:bg-white/5 transition-all duration-300 cursor-pointer"
                     style="border-right:1px solid rgba(255,255,255,0.15);">
                     <svg class="w-8 h-8 mb-16 opacity-80" viewBox="0 0 32 32" fill="none" stroke="white" stroke-width="1.5"
                         stroke-linecap="round" stroke-linejoin="round">
                         <circle cx="16" cy="16" r="10" />
                         <circle cx="16" cy="16" r="4" />
                         <path d="M16 2v4M16 26v4M2 16h4M26 16h4" />
                     </svg>
                     <p class="text-white text-xs font-light uppercase opacity-80"
                         style="letter-spacing:0.1em; line-height:1.8;">Smart Access Control &amp;<br />Fire Safety</p>
                 </div>

                 <!-- Gym & Rooftop -->
                 <div
                     class="flex-1 flex flex-col justify-between py-10 px-8 hover:bg-white/5 transition-all duration-300 cursor-pointer"
                     style="border-right:1px solid rgba(255,255,255,0.15);">
                     <svg class="w-8 h-8 mb-16 opacity-80" viewBox="0 0 32 32" fill="none" stroke="white" stroke-width="1.5"
                         stroke-linecap="round" stroke-linejoin="round">
                         <path d="M4 16h4M24 16h4M8 16h2V10h4v12h4V10h4v6h2" />
                         <circle cx="4" cy="16" r="2" />
                         <circle cx="28" cy="16" r="2" />
                     </svg>
                     <p class="text-white text-xs font-light uppercase opacity-80"
                         style="letter-spacing:0.1em; line-height:1.8;">Modern Gym &amp;<br />Rooftop Garden</p>
                 </div>

                 <!-- Children's Play Area -->
                 <div
                     class="flex-1 flex flex-col justify-between py-10 px-8 hover:bg-white/5 transition-all duration-300 cursor-pointer"
                     style="border-right:1px solid rgba(255,255,255,0.15);">
                     <svg class="w-8 h-8 mb-16 opacity-80" viewBox="0 0 32 32" fill="none" stroke="white" stroke-width="1.5"
                         stroke-linecap="round" stroke-linejoin="round">
                         <circle cx="16" cy="8" r="4" />
                         <path d="M10 28v-8a6 6 0 0112 0v8" />
                         <path d="M6 22h4M22 22h4" />
                     </svg>
                     <p class="text-white text-xs font-light uppercase opacity-80"
                         style="letter-spacing:0.1em; line-height:1.8;">Children's Play Area &amp;<br />Easy City Access</p>
                 </div>

                 <!-- Walking Paths -->
                 <div
                     class="flex-1 flex flex-col justify-between py-10 pl-8 hover:bg-white/5 transition-all duration-300 cursor-pointer">
                     <svg class="w-8 h-8 mb-16 opacity-80" viewBox="0 0 32 32" fill="none" stroke="white" stroke-width="1.5"
                         stroke-linecap="round" stroke-linejoin="round">
                         <path d="M6 28L16 8l10 20" />
                         <path d="M10 20h12" />
                         <path d="M16 8V4" />
                         <path d="M13 4h6" />
                     </svg>
                     <p class="text-white text-xs font-light uppercase opacity-80"
                         style="letter-spacing:0.1em; line-height:1.8;">Walking Paths &amp;<br />Landscaped Surroundings</p>
                 </div>

             </div>

             <!-- Row 2 -->
             <div class="flex">

                 <!-- CCTV -->
                 <div
                     class="flex-1 flex flex-col justify-between py-10 pr-8 hover:bg-white/5 transition-all duration-300 cursor-pointer"
                     style="border-right:1px solid rgba(255,255,255,0.15);">
                     <svg class="w-8 h-8 mb-16 opacity-80" viewBox="0 0 32 32" fill="none" stroke="white" stroke-width="1.5"
                         stroke-linecap="round" stroke-linejoin="round">
                         <circle cx="16" cy="14" r="6" />
                         <circle cx="16" cy="14" r="2" />
                         <path d="M16 20v8M10 28h12" />
                         <path d="M8 8l-4-4M24 8l4-4" />
                     </svg>
                     <p class="text-white text-xs font-light uppercase opacity-80"
                         style="letter-spacing:0.1em; line-height:1.8;">24/7 Security &amp;<br />CCTV Surveillance</p>
                 </div>

                 <!-- Elevator -->
                 <div
                     class="flex-1 flex flex-col justify-between py-10 px-8 hover:bg-white/5 transition-all duration-300 cursor-pointer"
                     style="border-right:1px solid rgba(255,255,255,0.15);">
                     <svg class="w-8 h-8 mb-16 opacity-80" viewBox="0 0 32 32" fill="none" stroke="white" stroke-width="1.5"
                         stroke-linecap="round" stroke-linejoin="round">
                         <rect x="6" y="2" width="20" height="28" rx="1" />
                         <path d="M12 12l4-4 4 4M12 20l4 4 4-4" />
                         <line x1="16" y1="8" x2="16" y2="24" />
                     </svg>
                     <p class="text-white text-xs font-light uppercase opacity-80"
                         style="letter-spacing:0.1em; line-height:1.8;">High-Speed Elevators &amp;<br />Power Backup</p>
                 </div>

                 <!-- Parking -->
                 <div
                     class="flex-1 flex flex-col justify-between py-10 px-8 hover:bg-white/5 transition-all duration-300 cursor-pointer"
                     style="border-right:1px solid rgba(255,255,255,0.15);">
                     <svg class="w-8 h-8 mb-16 opacity-80" viewBox="0 0 32 32" fill="none" stroke="white" stroke-width="1.5"
                         stroke-linecap="round" stroke-linejoin="round">
                         <rect x="2" y="10" width="28" height="16" rx="2" />
                         <path d="M8 26v4M24 26v4" />
                         <path d="M2 16h28" />
                         <circle cx="9" cy="22" r="2" />
                         <circle cx="23" cy="22" r="2" />
                     </svg>
                     <p class="text-white text-xs font-light uppercase opacity-80"
                         style="letter-spacing:0.1em; line-height:1.8;">Secure Parking &amp;<br />Community Hall</p>
                 </div>

                 <!-- Maintenance -->
                 <div
                     class="flex-1 flex flex-col justify-between py-10 px-8 hover:bg-white/5 transition-all duration-300 cursor-pointer"
                     style="border-right:1px solid rgba(255,255,255,0.15);">
                     <svg class="w-8 h-8 mb-16 opacity-80" viewBox="0 0 32 32" fill="none" stroke="white" stroke-width="1.5"
                         stroke-linecap="round" stroke-linejoin="round">
                         <circle cx="16" cy="16" r="4" />
                         <path
                             d="M16 2v4M16 26v4M2 16h4M26 16h4M6.34 6.34l2.83 2.83M22.83 22.83l2.83 2.83M6.34 25.66l2.83-2.83M22.83 9.17l2.83-2.83" />
                     </svg>
                     <p class="text-white text-xs font-light uppercase opacity-80"
                         style="letter-spacing:0.1em; line-height:1.8;">Dedicated Maintenance<br />Team</p>
                 </div>

                 <!-- Retail -->
                 <div
                     class="flex-1 flex flex-col justify-between py-10 pl-8 hover:bg-white/5 transition-all duration-300 cursor-pointer">
                     <svg class="w-8 h-8 mb-16 opacity-80" viewBox="0 0 32 32" fill="none" stroke="white" stroke-width="1.5"
                         stroke-linecap="round" stroke-linejoin="round">
                         <path d="M4 6h24l-2 10H6L4 6z" />
                         <path d="M6 16v10h20V16" />
                         <path d="M13 28v-6h6v6" />
                         <path d="M4 6H2M30 6h-2" />
                     </svg>
                     <p class="text-white text-xs font-light uppercase opacity-80"
                         style="letter-spacing:0.1em; line-height:1.8;">Convenient Retail and<br />Dining Spaces Nearby</p>
                 </div>

             </div>

         </div>
     </div>

 </section>
 @if(!empty($project->body) || !empty($project->body_2))
 <section class="relative z-10 w-full overflow-hidden py-32 bg-[#F6F6F6]">

     <!-- Background Decoration Image -->
     <div class="absolute inset-0 pointer-events-none z-0">
         <img src="{{ asset('images/career-bg.png') }}" alt="" class="w-full h-full object-cover">
     </div>

     <div class="relative z-10 max-w-7xl mx-auto px-6">

         <div class="flex flex-col md:flex-row items-start gap-10 pt-8">

             <!-- Left Column: body -->
             @if(!empty($project->body))
             <div class="w-full md:w-1/2 text-gray-800 prose max-w-none  scroll-move" data-axis="-Y">
                 {!! $project->body !!}
             </div>
             @endif

             <!-- Right Column: body_2 -->
             @if(!empty($project->body_2))
             <div class="w-full md:w-1/2 text-gray-800 prose max-w-none scroll-move" data-axis="Y">
                 {!! $project->body_2 !!}
             </div>
             @endif

         </div>

     </div>
 </section>
 @endif
 {{-- ===== GALLERY SLIDER ===== --}}
 @if($sliderTotal > 0)
 <section class="relative z-10 w-full overflow-hidden py-10 lg:py-20" style="background:#fff; min-height: 500px;">

     <!-- Background "Gallery" Text -->
     <div class="absolute top-0 right-0 pointer-events-none select-none overflow-hidden" style="z-index:0;">
         <span style="font-family:'Cormorant Garamond',serif; font-size:clamp(100px,20vw,280px); font-weight:700; color:rgba(0,0,0,0.05); white-space:nowrap; line-height:1;">Gallery</span>
     </div>

     <!-- Slider Track -->
     <div class="relative z-10 w-full flex items-start gap-2 lg:gap-3 overflow-hidden px-0"
         style="height: clamp(300px, 45vw, 520px);">

         <!-- Far Left (half outside, smallest) -->
         <div class="flex-shrink-0 overflow-hidden cursor-pointer relative group"
             style="width: clamp(50px, 7vw, 110px); height: 68%; margin-left: -30px; align-self: flex-start;"
             onclick="galleryGoTo((galleryState.active - 2 + galleryState.total) % galleryState.total)">
             <img id="leftImg1" src="" alt=""
                 class="w-full h-full object-cover block transition-all duration-700 group-hover:scale-105"
                 style="filter:brightness(0.5);" />
         </div>

         <!-- Left (medium height) -->
         <div class="flex-shrink-0 overflow-hidden cursor-pointer relative group"
             style="width: 25%; height: 68%; align-self: flex-start;"
             onclick="galleryGoTo((galleryState.active - 1 + galleryState.total) % galleryState.total)">
             <img id="leftImg2" src="" alt=""
                 class="w-full h-full object-cover block transition-all duration-700 group-hover:scale-105"
                 style="filter:brightness(0.52);" />
         </div>

         <!-- Center (tallest, full height) -->
         <div class="flex-1 overflow-hidden cursor-pointer relative group"
             style="height: 100%; align-self: flex-start;"
             onclick="galleryOpenLightbox(galleryState.active)">
             <img id="centerImg" src="" alt=""
                 class="w-full h-full object-cover block"
                 style="filter:brightness(1); transition: opacity 0.4s ease, transform 0.55s ease;" />
             <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all duration-500 flex items-center justify-center">
                 <div class="opacity-0 group-hover:opacity-100 transition-all duration-300 bg-white/20 backdrop-blur-sm rounded-full p-3">
                     <svg width="22" height="22" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
                         <circle cx="11" cy="11" r="8" />
                         <path d="m21 21-4.35-4.35M11 8v6M8 11h6" />
                     </svg>
                 </div>
             </div>
         </div>

         <!-- Right (medium height) -->
         <div class="flex-shrink-0 overflow-hidden cursor-pointer relative group"
             style="width: clamp(70px, 11vw, 170px); height: 52%; align-self: flex-start;"
             onclick="galleryGoTo((galleryState.active + 1) % galleryState.total)">
             <img id="rightImg1" src="" alt=""
                 class="w-full h-full object-cover block transition-all duration-700 group-hover:scale-105"
                 style="filter:brightness(0.52);" />
         </div>

         <!-- Far Right (half outside, smallest) -->
         <div class="flex-shrink-0 overflow-hidden cursor-pointer relative group"
             style="width: clamp(50px, 7vw, 110px); height: 52%; margin-right: -30px; align-self: flex-start;"
             onclick="galleryGoTo((galleryState.active + 2) % galleryState.total)">
             <img id="rightImg2" src="" alt=""
                 class="w-full h-full object-cover block transition-all duration-700 group-hover:scale-105"
                 style="filter:brightness(0.5);" />
         </div>

     </div>

     <!-- Controls -->
     <div class="relative z-10 flex items-center gap-6 mt-10 px-6 lg:px-16">

         <!-- Progress bar -->
         <div class="w-32 lg:w-56 h-[1px] bg-gray-400 relative flex-shrink-0">
             <div id="galleryProgress"
                 class="absolute left-0 top-0 h-[1px] bg-black transition-all duration-700"
                 style="width:0%;"></div>
         </div>

         <!-- Counter -->
         <span id="galleryCounter"
             class="text-xs tracking-widest text-gray-500 flex-shrink-0"
             style="font-family:'Cormorant Garamond',serif;">01 / 01</span>

         <!-- Arrows -->
         <div class="flex gap-3 flex-shrink-0">
             <button onclick="galleryMove(-1)" aria-label="Previous"
                 class="w-9 h-9 rounded-full border border-gray-400 flex items-center justify-center hover:bg-black hover:border-black group transition-all duration-300">
                 <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     class="text-gray-600 group-hover:text-white transition-colors">
                     <path d="M15 18l-6-6 6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                 </svg>
             </button>
             <button onclick="galleryMove(1)" aria-label="Next"
                 class="w-9 h-9 rounded-full border border-gray-400 flex items-center justify-center hover:bg-black hover:border-black group transition-all duration-300">
                 <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     class="text-gray-600 group-hover:text-white transition-colors">
                     <path d="M9 18l6-6-6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                 </svg>
             </button>
         </div>

     </div>

 </section>

 <!-- ===== LIGHTBOX ===== -->
 <div id="galleryLightbox"
     class="fixed inset-0 z-[9999] items-center justify-center"
     style="display:none; background:rgba(0,0,0,0.95);">

     <div class="absolute top-5 right-5 z-10 flex gap-2">
         <button onclick="galleryZoom(0.8)" aria-label="Zoom Out"
             class="w-10 h-10 rounded-full border border-white/30 flex items-center justify-center text-white hover:bg-white/15 transition-all">
             <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                 <circle cx="11" cy="11" r="8" />
                 <path d="m21 21-4.35-4.35M8 11h6" />
             </svg>
         </button>
         <button onclick="galleryZoom(1.25)" aria-label="Zoom In"
             class="w-10 h-10 rounded-full border border-white/30 flex items-center justify-center text-white hover:bg-white/15 transition-all">
             <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                 <circle cx="11" cy="11" r="8" />
                 <path d="m21 21-4.35-4.35M11 8v6M8 11h6" />
             </svg>
         </button>
         <button onclick="galleryFullscreen()" aria-label="Fullscreen"
             class="w-10 h-10 rounded-full border border-white/30 flex items-center justify-center text-white hover:bg-white/15 transition-all">
             <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                 <path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3" />
             </svg>
         </button>
         <button onclick="galleryCloseLightbox()" aria-label="Close"
             class="w-10 h-10 rounded-full border border-white/30 flex items-center justify-center text-white hover:bg-white/15 transition-all">
             <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                 <path d="M18 6L6 18M6 6l12 12" />
             </svg>
         </button>
     </div>

     <button onclick="galleryLightboxMove(-1)" aria-label="Previous"
         class="absolute left-4 top-1/2 -translate-y-1/2 z-10 w-11 h-11 rounded-full border border-white/30 flex items-center justify-center text-white hover:bg-white/10 transition-all">
         <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
             <path d="M15 18l-6-6 6-6" stroke-linecap="round" stroke-linejoin="round" />
         </svg>
     </button>

     <button onclick="galleryLightboxMove(1)" aria-label="Next"
         class="absolute right-4 top-1/2 -translate-y-1/2 z-10 w-11 h-11 rounded-full border border-white/30 flex items-center justify-center text-white hover:bg-white/10 transition-all">
         <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
             <path d="M9 18l6-6-6-6" stroke-linecap="round" stroke-linejoin="round" />
         </svg>
     </button>

     <div class="w-full h-full flex items-center justify-center px-16 overflow-hidden">
         <img id="lightboxImg" src="" alt=""
             style="max-width:88vw; max-height:84vh; object-fit:contain; transform:scale(1); transition:transform 0.3s ease; transform-origin:center center; cursor:zoom-in;" />
     </div>

     <div class="absolute bottom-5 left-1/2 -translate-x-1/2 text-white/50 text-sm tracking-widest"
         id="lightboxCounter" style="font-family:'Cormorant Garamond',serif;"></div>
 </div>

 <script>
     (function() {
         const images = @json($sliderImages);
         const total = images.length;
         let autoTimer = null;

         window.galleryState = {
             active: 0,
             total,
             zoom: 1
         };

         function idx(n) {
             return ((n % total) + total) % total;
         }

         function updateGallery(immediate) {
             const a = galleryState.active;
             const centerImg = document.getElementById('centerImg');

             if (!immediate) {
                 centerImg.style.opacity = '0';
                 centerImg.style.transform = 'scale(1.04)';
             }

             setTimeout(() => {
                 document.getElementById('leftImg1').src = images[idx(a - 2)];
                 document.getElementById('leftImg2').src = images[idx(a - 1)];
                 centerImg.src = images[idx(a)];
                 document.getElementById('rightImg1').src = images[idx(a + 1)];
                 document.getElementById('rightImg2').src = images[idx(a + 2)];

                 centerImg.style.opacity = '1';
                 centerImg.style.transform = 'scale(1)';

                 document.getElementById('galleryProgress').style.width =
                     ((a + 1) / total * 100) + '%';

                 document.getElementById('galleryCounter').textContent =
                     String(a + 1).padStart(2, '0') + ' / ' + String(total).padStart(2, '0');

             }, immediate ? 0 : 350);
         }

         window.galleryMove = function(step) {
             galleryState.active = idx(galleryState.active + step);
             updateGallery(false);
             resetAuto();
         };

         window.galleryGoTo = function(i) {
             galleryState.active = idx(i);
             updateGallery(false);
             resetAuto();
         };

         // Lightbox
         window.galleryOpenLightbox = function() {
             galleryState.zoom = 1;
             const lb = document.getElementById('galleryLightbox');
             lb.style.display = 'flex';
             document.body.style.overflow = 'hidden';
             document.getElementById('lightboxImg').style.transform = 'scale(1)';
             updateLightbox();
         };

         window.galleryCloseLightbox = function() {
             document.getElementById('galleryLightbox').style.display = 'none';
             document.body.style.overflow = '';
             galleryState.zoom = 1;
         };

         window.galleryLightboxMove = function(step) {
             galleryState.active = idx(galleryState.active + step);
             galleryState.zoom = 1;
             document.getElementById('lightboxImg').style.transform = 'scale(1)';
             updateGallery(false);
             updateLightbox();
         };

         window.galleryZoom = function(factor) {
             galleryState.zoom = Math.min(Math.max(galleryState.zoom * factor, 0.5), 5);
             document.getElementById('lightboxImg').style.transform = `scale(${galleryState.zoom})`;
         };

         window.galleryFullscreen = function() {
             const el = document.getElementById('galleryLightbox');
             if (!document.fullscreenElement) el.requestFullscreen?.();
             else document.exitFullscreen?.();
         };

         function updateLightbox() {
             const a = galleryState.active;
             document.getElementById('lightboxImg').src = images[idx(a)];
             document.getElementById('lightboxCounter').textContent =
                 String(a + 1).padStart(2, '0') + ' / ' + String(total).padStart(2, '0');
         }

         // Auto slideshow — 4 seconds
         function startAuto() {
             autoTimer = setInterval(() => {
                 galleryState.active = idx(galleryState.active + 1);
                 updateGallery(false);
             }, 4000);
         }

         function resetAuto() {
             clearInterval(autoTimer);
             startAuto();
         }

         // Keyboard
         document.addEventListener('keydown', e => {
             const lb = document.getElementById('galleryLightbox');
             if (lb.style.display === 'none') return;
             if (e.key === 'ArrowRight') galleryLightboxMove(1);
             if (e.key === 'ArrowLeft') galleryLightboxMove(-1);
             if (e.key === 'Escape') galleryCloseLightbox();
             if (e.key === '+') galleryZoom(1.25);
             if (e.key === '-') galleryZoom(0.8);
         });

         document.getElementById('galleryLightbox').addEventListener('click', function(e) {
             if (e.target === this) galleryCloseLightbox();
         });

         document.addEventListener('DOMContentLoaded', () => {
             updateGallery(true);
             startAuto();
         });
         if (document.readyState !== 'loading') {
             updateGallery(true);
             startAuto();
         }
     })();
 </script>
 @endif

 {{-- ===== LOCATION ===== --}}
 @if($project->location)
 <section class="relative w-full flex flex-col md:flex-row"
     style="height:clamp(400px,55vw,600px); font-family:'Jost',sans-serif;">

     <div class="flex flex-col justify-between px-10 py-16 md:w-5/12 flex-shrink-0"
         style="background:#152018; padding-left:100px;">
         <h2 class="text-white font-light" style="font-size:clamp(32px,5vw,72px); font-weight:300;">
             Location
         </h2>
         <p class="text-white text-xl font-light opacity-70" style="line-height:1.8; max-width:380px;">
             {{ $project->location }}
         </p>
     </div>

     <div class="flex-1 relative">
         @if(!empty($extra['map_url']))
         <iframe src="{{ $extra['map_url'] }}"
             title="Project Location Map"
             class="w-full h-full border-0"
             allowfullscreen=""
             loading="lazy"
             referrerpolicy="no-referrer-when-downgrade">
         </iframe>
         @else
         <div class="w-full h-full flex items-center justify-center bg-gray-200">
             <p class="text-gray-500 text-sm">Map unavailable</p>
         </div>
         @endif
     </div>

 </section>
 @endif
 @endsection