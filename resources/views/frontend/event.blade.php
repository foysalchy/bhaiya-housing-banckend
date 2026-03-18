 @extends('layouts.front')
 @section('title', 'News & Events')

 @section('meta')
 @php
 $pageTitle = 'News & Events – ' . ($setting->title ?? 'Bhaiya Housing Ltd.');
 $pageDesc = 'Stay informed with the latest updates, press releases, and upcoming events from Bhaiya Housing Ltd. Discover our continuous journey in shaping modern real estate in Bangladesh.';
 $pageUrl = url()->current();
 $pageImage = isset($eventHero->img_path) ? asset($eventHero->img_path) : asset('assets/images/event.jpg');

 // Safe fallback for socials
 $socialLinks = isset($socials) ? $socials->map(fn($s) => $s->url)->filter()->values()->toArray() : [];

 $schema = [
 "page" => [
 "description" => $pageDesc,
 "keywords" => implode(', ', [
 'Bhaiya Housing news',
 'real estate events Bangladesh',
 'property development updates Dhaka',
 'Bhaiya Group press release',
 'upcoming housing events BD',
 'real estate latest news',
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
 ["@type" => "ListItem", "position" => 2, "name" => "News & Events", "item" => $pageUrl],
 ],
 ],
 ],
 "newsEventList" => [
 "@context" => "https://schema.org",
 "@type" => "ItemList",
 "name" => "Bhaiya Housing News and Events",
 "url" => $pageUrl,
 "numberOfItems" => isset($newsEvents) ? count($newsEvents) : 0,
 "itemListElement" => isset($newsEvents) ? collect($newsEvents)->map(fn($item, $i) => [
 "@type" => "ListItem",
 "position" => $i + 1,
 "item" => [
 // Dynamically set schema type based on item type
 "@type" => (isset($item['type']) && $item['type'] === 'events') ? "Event" : "NewsArticle",
 "headline" => $item['title'] ?? ($item->title ?? ''),
 "url" => $item['url'] ?? url('/' . ($item['type'] ?? 'news') . '/' . ($item['id'] ?? '')),
 "datePublished" => $item['date'] ?? ($item->start_date ?? null),
 "publisher" => ["@id" => url('/') . '#organization']
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

 @if(isset($newsEvents) && count($newsEvents) > 0)
 <script type="application/ld+json">
     {
         !!json_encode($schema['newsEventList'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!
     }
 </script>
 @endif
 @endsection
 @section('content')

 <!-- ===== HERO ===== -->
 <section class="relative w-full overflow-hidden" style="height: clamp(320px, 45vw, 560px);">

     <!-- Background Image -->
     <img src="{{ $eventHero->img_path ?? asset('assets/images/event.jpg') }}" alt="interior" class="absolute inset-0 w-full h-full object-cover" />



     <!-- Dark Overlay -->
     <div class="absolute inset-0 bg-black/50"></div>

     <!-- Text -->
     <div class="absolute inset-0 flex items-center px-10 md:px-20">
         <h2 class="text-white font-light" style="font-size:clamp(22px,3.5vw,52px); line-height:1.2;">
             <span style="font-family:'Jost',sans-serif; font-weight:400;">Where </span>
             <em style="font-family:'Cormorant Garamond',serif; font-style:italic; font-weight:300;">Stay informed with
             </em>
             <span style="font-family:'Jost',sans-serif; font-weight:400;"><br> </span>
             <em style="font-family:'Cormorant Garamond',serif; font-style:italic; font-weight:300;">Bhaiya Housing Ltd.

             </em>
         </h2>
     </div>

 </section>

 <section class="w-full min-h-screen relative overflow-hidden py-16"
     style="background:#FFFDFA;">

     <!-- BG texture -->
     <div class="absolute inset-0 pointer-events-none" style="z-index:0;">
         <img src="/assets/images/bg-news.png" alt=""
             class="w-full h-full object-cover opacity-20"
             onerror="this.style.display='none';" />
     </div>

     <div class="relative z-10 container mx-auto px-6 lg:px-14">
         <div class="flex gap-16 items-start">

             <!-- ── Left: Filter Buttons ── -->
             <div class="flex flex-col items-center gap-3 pt-8" style="min-width:120px;">
                 <button onclick="setFilter('all', this)"
                     class="filter-btn active-filter w-28 h-28 rounded-full border border-gray-300 text-sm font-light tracking-wide transition-all duration-300 flex items-center justify-center"
                     style="margin-bottom:-12px; position:relative; z-index:3;">
                     All
                 </button>
                 <button onclick="setFilter('events', this)"
                     class="filter-btn w-28 h-28 rounded-full border border-gray-300 text-sm font-light tracking-wide transition-all duration-300 flex items-center justify-center"
                     style="margin-bottom:-12px; position:relative; z-index:2;">
                     Events
                 </button>
                 <button onclick="setFilter('news', this)"
                     class="filter-btn w-28 h-28 rounded-full border border-gray-300 text-sm font-light tracking-wide transition-all duration-300 flex items-center justify-center"
                     style="position:relative; z-index:1;">
                     News
                 </button>
             </div>

             <!-- ── Right: News List ── -->
             <div class="flex-1 pt-0 ml-28">
                 <div style="border-top:1px solid #c8c0b4;"></div>
                 <div id="newsList"></div>

                 <!-- No results -->
                 <p id="noResults" class="text-center text-gray-400 py-16 hidden">
                     কোনো item পাওয়া যায়নি।
                 </p>
             </div>

         </div>
     </div>
 </section>



 <script>
     (function() {
         const ALL_ITEMS = @json($newsEvents);
         let active = 'all';

         function capitalize(str) {
             return str.charAt(0).toUpperCase() + str.slice(1);
         }

         function render(filter) {
             const list = document.getElementById('newsList');
             const noRes = document.getElementById('noResults');
             const items = filter === 'all' ?
                 ALL_ITEMS :
                 ALL_ITEMS.filter(i => i.type === filter);

             if (!items.length) {
                 list.innerHTML = '';
                 noRes.classList.remove('hidden');
                 return;
             }

             noRes.classList.add('hidden');
             list.innerHTML = items.map(item => `
            <a href="${item.url}" class="news-item">
                <div class="news-item-meta">
                    <p class="news-item-type">${capitalize(item.type)}</p>
                    ${item.date ? `<p class="news-item-date">${item.date}</p>` : ''}
                </div>
                <div class="flex-1">
                    <h3 class="news-item-title">${item.title}</h3>
                </div>
            </a>
        `).join('');
         }

         window.setFilter = function(filter, btn) {
             active = filter;

             // Active button style
             document.querySelectorAll('.filter-btn').forEach(b => {
                 b.classList.remove('active-filter');
             });
             btn.classList.add('active-filter');

             render(filter);
         };

         // Initial render
         render('all');
     })();
 </script>




 @endsection