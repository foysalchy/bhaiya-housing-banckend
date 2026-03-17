@extends('layouts.front')

@section('title', 'About')

@section('content')

 <main class="">
    <!-- HERO ABOUT SECTION -->
    <section class="relative min-h-[500px] flex items-center py-24 overflow-hidden">

        <div class="absolute inset-0 z-0">
            <img src="{{ asset($about->img_path ?? '') }}"
                alt="{{ $about->title }}"
                class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/55"></div>
        </div>

        <div class="relative z-10 w-full" style="padding-left: 8%; padding-right: 8%;">

            <!-- Heading Animated -->
            <h2 data-aos="fade-up" data-aos-duration="1000"
                class="text-5xl sm:text-6xl lg:text-[9vh] font-bold text-white leading-tight">
              {!! $about->title ?? '' !!}
            </h2>

            <!-- Two Column Text Animated -->
           @if($about->body || $about->body_2)
            <div class="flex font-medium text-lg" style="gap: 35px; padding-top: 60px; padding-left: 100px;">
                @if($about->body)
                <div data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200"
                    style="color: white !important;">
                    <style>
                        .about-body-1, .about-body-1 * { color: white !important; }
                    </style>
                    <div class="about-body-1 leading-relaxed">
                        {!! $about->body !!}
                    </div>
                </div>
                @endif
                @if($about->body_2)
                <div data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
                    <style>
                        .about-body-2, .about-body-2 * { color: white !important; }
                    </style>
                    <div class="about-body-2 leading-relaxed">
                        {!! $about->body_2 !!}
                    </div>
                </div>
                @endif
            </div>
            @endif

        </div>
    </section>

    <!-- ===== MISSION & VISION SECTION ===== -->
    <section class="relative w-full overflow-visible py-20 md:py-32">

        <!-- Split Background -->
        <div class="absolute inset-0 z-0 flex">
            <div class="w-1/2 bg-white"></div>
            <div class="w-1/2 relative bg-white">
                @if($missionVision?->img_path)
                <img src="{{ asset($missionVision->img_path) }}" class="w-full h-full object-cover">
                @endif
            </div>
        </div>

        @php
            $mvImages = is_array($missionVision?->img_paths)
                ? $missionVision->img_paths
                : json_decode($missionVision?->img_paths ?? '[]', true);
            $leftImg        = $mvImages[2] ?? null;
            $topRightImg    = $mvImages[1] ?? null;
            $bottomRightImg = $mvImages[0] ?? null;
        @endphp

        <div class="relative w-full" style="padding-left:0; padding-right:8%;">

            <!-- IMAGE GRID -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 md:gap-6">

                <!-- Left Vertical Image -->
                <div class="md:col-span-4 relative -mt-10 md:-mt-44 z-10" data-aos="fade-up" data-aos-duration="1000">
                    @if($leftImg)
                    <img src="{{ asset($leftImg) }}" class="w-full h-auto object-cover shadow-sm">
                    @endif
                </div>

                <!-- Right Column -->
                <div class="md:col-span-8 flex flex-col relative">

                    <!-- Kitchen Image -->
                    @if($topRightImg)
                    <div class="w-full md:w-[85%] lg:w-[75%] self-end relative z-10 -mt-10 md:-mt-44"
                        data-aos="fade-left" data-aos-duration="1200">
                        <img src="{{ asset($topRightImg) }}" class="w-full h-auto object-cover shadow-sm">
                        <div class="absolute -bottom-6 -left-6 w-20 h-20">
                            <img src="{{ asset('images/mission-stone.png') }}" class="w-full h-full object-contain">
                            <div class="w-12 h-12">
                                <img src="{{asset('images/stone-bg.svg')}}" class="w-full h-full object-contain">
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Heading -->
                    <div class="mt-10 md:mt-14 md:ml-12" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                        <h2 class="text-3xl md:text-5xl lg:text-7xl font-serif text-[#595959] leading-snug tracking-tight">
                            {!! $missionVision->title ?? '' !!}
                        </h2>
                    </div>

                    <!-- Living Room Image -->
                    @if($bottomRightImg)
                    <div class="w-full md:w-[50%] lg:w-[45%] self-end mt-12 md:mt-16 relative z-20 mb-16 md:mb-20"
                        data-aos="fade-up" data-aos-duration="1200">
                        <div class="relative">
                            <img src="{{ asset($bottomRightImg) }}" class="w-full h-auto object-cover shadow-sm">
                            <div class="absolute -bottom-8 -right-6 w-16 h-16">
                                <img src="{{ asset('images/mission-stone-bottom.png') }}" class="w-full h-full object-contain">
                            </div>

                        </div>
                    </div>
                    @endif

                </div>
            </div>

            <!-- Mission & Vision -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-16 md:gap-10 relative z-30"
                style="padding-left:8%; padding-right:4%; margin-top: 40vh;">

                <!-- Mission -->
                <div class="md:col-span-6 relative" data-aos="fade-right">
                    <h2 class="font-serif italic text-[3rem] md:text-[4rem] lg:text-[6rem] leading-none text-[#1520187D] absolute -top-20 -left-6 z-0 opacity-40">
                        {{ $missionVision?->name ?? 'Mission' }}
                    </h2>
                    <div class="relative z-10 pt-16">
                        <p class="text-gray-700 font-light text-sm md:text-lg leading-relaxed max-w-2xl">

                            {!! $missionVision->body ?? '' !!}
                        </p>
                    </div>
                </div>

                <!-- Vision -->
                <div class="md:col-span-6 relative mt-32 md:mt-48" data-aos="fade-left">
                    <h2 class="font-serif italic text-[3rem] md:text-[4rem] lg:text-[6rem] leading-none text-[#1520187D] absolute -top-20 -left-6 z-0 opacity-40">
                        {{ $missionVision?->short ?? 'Vision' }}
                    </h2>
                    <div class="relative z-10 pt-16">
                        <p class="text-gray-700 font-light text-sm md:text-lg leading-relaxed max-w-2xl">
                            {!! $missionVision->body_2 ?? '' !!}
                        </p>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- ===== TIMELINE SECTION ===== -->
    <section id="timeline-section" class="relative w-full min-h-screen flex flex-col justify-between overflow-hidden bg-zinc-950 text-white py-16 px-6 md:px-20 lg:px-32">

        <!-- Background Image -->
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/timeline-bg.avif') }}"
                alt="Background"
                class="w-full h-full object-cover grayscale">
        </div>

        <!-- 1. Top Title -->
        <div class="relative z-10 w-full" data-aos="fade-down">
            @php $titleLines = explode(' ', $historyTimeline?->title ?? 'History Timeline'); @endphp
            <h2 class="text-6xl md:text-[120px] lg:text-[153px] font-semibold tracking-tight leading-none text-[#f6f6f6] opacity-90">
                @foreach($titleLines as $word)
                <span>{{ $word }}</span><br>
                @endforeach
            </h2>
        </div>

        <!-- 2. Middle Content -->
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-center mt-10">

            <!-- Image & Year -->
            <div class="relative flex items-center">
                <div class="relative z-10" data-aos="zoom-in" data-aos-duration="1200">
                    <div class="w-[280px] h-[350px] md:w-[400px] md:h-[500px] overflow-hidden transform -rotate-6 shadow-2xl border-4 border-zinc-800 bg-zinc-900">
                        <img id="timeline-img"
                            src="{{ $timelineItems->first()?->img_path ? asset($timelineItems->first()->img_path) : '' }}"
                            alt="Timeline"
                            class="w-full h-full object-cover transition-all duration-700">
                    </div>
                </div>

                <h1 id="timeline-year"
                    class="absolute z-20 left-20 md:left-48 lg:left-64 text-[5rem] md:text-[9rem] lg:text-[11rem] font-bold leading-none text-gray-300 opacity-90 select-none tracking-tighter transition-all duration-700 pointer-events-none">
                    {{ $timelineItems->first()?->title }}
                </h1>
            </div>

            <!-- Description -->
            <div id="content-wrap" class="relative z-30 mt-12 md:mt-40 md:ml-40 lg:ml-60 max-w-lg transition-all duration-500">
                <h3 id="timeline-title" class="text-3xl md:text-5xl font-semibold mb-6 text-white leading-tight">
                    {!! nl2br(e($timelineItems->first()?->name ?? '')) !!}
                </h3>
                <p id="timeline-desc" class="text-gray-400 text-base md:text-lg leading-relaxed">
                    {!! $timelineItems->first()?->short !!}
                </p>
            </div>
        </div>

        <!-- 3. Bottom Timeline Bar -->
        <div class="relative z-40 w-full mt-20 pb-10">
            <div class="relative w-full h-[2px] bg-gray-700 flex justify-between items-center">
                <div id="progress-line" class="absolute left-0 top-0 h-full w-0 bg-white transition-all duration-700 shadow-[0_0_15px_white]"></div>

                @foreach($timelineItems as $index => $item)
                <button onclick="changeTimeline({{ $index }})"
                    class="nav-dot relative z-10 w-6 h-6 rounded-full outline-none transition-all
                        {{ $index === 0 ? 'bg-white ring-8 ring-white/10 shadow-[0_0_15px_white]' : 'bg-gray-600 hover:bg-gray-400' }}">
                </button>
                @endforeach
            </div>
        </div>

    </section>


   <!-- ===== MESSAGE FROM LEADERS SECTION ===== -->
    <section class="relative w-full py-20 md:py-32 bg-[#05100a] text-white overflow-hidden">

        <!-- Background -->
        <div class="absolute inset-0 z-0  pointer-events-none">
            <img src="{{ asset($leadersMessage?->img_path ?? 'Message from leaders') }}" alt="leader" class="w-full h-full object-cover">
        </div>

        <div class="container mx-auto px-6 md:px-12 lg:px-24 relative z-10">

            <!-- Section Title -->
            <div class="mb-16 md:mb-24" data-aos="fade-up">
                <h2 class="text-4xl md:text-6xl font-semibold tracking-tight">
                    {{ $leadersMessage?->title ?? 'Message from leaders' }}
                </h2>
            </div>

            @foreach($leaders as $index => $leader)

            @if($index % 2 == 0)
            <!-- Image Left, Text Right -->
            <div class="flex flex-col md:flex-row items-center gap-12 lg:gap-20 mb-32">

                <!-- Image -->
                <div class="w-full md:w-1/2 relative" data-aos="fade-right">
                    <div class="relative z-10 overflow-hidden shadow-2xl">
                        <img src="{{ asset($leader->img_path ?? '') }}"
                            alt="{{ $leader->title ?? ''}}"
                            class="w-full h-auto grayscale hover:grayscale-0 transition-all duration-700 object-cover">
                    </div>
                    <div class="absolute -bottom-6 -left-6 w-12 h-12 z-20">
                        <img src="{{ asset('images/stone-bg.svg') }}" alt="stone" class="w-full h-full opacity-80">
                    </div>
                </div>

                <!-- Content -->
                <div class="w-full md:w-1/2" data-aos="fade-left">
                    <div class="mb-6">
                        <img src="{{ asset('images/comma.svg') }}" alt="comma">
                    </div>
                    <h3 class="text-4xl font-bold mb-1">{{ $leader->title }}</h3>
                    <p class="text-lg tracking-widest text-gray-200 mb-8">{{ $leader->name }}</p>
                    <div class="space-y-6 text-gray-300 leading-relaxed text-lg md:text-xl font-light">
                        {!! $leader->body ?? '' !!}
                    </div>
                </div>
            </div>

            @else
            <!-- Text Left, Image Right -->
            <div class="flex flex-col-reverse md:flex-row items-center gap-12 lg:gap-20 mb-32">

                <!-- Content -->
                <div class="w-full md:w-1/2" data-aos="fade-right">
                    <div class="mb-6">
                        <img src="{{ asset('images/comma.svg') }}" alt="comma">
                    </div>
                    <h3 class="text-4xl font-bold mb-1">{{ $leader->title ?? '' }}</h3>
                    <p class="text-lg tracking-widest text-gray-200 mb-8">{{ $leader->name ?? '' }}</p>
                    <div class="space-y-6 text-gray-200 leading-relaxed text-lg md:text-xl font-light">
                        {!! $leader->body ?? '' !!}
                    </div>
                </div>

                <!-- Image -->
                <div class="w-full md:w-1/2 relative" data-aos="fade-left">
                    <div class="relative z-10 overflow-hidden shadow-2xl border-l-4 border-emerald-900/30">
                        <img src="{{ asset($leader->img_path ?? '') }}"
                            alt="{{ $leader->title ?? '' }}"
                            class="w-full h-auto object-cover grayscale hover:grayscale-0 transition-all duration-700">
                    </div>
                    <div class="absolute -bottom-6 -left-6 w-12 h-12 z-20 transform rotate-180">
                        <img src="{{ asset('images/stone-bg.svg') }}" alt="stone" class="w-full h-full opacity-80">
                    </div>
                </div>
            </div>
            @endif

            @endforeach

        </div>
    </section>
    <!-- ===== MEET THE VISIONARIES ===== -->
    <section class="relative w-full py-20 bg-[#f9f9f9] overflow-hidden">

        <div class="absolute inset-0 z-0 opacity-40">
            <img src="{{ asset('images/visionaries-bg.png') }}" alt="background" class="w-full h-full object-cover">
        </div>

        <div class="container mx-auto px-6 md:px-12 relative z-10 mb-10">

            <!-- Title -->
            <div class="mb-16">
                <h2 class="text-5xl md:text-[72px] font-semibold text-[#424242] tracking-tight" data-aos="fade-up">
                    {{ $visionaries->first() ? 'Meet the Visionaries' : 'Meet the Visionaries' }}
                </h2>
            </div>

            <!-- Visionaries Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @foreach($visionaries as $index => $member)
                <div class="group" data-aos="fade-up" data-aos-delay="{{ ($index % 4 + 1) * 100 }}">
                    <div class="aspect-[4/5] overflow-hidden bg-gray-200 mb-4 shadow-sm">
                        <img src="{{ asset($member->img_path) }}"
                            alt="{{ $member->title }}"
                            class="w-full h-full object-cover group-hover:grayscale-0 transition-all duration-700">
                    </div>
                    <h6 class="text-2xl font-bold text-gray-800">{{ $member->title }}</h6>
                    <p class="text-lg text-gray-500 font-medium">{{ $member->name }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <!-- ===== ABOUT BHAIYA HOUSING ===== -->
        @php
            $aboutImages = is_array($aboutBhaiya?->img_paths)
                ? $aboutBhaiya->img_paths
                : json_decode($aboutBhaiya?->img_paths ?? '[]', true);
            $aboutRightImg = $aboutImages[0] ?? null;
        @endphp

        <div class="container mx-auto px-6 md:px-6 lg:px-20 mb-10">

            <div class="mb-12 md:mb-16">
                <h2 class="text-5xl md:text-7xl lg:text-[85px] text-[#313131] leading-[0.9] tracking-tight">
                    {!! $aboutBhaiya?->title ?? 'About Bhaiya Housing' !!}
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 lg:gap-24 mb-16 md:mb-24">
                <div class="text-[#595959] text-sm md:text-lg leading-relaxed">
                    {{$aboutBhaiya?->short ?? ''}}
                </div>
                <div class="text-[#595959] text-sm md:text-lg leading-relaxed">
                    {{$aboutBhaiya?->extra ?? ''}}
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 lg:gap-10">
                @if($aboutBhaiya?->img_path)
                <div class="md:col-span-4" data-aos="fade-right" data-aos-duration="1000">
                    <img src="{{ asset($aboutBhaiya->img_path) }}" alt="About" class="w-full h-full object-cover">
                </div>
                @endif
                @if($aboutRightImg)
                <div class="md:col-span-8" data-aos="fade-left" data-aos-duration="1000">
                    <img src="{{ asset($aboutRightImg) }}" alt="About" class="w-full h-full object-cover">
                </div>
                @endif
            </div>
        </div>

        <!-- ===== ABOUT BHAIYA HOUSING GROUP ===== -->
        @php
            $groupImages = is_array($aboutBhaiyaGroup?->img_paths)
                ? $aboutBhaiyaGroup->img_paths
                : json_decode($aboutBhaiyaGroup?->img_paths ?? '[]', true);
            $groupOverflowImg = $groupImages[0] ?? null;
        @endphp

        <div class="container mx-auto px-6 md:px-12 lg:px-20">

            <div class="mb-12 md:mb-16 relative">
                <h2 class="text-5xl md:text-7xl lg:text-[85px] text-[#313131] leading-tight tracking-tight">
                    {!! $aboutBhaiyaGroup?->title ?? 'About Bhaiya Housing Group' !!}
                </h2>
                <div class="absolute top-1/2 -left-10 md:-left-4 opacity-70">
                    <img src="{{ asset('images/stone-bg.svg') }}" alt="stone" class="w-8 h-8 md:w-12 md:h-12 object-contain">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10 lg:gap-24 mb-20 md:mb-32">
                <div class="text-[#595959] text-sm md:text-[15px] leading-relaxed">
                    {!! $aboutBhaiyaGroup?->body !!}
                </div>
                <div class="text-[#595959] text-sm md:text-[15px] leading-relaxed">
                    {!! $aboutBhaiyaGroup?->body_2 !!}
                </div>
            </div>
        </div>

        <!-- Cover Image with Overflow Small Image -->
        <div class="relative w-full overflow-visible">
            @if($aboutBhaiyaGroup?->img_path)
            <div class="w-full">
                <img src="{{ asset($aboutBhaiyaGroup->img_path) }}"
                    alt="Cover"
                    class="w-full h-[350px] md:h-[560px] lg:h-[700px] object-cover block">
            </div>
            @endif

            @if($groupOverflowImg)
            <div class="absolute top-[-8%] left-[6%] z-20"
                data-aos="fade-down" data-aos-duration="1200" data-aos-easing="ease-out-back">
                <div class="absolute -top-6 -left-12 w-12 h-12 md:w-16 md:h-16 z-30">
                    <img src="{{ asset('images/stone-bg.svg') }}" class="w-full h-full object-contain">
                </div>
                <img src="{{ asset($groupOverflowImg) }}"
                    alt="Building"
                    class="w-[160px] md:w-[300px] lg:w-[400px] h-auto object-cover block">
            </div>
            @endif
        </div>

    </section>


 </main>

@endsection
<script>
    const timelineData = {!! json_encode($timelineData) !!};

    const total = timelineData.length;

    function changeTimeline(index) {
        const data = timelineData[index];

        document.getElementById('timeline-year').textContent = data.year;
        document.getElementById('timeline-title').innerHTML  = data.title.replace(/\n/g, '<br>');
        document.getElementById('timeline-desc').innerHTML   = data.desc;
        document.getElementById('timeline-img').src          = data.img;

        const percent = total > 1 ? (index / (total - 1)) * 100 : 0;
        document.getElementById('progress-line').style.width = percent + '%';

        document.querySelectorAll('.nav-dot').forEach((dot, i) => {
            dot.classList.toggle('bg-white', i === index);
            dot.classList.toggle('ring-8', i === index);
            dot.classList.toggle('ring-white/10', i === index);
            dot.classList.toggle('shadow-[0_0_15px_white]', i === index);
            dot.classList.toggle('bg-gray-600', i !== index);
        });
    }
</script>
