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

{{-- Hero --}}
<section class="hero-fixed fixed top-0 left-0 w-full overflow-hidden h-[600px] md:h-[700px] lg:h-[900px]"
    style="z-index:1; transform-origin:top center; will-change:transform;">

    <img src="{{ $projectHero->img_path ?? asset('assets/images/projectmain.jpg') }}"
        alt="interior"
        class="absolute inset-0 w-full h-full object-cover" />

    <div class="absolute inset-0 bg-black/50"></div>

    <div class="absolute inset-0 flex items-center px-6 sm:px-10 md:px-20" >
        <h2 class="text-white md:pl-12 pt-20 md:pt-32 font-light tracking-normal md:tracking-[-4px]"
            style="font-size: clamp(32px, 3.85vw, 74px); line-height: 1.2;">
            Where <span class="font-migra-italic">innovation</span>
            meets <span class="font-migra-italic">quality & trust</span>
        </h2>
    </div>

</section>

{{-- Spacer --}}
<div class="h-[600px] md:h-[700px] lg:h-[900px] w-full pointer-events-none"
    style="position:relative; z-index:2;"></div>

{{-- Project section --}}
<section class="relative w-full overflow-hidden py-10 md:py-16 mt-16 md:mt-32"
    style="z-index:2;
           background:url('{{ asset('assets/images/testimonial-bg.png') }}') center center / cover no-repeat, #F6F6F6;
           box-shadow:0 -12px 40px rgba(0,0,0,0.15);">

    {{-- Ghost BG text: Signature — desktop only --}}
    <div class="hidden md:block absolute top-0 -right-32 pointer-events-none select-none overflow-hidden scroll-move"
        data-axis="-X" style="z-index:0;">
        <span class="font-migra-italic"
            style="font-size:clamp(60px,18.3vw,260px); color:rgba(0,0,0,0.07); white-space:nowrap; line-height:1;">
            Signature
        </span>
    </div>

    {{-- BG decorative image --}}
    <div class="absolute inset-0 pointer-events-none mt-8" style="z-index:0;">
        <img src="/assets/images/bg-image.avif" alt=""
            class="w-full h-full object-cover opacity-10"
            onerror="this.style.display='none';" />
    </div>

    <!-- কন্টেইনারে রেসপন্সিভ সাইড প্যাডিং (px-6 md:px-12 lg:px-14) যোগ করা হয়েছে -->
    <div class="relative z-10 container mx-auto px-6 md:px-12 lg:px-14">

        {{-- Heading (মোবাইলে ফন্ট-সাইজ সুন্দর দেখানোর জন্য clamp ব্যবহার করা হয়েছে) --}}
        <h2 class="mb-8 md:mb-10 font-light text-gray-900"
            style="font-size: clamp(34px, 5.5vw, 75px); line-height:1.15; letter-spacing: -0.02em;">
            <span style="font-weight:500;">Discover Our </span>
            <span class="font-migra-italic">Signature Projects</span>
        </h2>

        {{-- Filters --}}
        <style>
            .filter-bar { border-bottom: 1px solid #c8c0b4; }
            .filter-item { border-bottom: 1px solid #c8c0b4; }
            @media (min-width: 640px) {
                .filter-item { border-bottom: none; border-right: 1px solid #c8c0b4; }
                .filter-item:last-child { border-right: none; }
            }
        </style>

        <div class="filter-bar flex flex-col sm:flex-row">

                {{-- Status --}}
                <div class="filter-item flex-1 relative">
                    <label for="filterStatus" class="sr-only">Filter by Status</label>
                    <select id="filterStatus" onchange="applyFilters()"
                        class="w-full bg-transparent appearance-none text-sm font-light text-gray-700 py-3 md:py-4 pr-10 pl-4 sm:pl-6 cursor-pointer outline-none"
                        style="border:none;">
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

                {{-- Type --}}
                <div class="filter-item flex-1 relative">
                    <label for="filterType" class="sr-only">Filter by Type</label>
                    <select id="filterType" onchange="applyFilters()"
                        class="w-full bg-transparent appearance-none text-sm font-light text-gray-700 py-3 md:py-4 pr-10 pl-4 sm:pl-6 cursor-pointer outline-none"
                        style="border:none;">
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

                {{-- Location --}}
                <div class="filter-item flex-1 relative">
                    <label for="filterLocation" class="sr-only">Filter by Location</label>
                    <select id="filterLocation" onchange="applyFilters()"
                        class="w-full bg-transparent appearance-none text-sm font-light text-gray-700 py-3 md:py-4 pr-10 pl-4 sm:pl-6 cursor-pointer outline-none"
                        style="border:none;">
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

        {{-- Ghost BG text: PROJECTS — desktop only --}}
        <div class="absolute pointer-events-none select-none overflow-hidden scroll-move mt-32 hidden md:block"
            data-axis="X" style="z-index:0;">
            <span class="font-migra-italic"
                style="font-size:clamp(80px,16.3vw,240px); color:rgba(0,0,0,0.07); white-space:nowrap; line-height:1;">
                PROJECTS
            </span>
        </div>

        <div id="projectsGrid" class="grid grid-cols-2 gap-x-4 lg:gap-x-8 gap-y-8 md:gap-y-12 mt-10 md:mt-12">
        </div>

        {{-- No results --}}
        <p id="noResults" class="text-center text-gray-500 py-16 hidden" style="font-weight:300;">
            No Projects Found
        </p>

        {{-- Load More --}}
        <div class="flex justify-center mt-10 md:mt-16" id="loadMoreWrap">
            <button onclick="loadMore()"
                class="px-8 md:px-12 py-3 border border-gray-800 text-gray-800 text-sm font-light tracking-widest transition-all duration-300 hover:bg-gray-900 hover:text-white"
                style="letter-spacing:0.1em;">
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

    // ── Helper to safely extract project Status ──
    function getStatus(p) {
        // যদি সরাসরি p.status এ টেক্সট থাকে (যেমন 'ongoing')
        if (typeof p.status === 'string' && p.status !== '1' && p.status !== '0') {
            return p.status;
        }
        // নতুবা JSON extra ফিল্ড চেক করবে
        let extra = {};
        if (typeof p.extra === 'string') {
            try { extra = JSON.parse(p.extra); } catch(e) {}
        } else if (p.extra) {
            extra = p.extra;
        }
        return extra.status || '';
    }

    // ── Helper to safely extract project Type ──
    function getType(p) {
        if (p.type) return p.type;
        return p.short || ''; // 'short' কলামে Residential/Commercial টাইপ থাকলে
    }

    // ── Project card HTML ──
    function projectCard(p) {
        return `
        <a href="${p.url}" class="block group">
            <div class="group cursor-pointer pl-4 md:pl-10">
                <!-- Image Wrapper -->
                <div class="overflow-hidden mb-4 h-[350px] md:h-[600px] w-full">
                    <img
                        src="${p.img}"
                        alt="${p.title}"
                        class="w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-105"
                        onerror="this.parentElement.style.background='#c8bfb0'; this.style.display='none';"
                    />
                </div>
                
                <!-- Text -->
                <div class="px-2 md:px-0">
                    <h3 class="text-lg md:text-xl font-medium text-gray-900">
                        ${p.title}
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">
                        ${p.location ?? ''}
                    </p>
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

    // ── Update Location Dropdown options dynamically ──
    function updateLocationDropdown() {
        const selectedStatus = document.getElementById('filterStatus').value.toLowerCase();
        const selectedType = document.getElementById('filterType').value.toLowerCase();
        const locationSelect = document.getElementById('filterLocation');
        const currentlySelectedLocation = locationSelect.value.toLowerCase();

        const filteredLocations = new Set();

        ALL_PROJECTS.forEach(project => {
            const projectStatus = getStatus(project).toLowerCase();
            const projectType = getType(project).toLowerCase();

            // স্ট্যাটাস এবং টাইপ ম্যাচ করছে কিনা যাচাই
            const matchesStatus = (selectedStatus === 'all' || projectStatus === selectedStatus);
            const matchesType = (selectedType === 'all' || projectType.includes(selectedType));

            if (matchesStatus && matchesType && project.location) {
                filteredLocations.add(project.location);
            }
        });

        // ড্রপডাউন খালি করে "All Locations" এবং রি-ফিল্টার করা লোকেশনগুলো সেট করা
        locationSelect.innerHTML = '<option value="all">All Locations</option>';

        let locationStillExists = false;

        filteredLocations.forEach(loc => {
            const locValue = loc.toLowerCase();
            const option = document.createElement('option');
            option.value = locValue;
            option.textContent = loc;

            // যদি আগের সিলেক্ট করা লোকেশনটি এখনও ফিল্টারে থাকে, সেটি সিলেক্টেড থাকবে
            if (locValue === currentlySelectedLocation) {
                option.selected = true;
                locationStillExists = true;
            }
            locationSelect.appendChild(option);
        });

        // যদি আগের সিলেক্ট করা লোকেশনটি ফিল্টারে না থাকে, তবে ড্রপডাউন 'all' এ রিসেট হবে
        if (!locationStillExists && currentlySelectedLocation !== 'all') {
            locationSelect.value = 'all';
        }
    }

    // ── Filter apply (ডুপ্লিকেট রিমুভ করে দুটিকে মার্জ করা হয়েছে) ──
    function applyFilters() {
        // ১. আগে স্ট্যাটাস ও টাইপ অনুযায়ী লোকেশন ড্রপডাউন পরিবর্তন করা হবে
        updateLocationDropdown();

        // ২. ড্রপডাউনের বর্তমান সিলেক্টেড ভ্যালুগুলো সংগ্রহ করা
        const status = document.getElementById('filterStatus').value.toLowerCase();
        const type = document.getElementById('filterType').value.toLowerCase();
        const location = document.getElementById('filterLocation').value.toLowerCase();

        // ৩. ফাইনাল প্রোজেক্ট ফিল্টারিং
        filtered = ALL_PROJECTS.filter(p => {
            const projectStatus = getStatus(p).toLowerCase();
            const projectType = getType(p).toLowerCase();
            const projectLoc = (p.location || '').toLowerCase();

            const matchStatus = status === 'all' || projectStatus === status;
            const matchType = type === 'all' || projectType.includes(type);
            const matchLocation = location === 'all' || projectLoc.includes(location);

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

    // ── Page load-এ প্রথমবার ড্রপডাউন ও গ্রিড সিঙ্ক করা ──
    updateLocationDropdown();
    renderGrid();
</script>
 @endsection