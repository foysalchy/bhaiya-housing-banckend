 @extends('layouts.front')
 @section('title', 'Home page')
 @section('content')

 {{-- ===== HERO ===== --}}
 <section class="relative w-full overflow-hidden" style="height: clamp(320px, 45vw, 560px);">
     <img src="{{ $concernHero?->img_path ?? asset('assets/images/concern.jpg') }}"
         alt="interior" class="absolute inset-0 w-full h-full object-cover" />
     <div class="absolute inset-0 bg-black/50"></div>
     <div class="absolute inset-0 flex items-center px-10 md:px-20">
         <h2 class="text-white font-light" style="font-size:clamp(22px,3.5vw,52px); line-height:1.2;">
             {!! $concernHero?->title ?? "
             <em style=\"font-family:'Cormorant Garamond',serif; font-style:italic; font-weight:300;\">
                 Expanding Excellence,<br>Our Other Ventures
             </em>"
             !!}
         </h2>
     </div>
 </section>

 {{-- ===== MAIN SECTION ===== --}}
 <section class="w-full py-16" style="background:#f2ede6;">

     <div class="mx-auto px-6 lg:px-14">

         <!-- Two column text -->
         <div class="grid grid-cols-1 md:grid-cols-2 gap-10 mb-16">
             <p class="text-sm font-light leading-loose text-gray-600">
                 {{ $concern?->short ?? '' }}
             </p>
            <div class="text-sm font-light leading-loose text-gray-600 prose prose-sm max-w-none">
        {!! $concern?->body ?? '' !!}
    </div>
         </div>

     </div>

     <!-- Logo Grid -->
     @if(count($rows) > 0)
     <div class="w-full" style="border-top:1px solid #d8d0c8;">

         @foreach($rows as $rowIndex => $row)
         <div class="flex {{ $rowIndex > 0 ? 'border-t border-[#d8d0c8]' : '' }}">

             @foreach($row as $colIndex => $logo)
             <div class="logo-cell flex-1 flex items-center justify-center p-10 group cursor-pointer transition-all duration-300 hover:bg-white"
                 style="{{ $colIndex < count($row) - 1 ? 'border-right:1px solid #d8d0c8;' : '' }} min-height:160px;">
                 <img src="{{ asset($logo->img_path) }}"
                     alt="{{ $logo->title ?? 'Brand' }}"
                     class="max-h-16 w-auto object-contain grayscale opacity-70 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-300"
                     onerror="this.style.display='none';" />
             </div>
             @endforeach

             @php
             $expectedCount = ($rowIndex % 2 === 0) ? 5 : 4;
             $emptyCount = $expectedCount - count($row);
             @endphp

             @for($e = 0; $e < $emptyCount; $e++)
                 <div class="flex-1" style="min-height:160px; border-left:1px solid #d8d0c8;">
         </div>
         @endfor

     </div>
     @endforeach

     </div>
     @endif

 </section>




 @endsection