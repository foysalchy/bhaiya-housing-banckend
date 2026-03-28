 @extends('layouts.front')
 @section('title', 'Our Signature Projects')
 @section('meta')
 @php
 $pageTitle = 'Our Signature Projects – ' . ($setting->title ?? 'Bhaiya Housing Ltd.');
 $pageDesc = 'Discover our signature residential and commercial real estate projects across Bangladesh. Browse upcoming, ongoing, and completed luxury properties by Bhaiya Housing Ltd.';
 $pageUrl = url()->current();
 $pageImage = isset($projectHero->img_path) ? asset($projectHero->img_path) : asset('assets/images/projectmain.jpg');

 // Safe fallback for socials
 $socialLinks = isset($socials) ? $socials->map(fn($s) => $s->url)->filter()->values()->toArray() : [];

 $schema = [
 "page" => [
 "description" => $pageDesc,
 "keywords" => implode(', ', [
 'Bhaiya Housing projects',
 'real estate projects Bangladesh',
 'buy luxury apartment Dhaka',
 'ongoing real estate projects BD',
 'upcoming commercial spaces Dhaka',
 'completed housing projects Bangladesh',
 'property developer BD'
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
 "@type" => "CollectionPage",
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
 ["@type" => "ListItem", "position" => 2, "name" => "Projects", "item" => $pageUrl],
 ],
 ],
 ],
 "projectList" => [
 "@context" => "https://schema.org",
 "@type" => "ItemList",
 "name" => "Signature Real Estate Projects by Bhaiya Housing",
 "url" => $pageUrl,
 "numberOfItems" => isset($allProjects) ? count($allProjects) : 0,
 "itemListElement" => isset($allProjects) ? collect($allProjects)->map(fn($project, $i) => [
 "@type" => "ListItem",
 "position" => $i + 1,
 "item" => [
 // Dynamic schema type based on residential vs commercial, fallback to ApartmentComplex
 "@type" => (isset($project['type']) && str_contains(strtolower($project['type']), 'commercial')) ? "CommercialEvent" : "ApartmentComplex",
 "name" => $project['title'] ?? ($project->title ?? ''),
 "url" => $project['url'] ?? url('/projects/' . ($project['id'] ?? '')),
 "image" => $project['img'] ?? ($project->img_path ? asset($project->img_path) : $pageImage),
 "address" => [
 "@type" => "PostalAddress",
 "addressLocality" => $project['location'] ?? ($project->location ?? 'Bangladesh')
 ],
 ],
 ])->values()->toArray() : [],
 ],
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

 @if(isset($allProjects) && count($allProjects) > 0)
 <script type="application/ld+json">
     {
         !!json_encode($schema['projectList'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!
     }
 </script>
 @endif
 @endsection
 @section('content')

 <!-- ===== HERO ===== -->
 <section class="relative w-full overflow-hidden" style="height: clamp(320px, 45vw, 560px);">

     <!-- Background Image -->
     <img src="{{ $projectHero->img_path ?? asset('assets/images/projectmain.jpg') }}"
         alt="interior"
         class="absolute inset-0 w-full h-full object-cover" />

     <!-- Dark Overlay -->
     <div class="absolute inset-0 bg-black/50"></div>

     <!-- Text -->
     <div class="absolute inset-0 flex items-center px-10 md:px-20">
         <h2 class="text-white font-light"
             style="font-size:clamp(22px,3.5vw,52px); line-height:1.2;">
             @if($projectHero?->title)
             {!! $projectHero->title !!}
             @else
             <span style="font-family:'Jost',sans-serif; font-weight:400;">Where </span>
             <em style="font-family:'Cormorant Garamond',serif; font-style:italic; font-weight:300;">innovation </em>
             <span style="font-family:'Jost',sans-serif; font-weight:400;">meets </span>
             <em style="font-family:'Cormorant Garamond',serif; font-style:italic; font-weight:300;">quality &amp; trust</em>
             @endif
         </h2>
     </div>

 </section>

 <section class="relative w-full overflow-hidden py-16" style="background:#f2ede6; font-family:'Jost',sans-serif;">

     <!-- Ghost BG text -->
     <div class="absolute top-6 right-0 pointer-events-none select-none overflow-hidden" style="z-index:0;">
         <span style="font-family:'Cormorant Garamond',serif; font-size:clamp(80px,14vw,200px); font-weight:700; color:rgba(0,0,0,0.055); white-space:nowrap; line-height:1;">
             Signature
         </span>
     </div>

     <!-- BG decorative image -->
     <div class="absolute inset-0 pointer-events-none" style="z-index:0;">
         <img src="/assets/images/bg-image.avif" alt="" class="w-full h-full object-cover opacity-10"
             onerror="this.style.display='none';" />
     </div>

     <div class="relative z-10 container mx-auto px-6 lg:px-14">

         <!-- Heading -->
         <h2 class="mb-10 font-light text-gray-900" style="font-size:clamp(28px,4vw,56px); line-height:1.15;">
             <span style="font-family:'Jost',sans-serif; font-weight:400;">Discover Our </span>
             <em style="font-family:'Cormorant Garamond',serif; font-style:italic; font-weight:300;">Signature Projects</em>
         </h2>

         <!-- Filters -->
         <div class="flex flex-col md:flex-row gap-0 mb-12" style="border-bottom:1px solid #c8c0b4;">

            <!-- Status -->
            <div class="flex-1 relative" style="border-right:1px solid #c8c0b4;">
                <label for="filterStatus" class="sr-only">Filter by Status</label>
                <select id="filterStatus" onchange="applyFilters()"
                    class="w-full bg-transparent appearance-none text-sm font-light text-gray-700 py-4 pr-10 pl-0 cursor-pointer outline-none"
                    style="font-family:'Jost',sans-serif; border:none;">
                    <option value="all">All Status</option>
                    <option value="upcoming">Upcoming</option>
                    <option value="ongoing">Ongoing</option>
                    <option value="complete">Complete</option>
                </select>
                <div class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-gray-500">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                        <path d="M3 5l4 4 4-4" stroke="#666" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>

            <!-- Type -->
            <div class="flex-1 relative" style="border-right:1px solid #c8c0b4;">
               <label for="filterType" class="sr-only">Filter by Type</label>
                <select id="filterType" onchange="applyFilters()"
                    class="w-full bg-transparent appearance-none text-sm font-light text-gray-700 py-4 pr-10 pl-6 cursor-pointer outline-none"
                    style="font-family:'Jost',sans-serif; border:none;">
                    <option value="all">All Types</option>
                    <option value="residential">Residential</option>
                    <option value="commercial">Commercial</option>
                </select>
                <div class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-gray-500">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                        <path d="M3 5l4 4 4-4" stroke="#666" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>

            <!-- Location  -->
            <div class="flex-1 relative">
                <label for="filterLocation" class="sr-only">Filter by Location</label>
                <select id="filterLocation" onchange="applyFilters()"
                    class="w-full bg-transparent appearance-none text-sm font-light text-gray-700 py-4 pr-10 pl-6 cursor-pointer outline-none"
                    style="font-family:'Jost',sans-serif; border:none;">
                    <option value="all">All Locations</option>
                    @foreach($projectLocations as $loc)
                    <option value="{{ strtolower($loc) }}">{{ $loc }}</option>
                    @endforeach
                </select>
                <div class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-gray-500">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                        <path d="M3 5l4 4 4-4" stroke="#666" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>


         </div>



         <!-- Projects Grid -->
         <div id="projectsGrid" class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-12"></div>

         <!-- No results -->
         <p id="noResults" class="text-center text-gray-500 py-16 hidden"
             style="font-family:'Jost',sans-serif; font-weight:300;">
             No Projects Found
         </p>

         <!-- Load More -->
         <div class="flex justify-center mt-16" id="loadMoreWrap">
             <button onclick="loadMore()"
                 class="px-12 py-3 border border-gray-800 text-gray-800 text-sm font-light tracking-widest transition-all duration-300 hover:bg-gray-900 hover:text-white"
                 style="font-family:'Jost',sans-serif; letter-spacing:0.1em;">
                 Load More
             </button>
         </div>

     </div>
 </section>

 <script>
     const ALL_PROJECTS = @json($allProjects);
     const PER_PAGE = 4;
     let visibleCount = PER_PAGE;
     let filtered = [...ALL_PROJECTS];

     // ── Project card HTML ──
     function projectCard(p) {
         return `
        <a href="${p.url}" style="text-decoration:none;">
            <div class="group cursor-pointer">
                <!-- Image -->
                <div class="overflow-hidden mb-4" style="height:clamp(220px,28vw,360px);">
                    <img src="${p.img}" alt="${p.title}"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                        onerror="this.parentElement.style.background='#c8bfb0'; this.style.display='none';" />
                </div>
                <!-- Info -->
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h3 class="text-gray-900 font-light mb-1"
                            style="font-family:'Cormorant Garamond',serif; font-size:clamp(20px,2vw,28px); font-weight:300;">
                            ${p.title}
                        </h3>
                        <p class="text-sm text-gray-500 font-light" style="font-family:'Jost',sans-serif;">
                            ${p.location}
                        </p>
                    </div>
                    <!-- Status badge -->
                    <span class="flex-shrink-0 text-xs uppercase tracking-widest px-3 py-1 mt-1"
                        style="font-family:'Jost',sans-serif; letter-spacing:0.12em;
                               background:${p.status === 'complete' ? '#e8f0e9' : p.status === 'upcoming' ? '#f0ece4' : '#eef0f8'};
                               color:${p.status === 'complete' ? '#2d6a35' : p.status === 'upcoming' ? '#7a6a4a' : '#3a4a7a'};">
                        ${p.status}
                    </span>
                </div>
            </div>
        </a>`;
     }

     // ── Grid render ──
     function renderGrid() {
         const grid = document.getElementById('projectsGrid');
         const noRes = document.getElementById('noResults');
         const loadWrap = document.getElementById('loadMoreWrap');

         const slice = filtered.slice(0, visibleCount);

         if (filtered.length === 0) {
             grid.innerHTML = '';
             noRes.classList.remove('hidden');
             loadWrap.classList.add('hidden');
             return;
         }

         noRes.classList.add('hidden');
         grid.innerHTML = slice.map(projectCard).join('');
         loadWrap.classList.toggle('hidden', visibleCount >= filtered.length);
     }

     // ── Filter apply ──
     function applyFilters() {
         const status = document.getElementById('filterStatus').value;
         const type = document.getElementById('filterType').value;
         const location = document.getElementById('filterLocation').value;

         filtered = ALL_PROJECTS.filter(p => {
             const matchStatus = status === 'all' || p.status === status;
             const matchType = type === 'all' || p.type.includes(type);
             const matchLocation = location === 'all' || p.location.toLowerCase().includes(location);
             return matchStatus && matchType && matchLocation;
         });

         visibleCount = PER_PAGE;
         renderGrid();
     }

     // ── Load More ──
     function loadMore() {
         visibleCount += PER_PAGE;
         renderGrid();
     }

    // ── Page load-এ প্রথমবার render ──
    renderGrid();
</script>
 @endsection
    

