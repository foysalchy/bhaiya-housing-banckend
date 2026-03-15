@extends('layouts.front')

@section('title', 'Home')

@section('content')

    <div>
        <!-- Hero Section -->
        <section
            class="relative flex items-center justify-center  border-b-2 gradient-x-border overflow-hidden transition-all duration-[3000ms] ease-in-out h-[300px] md:h-[400px] justify-start">
            <img class="absolute inset-0 w-full h-full object-cover" alt="About us"
                src="{{asset($hero->img_path ?? '')}}">
            <div class="absolute inset-0 bg-black/60"></div>
            <div class="relative  text-white px-4">
                <h1
                    class="lg:whitespace-nowrap font-medium mb-2 lg:mb-0 lg:text-7xl text-5xl transition-all duration-[3000ms]">
                    {{$hero->title ?? "about"}}</h1>
                <p class="text-sm md:text-xl transition-all delay-200 duration-[4000ms] opacity-100">{{ $hero->short ?? "about us" }}</p>
            </div>
        </section>
        <!-- Our History Section -->
        <section>
            <div class="container mx-auto lg:py-32 py-20 overflow-hidden">
                <div class="flex lg:flex-row flex-col gap-12 xl:px-0 px-4">
                    <div class="basis-1/2">
                        <h2 class=" md:text-6xl text-4xl text-slate-950 font-medium lg:mb-8 mb-4">{{$history->title}}</h2>
                        <p class="lg:text-xl text-slate-600 mb-6">{!! $history->body !!}</p>
                        <p class="lg:text-xl text-slate-600 mb-6">{!! $history->body_2 !!}.</p>
                        <div class="w-fit">
                            <div><a class="group relative flex items-center cursor-pointer rounded-full focus:outline-none bg-brand-accent py-[15px] pr-6 pl-16 transition-all duration-500 hover:bg-slate-900 focus:bg-slate-900"
                                    href="/invest#invest-form"><span class="absolute left-1 bg-white text-slate-900 p-1.5 rounded-full transition-all duration-500 z-20
                        group-hover:left-[77%] group-focus:left-[77%]

                        group-hover:bg-brand-accent group-focus:bg-brand-accent
                        group-hover:text-white group-focus:text-white"><svg xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-miterlimit="10" stroke-width="1.5"
                                                d="M14.43 5.93L20.5 12l-6.07 6.07M11.01 12h9.32M3.5 12h3.47"></path>
                                        </svg></span>
                                    <h6 class="text-[16px] leading-[14px] text-white whitespace-nowrap transition-all duration-500 z-10
                        group-hover:-translate-x-[60%] group-focus:-translate-x-[60%]

                        group-hover:text-brand-accent group-focus:text-brand-accent">Invest Now</h6>
                                </a></div>
                        </div>
                    </div>
                    <div class="basis-1/2 relative flex justify-center items-center md:bg-[url('images/box-shapes.svg')]  bg-no-repeat lg:bg-contain bg-center md:py-16"
                        style="background-image: url('images/box-shapes.svg');">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-20 md:gap-y-28 md:gap-x-8">
                            <div class="md:text-white text-center aos-init aos-animate" data-aos="fade-in"
                                data-aos-offset="100">
                                <p class="text-xl md:text-2xl ">Established Over</p>
                                <div class="flex items-end">
                                    <h4 class="text-5xl md:text-7xl font-semibold leading-tight max-md:text-brand-primary">{{$history->short}}</h4>
                                    <p class="text-xl md:text-2xl max-md:text-brand-primary">Years</p>
                                </div>
                            </div>
                            <div class="text-purple-600 text-center aos-init aos-animate" data-aos="fade-in"
                                data-aos-offset="100">
                                <p class="text-xl md:text-2xl text-slate-950">Completed Projects</p>
                                <div class="flex items-end">
                                    <h4 class="text-5xl md:text-7xl font-semibold leading-tight">{{$history->location}}</h4>
                                    <p class="text-xl md:text-2xl mt-2">Initiatives</p>
                                </div>
                            </div>
                            <div class="text-brand-secondary text-center aos-init" data-aos="fade-in"
                                data-aos-offset="100">
                                <p class="text-xl md:text-2xl text-slate-950">Key Business Concerns</p>
                                <div class="flex items-end">
                                    <h4 class="text-5xl md:text-7xl font-semibold leading-tight">{{$history->extra}}</h4>
                                    <p class="text-xl md:text-2xl mt-2">Entities</p>
                                </div>
                            </div>
                            <div class="md:text-white text-center aos-init" data-aos="fade-in" data-aos-offset="100">
                                <p class="text-xl md:text-2xl ">Industries Served</p>
                                <div class="flex items-end">
                                    <h4 class="text-5xl md:text-7xl font-semibold leading-tight max-md:text-brand-primary">{!! $history->body_3 !!}</h4>
                                    <p class="text-xl md:text-2xl max-md:text-brand-primary mt-2">Sectors</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Mission and Vision Section -->
        <section>
            <div class="container mx-auto lg:py-32 md:py-20 xl:px-0 px-4 max-md:pb-20">
                <div class="flex lg:flex-row flex-col gap-8 overflow-hidden">

                    <div class="basis-1/3 aos-init" data-aos="fade-right" data-aos-offset="50">
                        <h2 class="lg:text-6xl text-4xl text-slate-950 font-medium lg:mb-8 mb-4">
                            {{ $missionVision->title ?? 'Our Mission' }}
                        </h2>
                        <p class="lg:text-xl text-slate-600">
                            {!! $missionVision->body !!}
                        </p>
                    </div>

                    <div class="basis-1/3">
                        <img alt="Mission Vission" src="{{ asset($missionVision->img_path ? asset( $missionVision->img_path) : asset('assets/images/building.webp')) }}">
                    </div>

                    <div class="basis-1/3 mt-auto aos-init" data-aos="fade-left" data-aos-offset="50">
                        <h2 class="lg:text-6xl text-4xl text-slate-950 font-medium lg:mb-8 mb-4">
                            {{ $missionVision->short ?? 'Our Vision' }}
                        </h2>
                        <p class="lg:text-xl text-slate-600">
                            {!! $missionVision->body_2 !!}
                        </p>
                    </div>

                </div>
            </div>
        </section>
        <!-- Founder Section -->
        <section>
            <div class="bg-slate-950 ">
                <div class="flex md:flex-row flex-col md:items-center gap-8">
                    <div class="basis-5/12"><img class="w-full h-full object-cover" alt="Maksud Ali"
                            src="{{asset($founder->img_path)}}"></div>
                    <div class="basis-7/12">
                        <div class="xl:pl-20 xl:pr-40 px-4 xl:py-60 lg:py-40 md:py-20 py-10">
                            <h2 class="lg:text-6xl text-4xl font-medium text-white lg:mb-8 mb-4">{{ $founder->title ??'' }}</h2>
                            <h4 class="lg:text-xl text-base text-brand-primary lg:mb-4 mb-1">{{ $founder->short ??'' }}</h4>
                            <p class="lg:text-xl text-base text-brand-tertiary">{!! $founder->body !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Members Section -->
        <section>
            <div class="bg-slate-950">
                <div class="bg-contain bg-center bg-no-repeat w-full"
                    style="background-image: url('{{ asset('images/color_shape_2.webp') }}');">
                    <div class="bg-[#02061703] backdrop-blur-3xl">
                        <div class="lg:py-32 md:py-20 py-10 2xl:px-60 lg:px-20 px-4">

                            @forelse($members as $index => $member)

                                @if($index % 2 == 0)
                                    <div class="flex md:flex-row flex-col 2xl:gap-20 gap-6 overflow-hidden {{ !$loop->first ? 'lg:pt-32 md:pt-20 pt-10' : '' }} {{ !$loop->last ? 'lg:pb-32 md:pb-20 pb-10' : '' }}">
                                        <div class="2xl:basis-2/5 md:basis-1/2" data-aos="fade-right" data-aos-offset="100">
                                            @if($member->img_path)
                                                <img class="w-full h-full object-cover" alt="{{ $member->title }}" src="{{ asset($member->img_path) }}">
                                            @endif
                                        </div>
                                        <div class="2xl:basis-3/5 md:basis-1/2" data-aos="fade-left" data-aos-offset="100">
                                            <div class="lg:text-xl text-white lg:space-y-6 space-y-4 md:mb-12 mb-6">
                                                {!! $member->body !!}
                                            </div>
                                            <div>
                                                <h4 class="text-xl text-brand-accent font-medium mb-2">{{ $member->title }}</h4>
                                                <h6 class="text-brand-tertiary/80">{!! nl2br(e($member->short)) !!}</h6>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="flex md:flex-row flex-col-reverse 2xl:gap-20 gap-6 overflow-hidden {{ !$loop->first ? 'lg:pt-32 md:pt-20 pt-10' : '' }} {{ !$loop->last ? 'lg:pb-32 md:pb-20 pb-10' : '' }}">
                                        <div class="2xl:basis-3/5 md:basis-1/2" data-aos="fade-right" data-aos-offset="100">
                                            <div class="lg:text-xl text-white lg:space-y-6 space-y-4 md:mb-12 mb-6">
                                                {!! $member->body !!}
                                            </div>
                                            <div>
                                                <h4 class="text-xl text-brand-accent font-medium mb-2">{{ $member->title }}</h4>
                                                <h6 class="text-brand-tertiary/80">{!! nl2br(e($member->short)) !!}</h6>
                                            </div>
                                        </div>
                                        <div class="2xl:basis-2/5 md:basis-1/2" data-aos="fade-left" data-aos-offset="100">
                                            @if($member->img_path)
                                                <img class="w-full h-full object-cover" alt="{{ $member->title }}" src="{{ asset($member->img_path) }}">
                                            @endif
                                        </div>
                                    </div>
                                @endif

                            @empty
                                <p class="text-white text-center py-10">No members found.</p>
                            @endforelse

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection
