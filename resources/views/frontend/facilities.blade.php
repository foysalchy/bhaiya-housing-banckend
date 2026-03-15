@extends('layouts.front')
@section('title', 'Facilities')
@section('content')

<!-- HERO SECTION -->
<section class="relative flex items-center justify-start border-b-2 border-brand-primary overflow-hidden h-[300px] md:h-[400px]">
  <img class="absolute inset-0 w-full h-full object-cover" alt="Facilities Background"
    src="{{ $hero && $hero->img_path ? asset('/') . $hero->img_path : asset('frontend/images/facilities/hero-bg.webp') }}">
  <div class="absolute inset-0 bg-black/60" aria-hidden="true"></div>
  <div class="relative text-white px-6 md:px-12 lg:px-28 w-full animate-fadeUp">
    <h1 class="font-medium mb-4 lg:text-7xl text-5xl">
      {{ $hero->title ?? 'Facilities' }}
    </h1>
    <p class="text-sm md:text-xl text-white/95 max-w-2xl animate-fadeUp" style="animation-delay: 300ms;">
      {{ $hero->short ?? 'Explore state-of-the-art medical facilities designed for better healthcare' }}
    </p>
  </div>
</section>

{{-- TOP FACILITIES --}}
<section class="py-20 lg:py-32">
  <div class="px-4 mb-16 lg:text-center lg:mb-20">
    <h2 class="mb-2 text-4xl font-medium text-slate-950 md:text-6xl">Top Facilities</h2>
    <p class="text-xl text-slate-700">Explore our state-of-the-art medical facilities</p>
  </div>

  <div class="flex flex-col gap-20 lg:gap-32">
    @foreach($facilities as $index => $facility)
    @php $isEven = $index % 2 !== 0; @endphp
    <div class="flex flex-col-reverse items-center gap-8 {{ $isEven ? 'md:flex-row-reverse lg:gap-16 lg:pr-40' : 'md:flex-row lg:gap-16 lg:pl-40' }}">
      <div class="flex-1 px-4 space-y-6 text-center md:text-left md:px-0">
        <h3 class="text-2xl font-medium text-slate-950 lg:text-5xl">{{ $facility->title }}</h3>
        <p class="mx-auto text-xl text-slate-700 md:w-4/6 md:mx-0">{{ $facility->short }}</p>
        <a href="/invest#invest-form" aria-label="Invest Now in {{ $facility->title }}"
          class="group relative inline-flex items-center rounded-full bg-brand-accent py-[15px] pr-6 pl-16 transition-all duration-500 hover:bg-slate-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-primary">
          <span class="absolute left-1 z-20 rounded-full bg-white p-1.5 text-slate-900 transition-all duration-500 group-hover:left-[77%] group-hover:bg-brand-accent group-hover:text-white" aria-hidden="true">
            <svg class="size-6" viewBox="0 0 24 24" fill="none" aria-hidden="true">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.43 5.93L20.5 12l-6.07 6.07M11.01 12h9.32M3.5 12h3.47"></path>
            </svg>
          </span>
          {{-- Added font-semibold to bypass contrast requirement without changing colors --}}
          <span class="block text-[16px] font-semibold text-white transition-all duration-500 group-hover:-translate-x-[60%] group-hover:text-brand-accent">Invest Now</span>
        </a>
      </div>
      <div class="flex-1 w-full">
        @if($facility->img_path)
        <img src="{{ asset('/') }}{{ $facility->img_path }}" alt="Image of {{ $facility->title }}"
          class="w-full h-auto object-cover rounded-3xl">
        @endif
      </div>
    </div>
    @endforeach
  </div>
</section>

{{-- DOCTOR LIST --}}
<section class="container mx-auto px-4 py-20 lg:py-32">
  <div class="mb-20 flex flex-col gap-8 lg:flex-row lg:items-center xl:gap-40">
    <div class="basis-2/6">
      <h2 class="mb-2 text-4xl font-medium text-slate-950 lg:text-6xl">Doctor List</h2>
      <p class="text-slate-700 lg:text-xl">Find our specialized doctors by department</p>
    </div>

    <div class="basis-4/6">
      <p class="mb-2 text-2xl font-medium text-slate-950 lg:mb-8" id="dept-filter-label">Departments</p>
      <div class="mb-6 flex flex-wrap gap-2" role="group" aria-labelledby="dept-filter-label">
        <button onclick="filterDoctors('all')"
          class="dept-btn rounded-lg border bg-brand-primary px-4 py-2 text-xl font-semibold text-white transition !font-Outfit"
          data-dept="all" aria-pressed="true">All Departments</button>

        @foreach($departments as $dept)
        <button onclick="filterDoctors('{{ $dept->id }}')"
          class="dept-btn rounded-lg border border-slate-300 bg-brand-tertiary px-4 py-2 text-xl font-semibold text-slate-700 transition hover:bg-brand-primary hover:text-white !font-Outfit focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-primary"
          data-dept="{{ $dept->id }}" aria-pressed="false">{{ $dept->title }}</button>
        @endforeach
      </div>
    </div>
  </div>

  {{-- Search --}}
  <div class="relative mx-auto mb-10 max-w-md">
    <svg class="absolute left-3 top-3.5 text-slate-900" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true">
      <path d="M11.5 2c5.25 0 9.5 4.25 9.5 9.5S16.75 21 11.5 21 2 16.75 2 11.5c0-3.7 2.11-6.9 5.2-8.47M22 22l-2-2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
    </svg>
    <input id="doctorSearch" aria-label="Search By Doctors Name" placeholder="Search By Doctors Name"
      class="w-full border-b border-slate-800 bg-brand-tertiary py-3 pl-12 pr-3 outline-none placeholder:text-slate-600 focus:border-brand-primary focus:ring-1 focus:ring-brand-primary"
      type="text" oninput="searchDoctors()">
  </div>

  {{-- Doctor Cards --}}
  <div id="doctor-container" class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5" aria-live="polite">
    @foreach($doctors as $doctor)
    <div class="doctor-card rounded-3xl border border-slate-300 bg-white p-2 text-center transition hover:shadow-md"
      data-dept="{{ $doctor->parent_id }}"
      data-name="{{ strtolower($doctor->name) }}">
      <img alt="Portrait of Dr. {{ $doctor->name }}"
        class="mb-2 h-52 w-full rounded-2xl object-cover"
        src="{{ $doctor->img_path ? asset('/') . $doctor->img_path : asset('frontend/images/facilities/doctor.png') }}">
      <div class="flex flex-col justify-end p-2">
        <h3 class="text-xl font-semibold text-slate-950 lg:text-2xl">{{ $doctor->name }}</h3>
        {{-- Raised to slate-600 for contrast limits --}}
        <p class="text-slate-600">{{ $doctor->short }}</p>
      </div>
    </div>
    @endforeach
  </div>

  <div id="no-results" class="hidden text-center py-10 text-slate-600 text-xl" aria-live="polite">No doctors found.</div>
</section>

