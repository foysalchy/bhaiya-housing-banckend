 @extends('layouts.front')
 @section('title', 'Our Ventures & Concerns')

 @section('meta')
 @php
 $pageTitle = 'Our Ventures & Concerns – ' . ($setting->title ?? 'Bhaiya Housing Ltd.');

 // Use the short description from the DB, fallback to a strong SEO description
 $pageDesc = isset($concern->short) && !empty($concern->short)
 ? strip_tags($concern->short)
 : 'Explore the sister concerns and other ventures of Bhaiya Group. Expanding excellence beyond real estate into diverse industries and businesses across Bangladesh.';

 $pageUrl = url()->current();
 $pageImage = isset($concernHero->img_path) ? asset($concernHero->img_path) : asset('assets/images/concern.jpg');

 // Safe fallback for socials
 $socialLinks = isset($socials) ? $socials->map(fn($s) => $s->url)->filter()->values()->toArray() : [];

 // Flatten the $rows array/collection to get all brand logos easily for the schema
 $allBrands = isset($rows) ? collect($rows)->flatten() : collect([]);

 $schema = [
 "page" => [
 "description" => Str::limit($pageDesc, 160),
 "keywords" => implode(', ', [
 'Bhaiya Group',
 'Bhaiya Housing sister concerns',
 'our ventures',
 'Bhaiya Group companies',
 'business ventures Bangladesh',
 'corporate profile',
 'expanding excellence'
 ]),
 "robots" => "index, follow, max-image-preview:large",
 "canonical" => $pageUrl,
 ],
 "openGraph" => [
 "type" => "website",
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
 "@type" => ["Organization", "RealEstateBuilder"],
 "@id" => url('/') . '#organization',
 "name" => $setting->title ?? 'Bhaiya Housing Ltd.',
 "parentOrganization" => [
 "@type" => "Organization",
 "name" => "Bhaiya Group"
 ],
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
 "@type" => "AboutPage",
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
 ["@type" => "ListItem", "position" => 2, "name" => "Our Concerns", "item" => $pageUrl],
 ],
 ],
 ],
 "brandList" => [
 "@context" => "https://schema.org",
 "@type" => "ItemList",
 "name" => "Sister Concerns & Ventures of Bhaiya Group",
 "url" => $pageUrl,
 "numberOfItems" => $allBrands->count(),
 "itemListElement" => $allBrands->map(fn($brand, $i) => [
 "@type" => "ListItem",
 "position" => $i + 1,
 "item" => [
 "@type" => "Brand",
 "name" => $brand->title ?? 'Bhaiya Group Venture',
 "image" => isset($brand->img_path) ? asset($brand->img_path) : $pageImage,
 ],
 ])->values()->toArray(),
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

 @if($allBrands->count() > 0)
 <script type="application/ld+json">
     {
         !!json_encode($schema['brandList'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!
     }
 </script>
 @endif
 @endsection
 @section('content')

 {{-- ===== HERO ===== --}}
 <section class="fixed hero-fixed  top-0 left-0 w-full z-0 overflow-hidden
                h-[600px] md:h-[700px] lg:h-[900px]">
     <img src="{{ $concernHero?->img_path ?? asset('assets/images/concern.jpg') }}"
         alt="interior" class="absolute inset-0 w-full h-full" />
     <div class="absolute inset-0 bg-black/50"></div>
     <div class="absolute inset-0 flex items-center px-6 sm:px-10 md:px-20">
         <h2 class="text-white font-light" style="font-size:clamp(18px,3.5vw,52px); line-height:1.2;">
          
              Expanding Excellence<br><span class="font-migra-italic">Our Other Ventures</span>  
         </h2>
     </div>
 </section>
<div class="h-[600px] md:h-[700px] lg:h-[900px] w-full pointer-events-none"></div>

 {{-- ===== MAIN SECTION ===== --}}
 <section class="w-full relative z-10 py-10 md:py-16" style="background:#f2ede6;">

     <div class="mx-auto px-4 sm:px-6 lg:px-14">

         <!-- Two column text -->
         <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-10 mb-12 md:mb-16" style="font-size:16px;font-weight:400;letter-spacing:1px;color:#000">
             <p class=" prose prose-sm max-w-none   pl-10">
                 {{ $concern?->short ?? '' }}
             </p>
             <div class=" prose prose-sm max-w-none">
                 {!! $concern?->body ?? '' !!}
             </div>
         </div>

     </div>

     <!-- Logo Grid -->
     @if(count($rows) > 0)
     <div class="w-full" style="border-top:1px solid #d8d0c8;">

         {{-- ── Desktop: original row/col grid ── --}}
         <div class="hidden md:block">
             @foreach($rows as $rowIndex => $row)
             <div class="flex {{ $rowIndex > 0 ? 'border-t border-[#d8d0c8]' : '' }}">

                 @foreach($row as $colIndex => $logo)
                 <div class="logo-cell flex-1 flex items-center justify-center p-8 lg:p-10 group cursor-pointer transition-all duration-300 hover:bg-white"
                     style="{{ $colIndex < count($row) - 1 ? 'border-right:1px solid #d8d0c8;' : '' }} min-height:200px;">
                     <img src="{{ asset($logo->img_path) }}"
                         alt="{{ $logo->title ?? 'Brand' }}"
                         class="w-auto object-contain grayscale opacity-70 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-300"
                         onerror="this.style.display='none';" />
                 </div>
                 @endforeach

                 @php
                 $expectedCount = ($rowIndex % 2 === 0) ? 5 : 4;
                 $emptyCount = $expectedCount - count($row);
                 @endphp
                 @if($emptyCount > 0)
                 @for($e = 0; $e < $emptyCount; $e++)
                     <div class="flex-1"
                     style="min-height:140px; {{ $rowIndex < count($rows) - 1 ? 'border-left:1px solid #d8d0c8;' : '' }}">
             </div>
             @endfor
             @endif

         </div>
         @endforeach
     </div>

     {{-- ── Mobile: flat 2-column grid ── --}}
     <div class="grid grid-cols-2 sm:grid-cols-3 md:hidden">
         @foreach($rows as $row)
         @foreach($row as $logo)
         <div class="flex items-center justify-center p-6 border-b border-r border-[#d8d0c8] group cursor-pointer transition-all duration-300 hover:bg-white"
             style="min-height:110px;">
             <img src="{{ asset($logo->img_path) }}"
                 alt="{{ $logo->title ?? 'Brand' }}"
                 class="max-h-12 w-auto object-contain grayscale opacity-70 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-300"
                 onerror="this.style.display='none';" />
         </div>
         @endforeach
         @endforeach
     </div>

     </div>
     @endif

 </section>



 @endsection