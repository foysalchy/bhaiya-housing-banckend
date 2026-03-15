@extends('layouts.front')

@section('title', 'Invest')

@section('content')

{{-- HERO SECTION --}}
<section aria-label="Invest Hero">
    <div class="relative flex items-center justify-start border-b-2 gradient-x-border overflow-hidden h-[300px] md:h-[400px]">
        <img class="absolute inset-0 w-full h-full object-cover" alt="" role="presentation"
            src="{{ $hero && $hero->img_path ? asset('/') . $hero->img_path : asset('frontend/images/invest-hero.webp') }}">
        <div class="absolute inset-0 bg-black/60" aria-hidden="true"></div>
        <div class="relative text-white px-4">
            <h1 class="lg:whitespace-nowrap font-medium mb-2 lg:mb-0 lg:text-7xl text-5xl">
                {{ $hero->title ?? 'Invest' }}
            </h1>
            <p class="text-sm md:text-xl opacity-100">
                {{ $hero->short ?? 'Secure high returns with Right Aid\'s growth potential' }}
            </p>
        </div>
    </div>
</section>

{{-- WHY INVEST SECTION --}}
<section aria-labelledby="why-invest-heading">
    <div class="bg-white" id="invest">
        <div class="relative lg:pt-32 pt-20">
            <div class="absolute inset-0 bg-cover bg-center" aria-hidden="true"
                style="background-image: url('{{ asset('frontend/images/pattern.webp') }}');"></div>
            <div class="relative z-10">

                <div class="xl:px-72 lg:px-40 md:px-20 px-4 pb-16 md:text-center">
                    <h2 id="why-invest-heading" class="lg:text-6xl text-4xl lg:leading-16 font-medium text-slate-950 mb-6">
                        Why <span class="text-brand-accent">Invest</span> In Right Aid Hospital
                    </h2>
                    @if($invest && $invest->body)
                        <div class="lg:text-xl text-slate-600 space-y-8 mb-8" data-aos="fade-up" data-aos-offset="50">
                            {!! $invest->body !!}
                        </div>
                    @endif
                </div>

                {{-- Mobile stats: grid cards (hidden on lg+) --}}
                <div class="lg:hidden grid grid-cols-2 gap-4 px-4 pb-10">
                    @foreach($stats as $stat)
                        <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-100">
                            <h2 class="text-xl font-semibold text-slate-900 mb-1">{{ $stat->title }}</h2>
                            <p class="text-sm text-slate-600">{{ $stat->short }}</p>
                        </div>
                    @endforeach
                </div>

                {{-- Mobile image (hidden on lg+) --}}
                <div class="lg:hidden px-4 pb-10">
                    <img class="w-full rounded-2xl object-cover max-h-[300px]"
                        alt="Right Aid Hospital building exterior"
                        src="{{ $invest && $invest->img_path ? asset('/') . $invest->img_path : asset('frontend/images/invest-hero.webp') }}">
                </div>

                {{-- Desktop: original image + absolute stats (hidden on < lg) --}}
                <div class="relative lg:my-20 md:my-10 overflow-hidden hidden lg:block">
                    <img class="max-sm:h-[600px] mx-auto object-cover"
                        alt="Right Aid Hospital building exterior"
                        src="{{ $invest && $invest->img_path ? asset('/') . $invest->img_path : asset('frontend/images/invest-hero.webp') }}">

                    @foreach($stats as $index => $stat)
                        @php
                            $positions = [
                                0 => 'absolute sm:top-[10%] top-[5%] sm:left-[12%] right-[6%]',
                                1 => 'absolute sm:top-[40%] top-[28%] sm:left-[12%] right-[6%]',
                                2 => 'absolute sm:top-[10%] top-[52%] lg:right-[10%] md:right-[2%] right-[6%]',
                                3 => 'absolute sm:top-[40%] top-[74%] lg:right-[10%] md:right-[2%] right-[6%]',
                            ];
                            $isRight = $index >= 2;
                        @endphp
                        <div class="{{ $positions[$index] ?? 'absolute top-[5%] right-[6%]' }} aos-init"
                            data-aos="{{ $isRight ? 'fade-left' : 'fade-right' }}" data-aos-offset="100">
                            <h2 class="text-2xl font-semibold text-slate-900 mb-2">{{ $stat->title }}</h2>
                            @if($isRight)
                                <img alt="" aria-hidden="true" role="presentation"
                                    class="absolute right-[40%] hidden lg:block"
                                    src="{{ asset('frontend/images/right_handle_black.svg') }}">
                            @else
                                <img alt="" aria-hidden="true" role="presentation"
                                    class="absolute hidden lg:block"
                                    src="{{ asset('frontend/images/left_handle_black.svg') }}">
                            @endif
                            <p class="w-xs lg:mt-4 text-slate-600">{{ $stat->short }}</p>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>

        {{-- INVEST CARDS — original desktop, simplified mobile --}}
        @php
            $cardBorders = ['border-[#A855F7]', 'border-[#7564EA]', 'border-[#546EE1]', 'border-[#3179D9]', 'border-[#0088CD]'];
            $cardRotates = ['-rotate-10', 'rotate-0', 'rotate-12', '-rotate-10', 'rotate-0'];
        @endphp

        {{-- Mobile cards (hidden on lg+) --}}
        <div class="lg:hidden grid grid-cols-1 sm:grid-cols-2 gap-4 px-4 py-10">
            @foreach($investCards as $index => $card)
                <div class="bg-slate-900 border-4 {{ $cardBorders[$index % 5] }} rounded-3xl p-6">
                    <h3 class="text-xl text-white font-medium mb-3">{{ $card->title }}</h3>
                    <p class="text-slate-400 text-sm">{{ $card->short }}</p>
                </div>
            @endforeach
        </div>

        {{-- Desktop cards — original code untouched (hidden on < lg) --}}
        <div class="hidden lg:flex flex-wrap justify-center gap-4 py-20 overflow-hidden"
            role="list" aria-label="Investment benefit cards">
            @foreach($investCards as $index => $card)
                <div tabindex="0" role="listitem"
                    aria-label="{{ $card->title }}: {{ $card->short }}"
                    class="w-48 md:w-56 lg:w-64 h-[375px]
                        bg-slate-900 hover:bg-white focus:bg-white border-4 {{ $cardBorders[$index % 5] }}
                        rounded-3xl flex items-center justify-center text-center
                        transform {{ $cardRotates[$index % 5] }} transition-all duration-500
                        hover:scale-105 focus:scale-105 hover:rotate-0 focus:rotate-0
                        hover:mx-8 focus:mx-8 relative group/title group/desc">
                    <h3 class="lg:px-8 px-2 !text-2xl sm:text-base text-white font-medium transition-all duration-500
                                group-hover/title:-translate-y-20 group-focus/title:-translate-y-20
                                group-hover/title:text-slate-900 group-focus/title:text-slate-900">
                        {{ $card->title }}
                    </h3>
                    <p class="absolute px-4 transition-all duration-500 ease opacity-0
                                group-hover/desc:opacity-100 group-focus/desc:opacity-100
                                group-hover/desc:text-slate-600 group-focus/desc:text-slate-600">
                        {{ $card->short }}
                    </p>
                </div>
            @endforeach
        </div>

    </div>
