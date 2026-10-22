@extends('layouts.front')
@section('title', 'Office Locations - ' . ($setting->title ?? 'Bhaiya Housing'))

@section('meta')
    @include('partials.meta', ['pageKey' => 'contact'])
@endsection

@section('content')

    {{-- ===== HERO ===== --}}
    <section class="hero-fixed fixed top-0 left-0 w-full overflow-hidden h-[70vh] md:h-[80vh]">
        <img src="{{ $contactHero?->img_path ?? asset('assets/images/contact-customer.jpg') }}" alt="Office Locations"
            class="absolute inset-0 w-full h-full object-cover" />
        <div class="absolute inset-0 bg-black/50"></div>

        <div class="absolute inset-0 flex items-center px-6 sm:px-10 md:px-20">
            <h1 class="text-white font-light md:pl-12 pt-20 md:pt-32 tracking-normal md:tracking-[-3px]"
                style="font-size: clamp(32px, 3.85vw, 68px); line-height: 1.2; font-weight: 500;">
                Our Office Locations <br> &amp; <span class="font-migra-italic">Branch Network</span>
            </h1>
        </div>
    </section>
    <div class="h-[70vh] md:h-[80vh] w-full pointer-events-none" style="position: relative; z-index: 2;"></div>

 

    {{-- ── Main Locations Section ── --}}
    <section class="relative w-full overflow-hidden py-16 md:py-24" style="background:#F6F6F6;">
        <div class="absolute inset-0 pointer-events-none" style="z-index:0;">
            <img src="/assets/images/bg-news.png" alt="" class="w-1/3 h-full object-cover opacity-50"
                onerror="this.style.display='none';" />
        </div>

        <div class="relative z-10 container mx-auto px-6 sm:px-10 md:px-16 lg:px-[100px]">

            {{-- Header Row: Title & Search Filter --}}
            <div class="bg-white rounded-xl shadow-sm p-5 md:p-6 mb-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border border-gray-100">
                <div>
                    <h2 class="text-xl md:text-2xl font-bold text-gray-900 tracking-tight" style="font-family:'Jost',sans-serif;">
                        Our Sales &amp; Office Outlets
                    </h2>
                    <p class="text-sm text-gray-500 mt-0.5">Find the nearest branch or office in your city</p>
                </div>

                <div class="flex items-center gap-3 w-full sm:w-auto">
                    {{-- City Filter --}}
                    @if(isset($cities) && $cities->count() > 0)
                        <div class="relative w-full sm:w-48">
                            <select id="cityFilter" onchange="filterBranch()"
                                class="w-full text-sm bg-gray-50 border border-gray-200 text-gray-700 py-2.5 px-3.5 pr-8 rounded-lg outline-none focus:border-[#C0A46F] focus:bg-white transition-colors">
                                <option value="">All Cities</option>
                                @foreach($cities as $city)
                                    <option value="{{ strtolower($city) }}">{{ ucfirst(strtolower($city)) }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    {{-- Search Input with Icon --}}
                    <div class="relative w-full sm:w-64">
                        <input type="text" id="branchSearch" onkeyup="filterBranch()"
                            placeholder="What's Your City / Branch?"
                            class="w-full text-sm bg-gray-50 border border-gray-200 text-gray-800 placeholder-gray-400 py-2.5 pl-3.5 pr-10 rounded-lg outline-none focus:border-[#C0A46F] focus:bg-white transition-colors" />
                        <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Branch Cards Grid --}}
            <div id="branchGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-7">
                @forelse ($offices as $office)
                    <div class="branch-card bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100 flex flex-col justify-between overflow-hidden p-6"
                        data-city="{{ strtolower($office->name ?? '') }}"
                        data-search="{{ strtolower(($office->title ?? '') . ' ' . ($office->name ?? '') . ' ' . ($office->location ?? '')) }}">
                        
                        <div>
                            {{-- Branch Title & City Badge --}}
                            <div class="flex items-start justify-between gap-3 mb-4 pb-3 border-b border-gray-100">
                                <div>
                                    <h3 class="text-lg md:text-xl font-bold text-gray-900 leading-snug">
                                        {{ $office->title }}
                                    </h3>
                                 
                                </div>
                            </div>

                            {{-- Address --}}
                            @if ($office->location)
                                <div class="mb-4">
                                    <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-gray-900 mb-1.5">
                                        <svg class="w-4 h-4 text-[#152018]" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                                        </svg>
                                        <span>Address</span>
                                    </div>
                                    <p class="text-sm text-gray-600 leading-relaxed pl-6">
                                        {!! nl2br(e($office->location)) !!}
                                    </p>
                                </div>
                            @endif

                            {{-- Phone & Contact Info --}}
                            @if ($office->short || $office->body || $office->body_2 || $office->body_3)
                                <div class="mb-5">
                                    <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-gray-900 mb-2">
                                        <svg class="w-4 h-4 text-[#152018]" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M6.62 10.79a15.053 15.053 0 006.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                                        </svg>
                                        <span>Contact Details</span>
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 pl-6 text-sm">
                                        @if ($office->short)
                                            <div>
                                                <span class="block text-[11px] text-gray-400 font-medium">Primary Phone</span>
                                                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $office->short) }}" class="font-medium text-gray-800 hover:text-[#C0A46F] transition-colors">
                                                    {{ $office->short }}
                                                </a>
                                            </div>
                                        @endif

                                        @if ($office->body)
                                            <div>
                                                <span class="block text-[11px] text-gray-400 font-medium">Alternative Phone</span>
                                                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $office->body) }}" class="font-medium text-gray-800 hover:text-[#C0A46F] transition-colors">
                                                    {{ $office->body }}
                                                </a>
                                            </div>
                                        @endif

                                        @if ($office->body_2)
                                            @php
                                                $waRaw = preg_replace('/[^0-9]/', '', $office->body_2);
                                                if (str_starts_with($waRaw, '0')) {
                                                    $waNum = '880' . substr($waRaw, 1);
                                                } elseif (!str_starts_with($waRaw, '880')) {
                                                    $waNum = '880' . $waRaw;
                                                } else {
                                                    $waNum = $waRaw;
                                                }
                                            @endphp
                                            <div>
                                                <span class="block text-[11px] text-gray-400 font-medium">WhatsApp</span>
                                                <a href="https://wa.me/{{ $waNum }}" target="_blank" rel="noopener" class="font-medium text-emerald-600 hover:underline">
                                                    {{ $office->body_2 }}
                                                </a>
                                            </div>
                                        @endif

                                        @if ($office->body_3)
                                            <div>
                                                <span class="block text-[11px] text-gray-400 font-medium">Email</span>
                                                <a href="mailto:{{ $office->body_3 }}" class="font-medium text-gray-800 hover:text-[#C0A46F] transition-colors truncate block" title="{{ $office->body_3 }}">
                                                    {{ $office->body_3 }}
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Footer: Hours/Off Day & Get Direction --}}
                        <div class="pt-4 border-t border-gray-100 flex items-center justify-between gap-3 mt-2">
                            <div>
                                @if ($office->body_4)
                                    <span class="block text-xs font-semibold text-rose-600">
                                        {{ $office->body_4 }}
                                    </span>
                                @endif
                                @if ($office->meta_title)
                                    <span class="block text-xs font-medium text-gray-500 mt-0.5">
                                        {{ $office->meta_title }} Off
                                    </span>
                                @elseif(!$office->body_4)
                                    <span class="block text-xs font-semibold text-gray-500">
                                        Open Today
                                    </span>
                                @endif
                            </div>

                            @if ($office->url)
                                <a href="{{ $office->url }}" target="_blank" rel="noopener noreferrer"
                                    class="inline-flex items-center gap-1.5 px-3.5 py-1.5 border border-rose-500 text-rose-500 hover:bg-rose-500 hover:text-white rounded-lg text-xs font-medium transition-all duration-200">
                                    <span>Get Direction</span>
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                        <polyline points="15 3 21 3 21 9"></polyline>
                                        <line x1="10" y1="14" x2="21" y2="3"></line>
                                    </svg>
                                </a>
                            @endif
                        </div>

                    </div>
                @empty
                    <div class="col-span-full py-16 text-center bg-white rounded-xl border border-gray-100">
                        <div class="w-16 h-16 mx-auto mb-4 text-gray-300">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0118 0z" />
                                <circle cx="12" cy="10" r="3" />
                            </svg>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-700">No office locations found</h4>
                        <p class="text-sm text-gray-400 mt-1">Please add branch office locations from the admin panel.</p>
                    </div>
                @endforelse
            </div>

            {{-- Empty search result notification --}}
            <div id="noMatchMessage" class="hidden py-16 text-center bg-white rounded-xl border border-gray-100 mt-4">
                <p class="text-base font-medium text-gray-700">No branch locations match your search criteria.</p>
                <p class="text-xs text-gray-400 mt-1">Try clearing the search or choosing another city.</p>
            </div>

        </div>
    </section>

@endsection

@push('scripts')
    <script>
        function filterBranch() {
            const searchVal = (document.getElementById('branchSearch')?.value || '').toLowerCase().trim();
            const cityVal = (document.getElementById('cityFilter')?.value || '').toLowerCase().trim();
            const cards = document.querySelectorAll('.branch-card');
            let visibleCount = 0;

            cards.forEach(card => {
                const cardCity = card.getAttribute('data-city') || '';
                const cardSearch = card.getAttribute('data-search') || '';

                const matchesCity = !cityVal || cardCity.includes(cityVal);
                const matchesSearch = !searchVal || cardSearch.includes(searchVal);

                if (matchesCity && matchesSearch) {
                    card.style.display = 'flex';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            const noMatch = document.getElementById('noMatchMessage');
            if (noMatch) {
                if (visibleCount === 0 && cards.length > 0) {
                    noMatch.classList.remove('hidden');
                } else {
                    noMatch.classList.add('hidden');
                }
            }
        }
    </script>
@endpush

