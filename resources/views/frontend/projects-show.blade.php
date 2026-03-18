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
 <section class="relative w-full overflow-hidden" style="height: clamp(320px, 45vw, 560px);">
     <img src="{{ $imgPaths[0] ?? asset('assets/images/d1.avif') }}"
         alt="{{ $project->title }}"
         class="absolute inset-0 w-full h-full object-cover" />
     <div class="absolute inset-0 bg-black/50"></div>
     <div class="absolute inset-0 flex items-center px-10 md:px-20">
         <h2 class="text-white font-light" style="font-size:clamp(22px,3.5vw,52px); line-height:1.2;">
             {{$project->title}}
         </h2>
     </div>
 </section>

 {{-- ===== AT A GLANCE ===== --}}
 <section class="relative w-full" style="background:#ffffff; font-family:'Jost',sans-serif;">
     <div class="container mx-auto px-6 lg:px-14 py-20">
         <div class="flex flex-col md:flex-row gap-16 items-start">

             <!-- Left: Content -->
             <div class="w-full md:w-1/2">
                 <p class="text-xs font-light text-gray-400 mb-6 tracking-wide">
                     {{ $project->title }}
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
                         <p class="text-sm font-light text-gray-700">{{ $extra['size'] }}</p>
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
             <div class="hidden md:block md:w-1/2 relative" style="margin-top: -10%;">
                 <img src="{{ $imgPaths[0] ?? asset('assets/images/d1.avif') }}"
                     alt="{{ $project->title }}"
                     class="w-full object-cover shadow-2xl"
                     style="height: clamp(500px, 70vh, 800px);"
                     onerror="this.parentElement.style.background='#c0b8b0'; this.style.display='none';" />
             </div>

         </div>
     </div>
 </section>

 {{-- ===== GALLERY (2 images) ===== --}}
 @if(!empty($imgPaths[1]) || !empty($imgPaths[2]))
 <section class="relative w-full overflow-hidden py-16" style="background:#ffffff;">
     <div class="container mx-auto px-6 lg:px-14">
         <div class="relative flex flex-col md:flex-row gap-8 items-start">

             <!-- Left Image -->
             <div class="relative w-full md:w-1/2">
                 <img src="{{ $imgPaths[1] ?? asset('assets/images/g1.avif') }}"
                     alt="Gallery 1" class="w-full object-cover shadow-lg"
                     style="height:clamp(300px,40vw,500px);"
                     onerror="this.parentElement.style.background='#c0b8b0'; this.style.display='none';" />
                 <img src="/assets/images/projectDetailsLeft-stone.png" alt=""
                     class="absolute pointer-events-none float-down"
                     style="width:80px; bottom:-20px; left:-20px; z-index:2;"
                     onerror="this.style.display='none';" />
             </div>

             <!-- Right Image -->
             <div class="relative w-full md:w-1/2">
                 <img src="{{ $imgPaths[2] ?? asset('assets/images/g2.avif') }}"
                     alt="Gallery 2" class="w-full object-cover shadow-lg"
                     style="height:clamp(300px,40vw,500px);"
                     onerror="this.parentElement.style.background='#b0b8b8'; this.style.display='none';" />
                 <img src="/assets/images/projectDetailsRight-stone.png" alt=""
                     class="absolute pointer-events-none float-up"
                     style="width:72px; top:-24px; right:-16px; z-index:2;"
                     onerror="this.style.display='none';" />
             </div>

         </div>
     </div>
 </section>
 @endif
 <section class="relative w-full overflow-hidden" style="font-family:'Jost',sans-serif;">

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

 {{-- ===== slider===== --}}
 @if($sliderTotal > 0)
 <section class="relative w-full overflow-hidden py-10" style="background:#f2ede6;">

     <div class="absolute top-0 right-0 pointer-events-none select-none overflow-hidden" style="z-index:0;">
         <span style="font-family:'Cormorant Garamond',serif; font-size:clamp(80px,16vw,220px); font-weight:700; color:rgba(0,0,0,0.05); white-space:nowrap;">Gallery</span>
     </div>

     <div class="relative z-10 w-full overflow-hidden" id="sliderWrapper">
         <div id="sliderTrack" class="flex items-stretch" style="gap:10px; transition:transform 0.7s cubic-bezier(0.4,0,0.2,1); will-change:transform;">
             @foreach($sliderImages as $i => $src)
             <div class="gallery-slide" id="slide-{{ $i }}" data-index="{{ $i }}"
                 onclick="goTo({{ $i }}); resetAuto();"
                 style="flex-shrink:0; overflow:hidden; cursor:pointer; height:clamp(220px,30vw,420px); transition:width 0.7s cubic-bezier(0.4,0,0.2,1), opacity 0.7s ease;">
                 <img src="{{ $src }}" alt="Gallery {{ $i + 1 }}"
                     style="width:100%; height:100%; object-fit:cover; display:block;"
                     onerror="this.parentElement.style.background='#c8c0b8'; this.style.display='none';" />
             </div>
             @endforeach
         </div>
     </div>

     <div class="relative z-10 flex items-center justify-between mt-8 px-6 lg:px-14">
         <div style="flex:1; max-width:300px; height:1px; background:#d1cbc3; position:relative; margin-right:2rem;">
             <div id="progressBar" style="position:absolute; left:0; top:0; height:1px; background:#152018; width:0%; transition:width 0.7s ease;"></div>
         </div>
         <div style="display:flex; gap:12px;">
             <button onclick="slide(-1); resetAuto();" class="w-9 h-9 rounded-full border border-gray-400 flex items-center justify-center hover:bg-gray-900 hover:border-gray-900 group transition-all duration-300">
                 <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                     <path d="M9 3L5 7l4 4" stroke="#666" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" class="group-hover:stroke-white" />
                 </svg>
             </button>
             <button onclick="slide(1); resetAuto();" class="w-9 h-9 rounded-full border border-gray-400 flex items-center justify-center hover:bg-gray-900 hover:border-gray-900 group transition-all duration-300">
                 <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                     <path d="M5 3l4 4-4 4" stroke="#666" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" class="group-hover:stroke-white" />
                 </svg>
             </button>
         </div>
     </div>

 </section>

 <script>
     (function() {
         const TOTAL = parseInt("{{ $sliderTotal }}");
         const LARGE = 'clamp(340px, 45vw, 580px)';
         const SMALL = 'clamp(80px, 10vw, 150px)';
         let current = 0;
         let autoTimer = null;

         // DOM ready
         window.addEventListener('load', function() {
             const track = document.getElementById('sliderTrack');
             const bar = document.getElementById('progressBar');
             const slides = document.querySelectorAll('.gallery-slide');

             if (!slides.length) return;

             function update() {
                 slides.forEach(function(slide, i) {
                     slide.style.width = (i === current) ? LARGE : SMALL;
                     slide.style.opacity = (i === current) ? '1' : '0.4';
                 });

                 bar.style.width = ((current + 1) / TOTAL * 100) + '%';

                 // active slide-কে view-এ আনুন
                 setTimeout(function() {
                     const activeSlide = slides[current];
                     const wrapperWidth = track.parentElement.offsetWidth;
                     const slideLeft = activeSlide.offsetLeft;
                     const slideWidth = activeSlide.offsetWidth;
                     const offset = slideLeft - (wrapperWidth / 2) + (slideWidth / 2);
                     track.style.transform = 'translateX(-' + Math.max(0, offset) + 'px)';
                 }, 100);
             }

             window.goTo = function(i) {
                 current = ((i % TOTAL) + TOTAL) % TOTAL;
                 update();
             };

             window.slide = function(dir) {
                 window.goTo(current + dir);
             };

             window.resetAuto = function() {
                 clearInterval(autoTimer);
                 autoTimer = setInterval(function() {
                     window.slide(1);
                 }, 3500);
             };

             update();
             window.resetAuto();
         });
     })();
 </script>
 @endif



 {{-- ===== LOCATION ===== --}}
 @if($project->location)
 <section class="w-full flex flex-col md:flex-row"
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
             class="w-full h-full border-0"
             allowfullscreen="" loading="lazy"
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