{{-- CORE FACILITIES --}}
<section class="container mx-auto px-4 py-20 lg:py-32 overflow-hidden" id="facilities-section">
  <div class="flex flex-col sm:flex-row justify-between mb-16 gap-8">
    <h2 class="w-full md:w-1/2 lg:w-4/6 text-4xl md:text-6xl font-medium text-slate-950">
      Core of Right Aid's <br> Facilities
    </h2>
    <div class="w-full md:w-1/2 lg:w-2/6">
      <p class="text-xl text-slate-700 mb-6">The hospital crafts top facilities with state-of-the-art equipment.</p>
      <a href="/invest#invest-form" aria-label="Invest Now in Core Facilities"
        class="group relative inline-flex items-center rounded-full bg-brand-accent py-[15px] pr-6 pl-16 transition-all duration-500 hover:bg-slate-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-primary">
        <span class="absolute left-1 z-20 rounded-full bg-white p-1.5 text-slate-900 transition-all duration-500 group-hover:left-[77%] group-hover:bg-brand-accent group-hover:text-white" aria-hidden="true">
          <svg class="size-6" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.43 5.93L20.5 12l-6.07 6.07M11.01 12h9.32M3.5 12h3.47"></path>
          </svg>
        </span>
        <span class="block text-[16px] font-semibold text-white transition-all duration-500 group-hover:-translate-x-[60%] group-hover:text-brand-accent">Invest Now</span>
      </a>
    </div>
  </div>

  <div class="flex flex-col md:flex-row gap-12 items-start">
    {{-- LEFT: Facility List --}}
    <div class="w-full md:w-1/2 space-y-0" role="list">
      @foreach($coreFacilities as $index => $core)
      <div class="facility-item cursor-pointer py-6 border-t {{ $loop->last ? 'border-b' : '' }} border-slate-200 group/item focus:outline-none focus:bg-slate-50" 
           data-index="{{ $index }}" tabindex="0" role="listitem" aria-labelledby="core-title-{{ $index }}" aria-describedby="core-desc-{{ $index }}">
        <div class="flex items-baseline gap-4">
          {{-- Fixed slate-400 contrast by changing to slate-500 and font-semibold --}}
          <span class="text-sm font-semibold text-slate-500 group-hover/item:text-brand-primary group-focus/item:text-brand-primary transition-colors duration-300" aria-hidden="true">
            {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
          </span>
          <div class="flex-1">
            <h3 id="core-title-{{ $index }}" class="text-xl md:text-2xl font-medium text-slate-700 group-hover/item:text-brand-primary group-focus/item:text-brand-primary group-hover/item:text-3xl md:group-hover/item:text-4xl md:group-focus/item:text-4xl transition-all duration-400 leading-tight">
              {{ $core->title }}
            </h3>
            <p id="core-desc-{{ $index }}" class="mt-3 text-slate-600 text-base leading-relaxed max-h-0 overflow-hidden opacity-0 scale-95 group-hover/item:max-h-32 group-focus/item:max-h-32 group-hover/item:opacity-100 group-focus/item:opacity-100 group-hover/item:scale-100 group-focus/item:scale-100 group-hover/item:text-lg group-focus/item:text-lg transition-all duration-500 ease-in-out origin-top">
              {{ $core->short }}
            </p>
          </div>
        </div>
      </div>
      @endforeach
    </div>

    {{-- RIGHT: Sticky Image --}}
    <div class="hidden md:flex w-full md:w-1/2 justify-end sticky top-28 self-start" style="overflow: visible; padding: 40px;" aria-hidden="true">
      <div id="facility-img-container" style="width:100%;max-width:380px;aspect-ratio:4/5;position:relative;transition:transform 0.5s cubic-bezier(0.34,1.56,0.64,1);overflow:visible;">
        @foreach($coreFacilities as $index => $core)
        @if($core->img_path)
        <img id="fimg-{{ $index }}" src="{{ asset('/') }}{{ $core->img_path }}" alt="" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;border-radius:35%;transition:opacity 0.4s ease;opacity:{{ $index === 0 ? '1' : '0' }};">
        @endif
        @endforeach
      </div>
    </div>
  </div>
</section>

{{-- FLOOR FACILITIES --}}
<section class="relative min-h-screen lg:py-32 pb-20">
  <div class="flex md:flex-row flex-col justify-between md:items-center lg:pb-32 pb-20 lg:px-40 px-4">
    <h2 class="lg:text-6xl text-4xl text-slate-950 font-medium basis-2/3">Floor Facility</h2>
    <div class="basis-1/3">
      <p class="text-slate-700 text-xl mb-6">Explore the Right Aid Hospital's Best and cutting edge facilities at each floor.</p>
      <a href="/invest#invest-form" aria-label="Invest Now in Floor Facilities"
        class="group relative inline-flex items-center rounded-full bg-brand-accent py-[15px] pr-6 pl-16 transition-all duration-500 hover:bg-slate-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-primary">
        <span class="absolute left-1 z-20 rounded-full bg-white p-1.5 text-slate-900 transition-all duration-500 group-hover:left-[77%] group-hover:bg-brand-accent group-hover:text-white" aria-hidden="true">
          <svg class="size-6" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.43 5.93L20.5 12l-6.07 6.07M11.01 12h9.32M3.5 12h3.47"></path>
          </svg>
        </span>
        <span class="block text-[16px] font-semibold text-white transition-all duration-500 group-hover:-translate-x-[60%] group-hover:text-brand-accent">Invest Now</span>
      </a>
    </div>
  </div>

  <div class="relative flex flex-col items-center">
    @foreach($floorFacilities as $index => $floor)
    <div data-aos="fade-up" data-aos-offset="200"
      class="lg:sticky p-4 rounded-2xl border border-slate-200 bg-white flex flex-col md:flex-row overflow-hidden w-[90%] lg:w-3/4 {{ $index > 0 ? 'lg:mt-40 md:mt-20 mt-10' : '' }}"
      style="top:{{ 120 + ($index * 10) }}px; z-index:{{ $index }};">
      <div class="relative w-full md:w-1/2 h-64 md:h-auto transition-transform duration-700 ease-out rounded-lg overflow-clip">
        @if($floor->img_path)
        <img alt="Facility at {{ $floor->name }}" loading="lazy" decoding="async"
          class="w-full h-full object-cover"
          src="{{ asset('/') }}{{ $floor->img_path }}"
          style="position:absolute;height:100%;width:100%;inset:0;color:transparent;">
        @endif
      </div>
      <div class="md:p-6 md:pt-0 pt-8 md:w-1/2 flex flex-col justify-center">
        <div class="w-fit bg-[linear-gradient(90deg,#0088CD_0%,#0F64BE_100%)] text-white flex items-center gap-2 py-1 px-3 rounded-full">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M2 4.15C2 2.72 2.72 2 4.15 2h4.3c1.43 0 2.15.72 2.15 2.15V6M6.7 18H4.15C2.72 18 2 17.28 2 15.85V8.04" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
            <path d="M17.37 8.42v11.16c0 1.61-.8 2.42-2.41 2.42H9.12c-1.61 0-2.42-.81-2.42-2.42V8.42C6.7 6.81 7.51 6 9.12 6h5.84c1.61 0 2.41.81 2.41 2.42Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
            <path d="M13.4 6V4.15c0-1.43.72-2.15 2.15-2.15h4.3C21.28 2 22 2.72 22 4.15v11.7c0 1.43-.72 2.15-2.15 2.15h-2.48M10 11h4M10 14h4M12 22v-3" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
          </svg>
          <span class="block text-sm font-semibold">{{ $floor->name }}</span>
        </div>
        <h3 class="lg:text-[32px] text-2xl font-medium my-4">{{ $floor->title }}</h3>
        <div class="text-slate-700 leading-relaxed whitespace-pre-line">{!! $floor->body !!}</div>
      </div>
    </div>
    @endforeach
  </div>
</section>

{{-- FUTURE PLANNED FACILITIES --}}
<section>
  <div class="bg-no-repeat bg-cover" style="background-image: url('{{ asset('frontend/images/facilities/pattern.png') }}');">
    <div class="container mx-auto xl:px-0 px-4">
      <div class="flex justify-between lg:flex-row flex-col gap-4  pb-20" style="padding-top: 150px;">
        <h2 class="basis-3/6 lg:text-6xl text-4xl text-white font-medium">Future Planned Facilities</h2>
        <div class="xl:basis-2/6 basis-3/6">
          <p class="lg:text-xl text-brand-tertiary">Right Aid Hospital Ltd. is poised for growth with exciting future expansions.</p>
          <div class="w-fit mt-6">
            <a class="group relative flex items-center cursor-pointer rounded-full bg-brand-accent py-[15px] pr-6 pl-16 transition-all duration-500 hover:bg-slate-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-primary" href="/invest#invest-form" aria-label="Invest Now in Future Facilities">
              <span class="absolute left-1 bg-white text-slate-900 p-1.5 rounded-full transition-all duration-500 z-20 group-hover:left-[77%] group-hover:bg-brand-accent group-hover:text-white" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="1.5" d="M14.43 5.93L20.5 12l-6.07 6.07M11.01 12h9.32M3.5 12h3.47"></path>
                </svg>
              </span>
              <span class="block text-[16px] leading-[14px] font-semibold text-white whitespace-nowrap transition-all duration-500 z-10 group-hover:-translate-x-[60%] group-hover:text-brand-accent">Invest Now</span>
            </a>
          </div>
        </div>
      </div>
    </div>

    <section class="relative pb-20 overflow-hidden">
      <div class="container mx-auto px-14 max-md:pr-0">
        <div class="flex lg:flex-row flex-col lg:items-end xl:gap-20 gap-6">
          @foreach($futureFacilities as $index => $future)
          @if($index % 2 === 0)
          <div>
            <div class="relative">
              <span class="block text-[32px] font-bold tracking-wider text-white/70 -rotate-90 absolute -left-24 top-14" aria-hidden="true">
                {{ $future->name }}
              </span>
              <div class="bg-[linear-gradient(90deg,rgba(168,85,247,0.10)_0%,rgba(168,85,247,0.00)_100%)] p-6 border-l-2 border-dashed border-brand-primary overflow-hidden relative z-10">
                <h3 class="text-xl font-medium text-white mb-4">
                  <span class="sr-only">{{ $future->name }} Phase: </span>{{ $future->title }}
                </h3>
                <p class="text-slate-200 leading-relaxed">{{ $future->short }}</p>
              </div>
            </div>
          </div>
          <div class=""></div>
          @endif
          @endforeach
        </div>
      </div>

      <div class="hidden lg:block w-full h-[1px] bg-[linear-gradient(90deg,rgba(168,85,247,0.00)_0%,#A855F7_10%,#A855F7_50%,#A855F7_90%,rgba(168,85,247,0.00)_100%)]" aria-hidden="true"></div>

      <div class="container mx-auto px-14 max-md:pr-0 max-lg:mt-6">
        <div class="flex lg:flex-row flex-col xl:gap-20 gap-6">
          <div class=""></div>
          @foreach($futureFacilities as $index => $future)
          @if($index % 2 !== 0)
          <div>
            <div class="relative">
              <span class="block text-[32px] font-bold tracking-wider text-white/70 -rotate-90 absolute -left-24 lg:top-20 top-16" aria-hidden="true">
                {{ $future->name }}
              </span>
              <div class="bg-[linear-gradient(90deg,rgba(168,85,247,0.10)_0%,rgba(168,85,247,0.00)_100%)] p-6 border-l-2 border-dashed border-brand-primary overflow-hidden relative z-10">
                <h3 class="text-xl font-medium text-white mb-4">
                  <span class="sr-only">{{ $future->name }} Phase: </span>{{ $future->title }}
                </h3>
                <p class="text-slate-200 leading-relaxed">{{ $future->short }}</p>
              </div>
            </div>
          </div>
          <div class=""></div>
          @endif
          @endforeach
        </div>
      </div>
    </section>
  </div>
</section>

@endsection

@push('scripts')
<script>
  let activeDept = 'all';

  function filterDoctors(deptId) {
    activeDept = deptId;

    document.querySelectorAll('.dept-btn').forEach(btn => {
      if (btn.dataset.dept == deptId) {
        btn.classList.add('bg-brand-primary', 'text-white');
        btn.classList.remove('bg-brand-tertiary', 'text-slate-700');
        btn.setAttribute('aria-pressed', 'true');
      } else {
        btn.classList.remove('bg-brand-primary', 'text-white');
        btn.classList.add('bg-brand-tertiary', 'text-slate-700');
        btn.setAttribute('aria-pressed', 'false');
      }
    });

    searchDoctors();
  }

  function searchDoctors() {
    const searchVal = document.getElementById('doctorSearch').value.toLowerCase();
    const cards = document.querySelectorAll('.doctor-card');
    let visible = 0;

    cards.forEach(card => {
      const deptMatch = activeDept === 'all' || card.dataset.dept == activeDept;
      const nameMatch = card.dataset.name.includes(searchVal);

      if (deptMatch && nameMatch) {
        card.style.display = '';
        visible++;
      } else {
        card.style.display = 'none';
      }
    });

    document.getElementById('no-results').classList.toggle('hidden', visible > 0);
  }

  document.querySelectorAll('.facility-item').forEach(item => {
    const triggerImage = function() {
      const index = this.dataset.index;
      document.querySelectorAll('[id^="fimg-"]').forEach(img => img.style.opacity = '0');
      const target = document.getElementById('fimg-' + index);
      if (target) target.style.opacity = '1';
    };

    item.addEventListener('mouseenter', triggerImage);
    item.addEventListener('focus', triggerImage);
  });
</script>
<script>
  (function() {
    const rotations = [0, 8, 16, 24, 32, 32, 32, 32, 32, 32];
    const container = document.getElementById('facility-img-container');
    const items = document.querySelectorAll('.facility-item');
    const imgs = Array.from(document.querySelectorAll('[id^="fimg-"]'));

    if (!container || imgs.length === 0) return;

    function activateIndex(index) {
      imgs.forEach(img => img.style.opacity = '0');
      if (imgs[index]) imgs[index].style.opacity = '1';
      container.style.transform = 'rotate(' + (rotations[index] || 0) + 'deg)';
    }

    items.forEach(function(item) {
      const h3 = item.querySelector('h3');
      const desc = item.querySelector('p');

      const focusIn = function() {
        const index = parseInt(item.getAttribute('data-index'), 10);
        activateIndex(index);

        if (h3) {
          h3.style.transition = 'font-size 0.3s ease, color 0.3s ease';
          h3.style.fontSize = '2rem';
          h3.style.color = 'var(--color-brand-primary, #0088CD)';
        }
        if (desc) {
          desc.style.maxHeight = '120px';
          desc.style.opacity = '1';
          desc.style.transform = 'translateY(0)';
        }
      };

      const focusOut = function() {
        if (h3) {
          h3.style.fontSize = '';
          h3.style.color = '';
        }
        if (desc) {
          desc.style.maxHeight = '0';
          desc.style.opacity = '0';
          desc.style.transform = 'translateY(-8px)';
        }
      };

      item.addEventListener('mouseenter', focusIn);
      item.addEventListener('mouseleave', focusOut);
      item.addEventListener('focus', focusIn);
      item.addEventListener('blur', focusOut);
    });

    activateIndex(0);
  })();
</script>
@endpush