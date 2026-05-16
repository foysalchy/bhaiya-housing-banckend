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
     <div class="absolute inset-0 flex items-center px-10 md:px-20">
         <h2 class="text-white font-light" style="font-size:clamp(22px,3.5vw,52px); line-height:1.2;">
             {{$project->title}}
         </h2>
     </div>
 </section>
<div class="h-[600px] md:h-[700px] lg:h-[900px] w-full pointer-events-none"
    style="position: relative; z-index: 2;"></div>

 {{-- ===== AT A GLANCE ===== --}}
 <section class="relative z-10 w-full" style="background:#ffffff; font-family:'Jost',sans-serif;">
     <div class="container mx-auto px-6 lg:px-14 py-20">
         <div class="flex flex-col md:flex-row gap-16 items-start">

             <!-- Left: Content -->
             <div class="w-full md:w-1/2">
                 <p class="text-xs font-light text-gray-500 mb-6 tracking-wide">
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
 <section class="relative z-10 w-full overflow-hidden py-16" style="background:#ffffff;">
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

 {{-- ===== slider===== --}}
 @if($sliderTotal > 0)
<section class="relative z-10 w-full overflow-hidden py-10 lg:py-20" style="background:#f2ede6; min-height: 500px;">

    <!-- Background "Gallery" Text -->
    <div class="absolute top-0 right-0 pointer-events-none select-none overflow-hidden" style="z-index:0;">
        <span style="font-family:'Cormorant Garamond',serif; font-size:clamp(100px,20vw,280px); font-weight:700; color:rgba(0,0,0,0.05); white-space:nowrap; line-height: 1;">Gallery</span>
    </div>

    <!-- Slider Container -->
    <div class="relative z-10 w-full" id="sliderWrapper">
        <div id="sliderTrack" class="flex items-center" style="transition: transform 0.7s cubic-bezier(0.4, 0, 0.2, 1); will-change: transform;">
            @foreach($sliderImages as $i => $src)
            <div class="gallery-slide relative flex-shrink-0 cursor-pointer overflow-hidden transition-all duration-700 ease-in-out"
                 data-real-index="{{ $i }}"
                 onclick="goToRealIndex({{ $i }})"
                 style="height:clamp(300px, 45vw, 520px); margin: 0 10px;">

                <img src="{{ $src }}" alt="Gallery {{ $i + 1 }}"
                    class="w-full h-full object-cover block"
                    onerror="this.parentElement.style.background='#c8c0b8'; this.style.display='none';" />


            </div>
            @endforeach
        </div>
    </div>

    <!-- Controls & Progress Bar -->
    <div class="relative z-10 flex items-center justify-between mt-12 px-6 lg:px-20">
        <div class="flex-1 max-w-md h-[1px] bg-gray-300 relative">
            <div id="progressBar" class="absolute left-0 top-0 h-[1px] bg-black transition-all duration-700" style="width:0%;"></div>
        </div>

        <div class="flex gap-4 ml-8">
           <button onclick="moveSlide(-1)" aria-label="Previous slide"
                class="w-10 h-10 rounded-full border border-gray-400 flex items-center justify-center hover:bg-black hover:border-black group transition-all">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    aria-hidden="true" class="text-gray-600 group-hover:text-white">
                    <path d="M15 18l-6-6 6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>

            <button onclick="moveSlide(1)" aria-label="Next slide"
                class="w-10 h-10 rounded-full border border-gray-400 flex items-center justify-center hover:bg-black hover:border-black group transition-all">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    aria-hidden="true" class="text-gray-600 group-hover:text-white">
                    <path d="M9 18l6-6-6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>
    </div>

</section>

<style>
    #sliderWrapper { overflow: visible; }
    .gallery-slide.active .details-overlay { opacity: 1; }
    .gallery-slide img { filter: grayscale(20%) brightness(0.9); transition: all 0.7s; }
    .gallery-slide.active img { filter: grayscale(0%) brightness(1); }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const track = document.getElementById('sliderTrack');
    const bar = document.getElementById('progressBar');
    const slides = Array.from(track.children);
    const total = slides.length;

    if (total === 0) return;

    // Infinite Loop: Clone items to fill sides
    // We clone elements to make sure there's no gap on either side
    for(let i=0; i<3; i++) {
        slides.forEach(slide => {
            const clone = slide.cloneNode(true);
            track.appendChild(clone);
        });
        slides.slice().reverse().forEach(slide => {
            const clone = slide.cloneNode(true);
            track.insertBefore(clone, track.firstChild);
        });
    }

    const allSlides = Array.from(track.children);
    let currentIndex = Math.floor(allSlides.length / 2); // Start from middle
    let isTransitioning = false;
    let autoTimer;

    const LARGE_W = 65; // Active slide width in %
    const SMALL_W = 15; // Inactive slide width in %

    function updateSlider(immediate = false) {
        if (immediate) track.style.transition = 'none';
        else track.style.transition = 'transform 0.7s cubic-bezier(0.4, 0, 0.2, 1)';

        const isMobile = window.innerWidth < 768;
        const activeW = isMobile ? '85vw' : LARGE_W + 'vw';
        const inactiveW = isMobile ? '12vw' : SMALL_W + 'vw';

        allSlides.forEach((slide, i) => {
            if (i === currentIndex) {
                slide.style.width = activeW;
                slide.style.opacity = '1';
                slide.classList.add('active');
            } else {
                slide.style.width = inactiveW;
                slide.style.opacity = '0.4';
                slide.classList.remove('active');
            }
        });

        // Center calculation: active slide matches window center
        const activeSlide = allSlides[currentIndex];
        const slideCenter = activeSlide.offsetLeft + (activeSlide.offsetWidth / 2);
        const viewportCenter = window.innerWidth / 2;
        const offset = slideCenter - viewportCenter;

        track.style.transform = `translateX(-${offset}px)`;

        // Update progress bar based on real index
        const realIdx = parseInt(activeSlide.getAttribute('data-real-index'));
        bar.style.width = ((realIdx + 1) / total * 100) + '%';

        if (immediate) {
            track.offsetHeight; // force reflow
            track.style.transition = 'transform 0.7s cubic-bezier(0.4, 0, 0.2, 1)';
        }
    }

    window.moveSlide = function(step) {
        if (isTransitioning) return;
        isTransitioning = true;
        currentIndex += step;
        updateSlider();
        resetAuto();
    };

    window.goToRealIndex = function(idx) {
        // Find nearest instance of this index to the current view
        // For simplicity, just jump in the middle section
        // Note: Real index click needs careful mapping in cloned setup
    };

    track.addEventListener('transitionend', () => {
        isTransitioning = false;
        // Loop safety: if we go too far into clones, jump back to middle set
        const threshold = total * 2;
        if (currentIndex < threshold) {
            currentIndex += total;
            updateSlider(true);
        } else if (currentIndex >= allSlides.length - threshold) {
            currentIndex -= total;
            updateSlider(true);
        }
    });

    function resetAuto() {
        clearInterval(autoTimer);
        autoTimer = setInterval(() => moveSlide(1), 5000);
    }

    window.addEventListener('resize', () => updateSlider(true));

    updateSlider(true);
    resetAuto();
});
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