</section>
{{-- INVESTORS BENEFITS --}}
<section aria-labelledby="benefits-heading">
    <div class="container mx-auto lg:py-32 py-20 max-md:pt-0 xl:px-0 px-4">
        <div class="lg:text-center lg:mb-20 mb-10">
            <h2 id="benefits-heading" class="md:text-6xl text-4xl text-slate-950 font-medium mb-2">Investors Benefits</h2>
            <p class="lg:text-xl text-slate-600">Discover the Rewards of Investing in Healthcare Excellence</p>
        </div>

        @php
            $benefitsArr   = $benefitLeft->values();
            $half          = ceil($benefitsArr->count() / 2);
            $leftBenefits  = $benefitsArr->slice(0, $half);
            $rightBenefits = $benefitsArr->slice($half);
        @endphp

        <div class="flex lg:flex-row flex-col gap-8">
            <ul class="basis-1/3 space-y-8 overflow-hidden list-none p-0 m-0">
                @foreach($leftBenefits as $i => $benefit)
                    <li data-aos="fade-right" data-aos-delay="{{ $i * 50 }}" data-aos-offset="100">
                        <div class="text-slate-900 flex gap-2">
                            <span class="mt-3 text-xs" aria-hidden="true">⬤</span>
                            <p class="lg:text-xl"><strong>{{ $benefit->title }}</strong><br>{{ $benefit->short }}</p>
                        </div>
                    </li>
                @endforeach
            </ul>

            <div class="basis-1/3">
                <img alt="Right Aid Hospital building" src="{{ asset('frontend/images/building.webp') }}">
            </div>

            <ul class="basis-1/3 mt-auto space-y-8 overflow-hidden list-none p-0 m-0">
                @foreach($rightBenefits as $i => $benefit)
                    <li data-aos="fade-left" data-aos-delay="{{ $i * 50 }}" data-aos-offset="100">
                        <div class="text-slate-900 flex gap-2">
                            <span class="mt-3 text-xs" aria-hidden="true">⬤</span>
                            <p class="lg:text-xl"><strong>{{ $benefit->title }}</strong><br>{{ $benefit->short }}</p>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>

