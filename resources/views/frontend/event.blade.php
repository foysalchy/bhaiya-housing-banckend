 @extends('layouts.front')
 @section('title', 'Home page')
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