{{-- INVEST FORM --}}
<section id="invest-form" aria-labelledby="invest-form-heading">
    <div class="container mx-auto px-4 lg:py-32 md:py-20 max-md:pb-20">
        <div class="flex items-center md:flex-row flex-col lg:gap-20 md:gap-0 gap-10">
            <div class="basis-1/2 lg:text-center">
                <h2 id="invest-form-heading" class="md:text-6xl text-4xl text-slate-950 font-medium lg:mb-8 mb-4">
                    Become an Investor of Right Aid Hospital Today?
                </h2>
                <p class="text-xl text-slate-600 mb-8">
                    Take the first step to join Right Aid Hospital's investment opportunity today.
                </p>
            </div>

            <div class="basis-1/2 overflow-hidden">

                @if(session('invest_success'))
                    <div role="alert" class="mb-4 p-4 bg-green-100 border border-green-400 text-green-800 rounded-xl">
                        {{ session('invest_success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div role="alert" class="mb-4 p-4 bg-red-100 border border-red-400 text-red-800 rounded-xl">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('invest.store') }}" method="POST"
                    class="border border-slate-800 rounded-2xl p-6 bg-slate-50"
                    data-aos="fade-left" data-aos-offset="100"
                    novalidate aria-label="Investor registration form">
                    @csrf

                    <div class="mb-4">
                        <label for="invest_name" class="sr-only">Full Name</label>
                        <input id="invest_name" name="name" value="{{ old('name') }}"
                            placeholder="Full Name*" required autocomplete="name"
                            aria-required="true"
                            class="border-b border-slate-800 w-full p-2 bg-white placeholder:text-slate-800 focus:outline-none focus:border-brand-primary @error('name') border-red-500 @enderror"
                            type="text">
                        @error('name')
                            <span role="alert" class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="invest_email" class="sr-only">Email Address</label>
                            <input id="invest_email" name="email" value="{{ old('email') }}"
                                placeholder="Email*" required autocomplete="email"
                                aria-required="true"
                                class="border-b border-slate-800 w-full p-2 bg-white placeholder:text-slate-800 focus:outline-none focus:border-brand-primary @error('email') border-red-500 @enderror"
                                type="email">
                            @error('email')
                                <span role="alert" class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="invest_phone" class="sr-only">Mobile Number</label>
                            <input id="invest_phone" name="phone" value="{{ old('phone') }}"
                                placeholder="Mobile Number*" required autocomplete="tel"
                                aria-required="true"
                                class="border-b border-slate-800 w-full p-2 bg-white placeholder:text-slate-800 focus:outline-none focus:border-brand-primary @error('phone') border-red-500 @enderror"
                                type="text">
                            @error('phone')
                                <span role="alert" class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="invest_address" class="sr-only">Address</label>
                        <textarea id="invest_address" name="address" placeholder="Address*"
                            rows="5" required aria-required="true"
                            class="border-b border-slate-800 w-full p-2 bg-white placeholder:text-slate-800 focus:outline-none focus:border-brand-primary @error('address') border-red-500 @enderror">{{ old('address') }}</textarea>
                        @error('address')
                            <span role="alert" class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="invest_privacy" class="flex items-center gap-2 cursor-pointer w-fit">
                            <input id="invest_privacy" class="text-slate-800 focus:ring-slate-800 rounded-full mt-1"
                                type="checkbox" name="privacy" required aria-required="true">
                            <span class="text-slate-600">By submitting this form you are agreeing to our
                                <a href="#" class="font-medium text-brand-accent hover:text-brand-secondary transition-colors duration-300 underline">
                                    privacy policy
                                </a>.
                            </span>
                        </label>
                    </div>

                    <button type="submit"
                        class="rounded-full bg-brand-secondary text-white py-2 w-full font-light cursor-pointer hover:bg-brand-accent transition-colors duration-300">
                        Submit Form
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

{{-- FAQ SECTION --}}
<section aria-labelledby="faq-heading">
    <div class="container mx-auto lg:py-32 py-20 max-md:pt-0 px-4">
        <div class="lg:text-center lg:mb-20 mb-10">
            <h2 id="faq-heading" class="md:text-6xl text-4xl text-slate-950 font-medium lg:mb-8 mb-4">
                We're here to answer all your questions
            </h2>
            <p class="text-xl text-slate-600 mb-8">Find Answers to Maximize Your Healthcare Investment</p>
        </div>

        <div class="flex flex-col gap-4 max-w-5xl mx-auto" id="faq-container">
            @foreach($faqs as $i => $faq)
                @php $faqId = 'faq-answer-' . $i; @endphp
                <div class="border-none rounded-2xl overflow-hidden transition-all duration-500 bg-slate-100 faq-item">
                    <button
                        class="w-full flex justify-between items-center gap-4 cursor-pointer text-left px-6 py-5 faq-btn"
                        aria-expanded="false"
                        aria-controls="{{ $faqId }}">
                        <h3 class="text-xl font-medium transition-colors duration-300 text-slate-900">{{ $faq->title }}</h3>
                        <span class="flex items-center justify-center p-2 rounded-full transition-all duration-300 bg-white" aria-hidden="true">
                            <svg class="text-brand-primary transition-opacity duration-300"
                                xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                viewBox="0 0 24 24" fill="none"
                                aria-hidden="true" focusable="false">
                                <path d="M12 18V6M16 12h2M6 12h5.66M12 18V6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </span>
                    </button>
                    <div id="{{ $faqId }}"
                        class="px-6 text-sm md:text-base leading-relaxed text-gray-300 transition-all duration-700 max-h-0 opacity-0 overflow-hidden faq-answer"
                        role="region"
                        aria-hidden="true">
                        {{ $faq->short }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    window.addEventListener('DOMContentLoaded', () => {
        const faqItems = document.querySelectorAll('.faq-item');

        function closeItem(item) {
            const answer = item.querySelector('.faq-answer');
            const btn    = item.querySelector('.faq-btn');
            const h3     = item.querySelector('h3');
            const svg    = item.querySelector('svg');

            answer.classList.remove('max-h-screen', 'opacity-100', 'border-t', 'border-white/20', 'pt-4', 'pb-5');
            answer.classList.add('max-h-0', 'opacity-0');
            answer.setAttribute('aria-hidden', 'true');
            btn.setAttribute('aria-expanded', 'false');
            item.classList.remove('bg-slate-900');
            item.classList.add('bg-slate-100');
            h3.classList.remove('text-white');
            h3.classList.add('text-slate-900');
            svg.innerHTML = '<path d="M12 18V6M16 12h2M6 12h5.66M12 18V6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>';
        }

        function openItem(item) {
            const answer = item.querySelector('.faq-answer');
            const btn    = item.querySelector('.faq-btn');
            const h3     = item.querySelector('h3');
            const svg    = item.querySelector('svg');

            answer.classList.remove('max-h-0', 'opacity-0');
            answer.classList.add('max-h-screen', 'opacity-100', 'text-gray-300', 'border-t', 'border-white/20', 'pt-4', 'pb-5');
            answer.setAttribute('aria-hidden', 'false');
            btn.setAttribute('aria-expanded', 'true');
            item.classList.remove('bg-slate-100');
            item.classList.add('bg-slate-900');
            h3.classList.remove('text-slate-900');
            h3.classList.add('text-white');
            svg.innerHTML = '<path d="M6 12h12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>';
        }

        faqItems.forEach(item => {
            item.querySelector('.faq-btn').addEventListener('click', () => {
                const answer = item.querySelector('.faq-answer');
                const isOpen = !answer.classList.contains('max-h-0');
                faqItems.forEach(i => closeItem(i));
                if (!isOpen) openItem(item);
            });
        });
    });
</script>
@endpush