<div class="relative">
    <div>

        {{-- Phone Button — $setting->extra থেকে --}}
        @if($setting?->extra)
        <div class="fixed lg:bottom-10 bottom-8 lg:left-20 right-2 z-40 w-fit">
            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $setting->extra) }}"
                class="ml-[2%] md:ml-[4%]"
                aria-label="Call: {{ $setting->extra }}">
                <div class="relative w-12 h-12 flex items-center justify-center bg-[linear-gradient(180deg,#0088CD_0%,#A855F7_100%)] rounded-full shadow-lg cursor-pointer overflow-hidden">
                    <svg class="text-white relative z-10" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" aria-hidden="true" focusable="false">
                        <path d="M9.39 6.01c.18.25.31.48.4.7.09.21.14.42.14.61 0 .24-.07.48-.21.71-.13.23-.32.47-.56.71l-.76.79c-.11.11-.16.24-.16.4 0 .08.01.15.03.23.03.08.06.14.08.2.18.33.49.76.93 1.28.45.52.93 1.05 1.45 1.58.54.53 1.06 1.02 1.59 1.47.52.44.95.74 1.29.92.05.02.11.05.18.08.08.03.16.04.25.04.17 0 .3-.06.41-.17l.76-.75c.25-.25.49-.44.72-.56.23-.14.46-.21.71-.21.19 0 .39.04.61.13.22.09.45.22.7.39l3.31 2.35c.26.18.44.39.55.64.1.25.16.5.16.78 0 .36-.08.73-.25 1.09-.17.36-.39.7-.68 1.02-.49.54-1.03.93-1.64 1.18-.6.25-1.25.38-1.95.38-1.02 0-2.11-.24-3.26-.73s-2.3-1.15-3.44-1.98a28.75 28.75 0 0 1-3.28-2.8 28.414 28.414 0 0 1-2.79-3.27c-.82-1.14-1.48-2.28-1.96-3.41C2.24 8.67 2 7.58 2 6.54c0-.68.12-1.33.36-1.93.24-.61.62-1.17 1.15-1.67C4.15 2.31 4.85 2 5.59 2c.28 0 .56.06.81.18.26.12.49.3.67.56"
                            stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span class="absolute inset-0 before:absolute before:top-0 before:left-[-75%] before:h-full before:w-[50%] before:bg-gradient-to-r before:from-transparent before:via-white/60 before:to-transparent before:skew-x-12 before:animate-shine" aria-hidden="true"></span>
                </div>
            </a>
        </div>
        @endif

        {{-- Chat Toggle + Socials --}}
        @if($socials->isNotEmpty())
        <div class="fixed bottom-24 lg:bottom-10 lg:right-20 right-2 z-40">
            <div class="relative flex flex-col items-center gap-2">

                {{-- Dynamic Social Icons --}}
                <div id="chat-icons"
                    class="flex flex-col items-center gap-2 transform transition-all duration-500 opacity-0 translate-y-6 pointer-events-none"
                    aria-hidden="true">

                    @foreach($socials as $social)
                    <a href="{{ $social->url }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        aria-label="{{ $social->title }}"
                        tabindex="-1">
                        <div class="w-12 h-12 flex items-center justify-center rounded-full shadow-lg cursor-pointer transition-colors duration-300 hover:opacity-80"
                            style="background:{{ $social->extra ?? '#1a73e8' }};">
                            {!! $social->short !!}
                        </div>
                    </a>
                    @endforeach

                </div>

                {{-- Toggle Button --}}
                <button
                    id="chat-toggle-btn"
                    type="button"
                    aria-expanded="false"
                    aria-controls="chat-icons"
                    aria-label="Open chat options"
                    class="relative w-12 h-12 flex items-center justify-center bg-[linear-gradient(180deg,#0088CD_0%,#A855F7_100%)] rounded-full shadow-lg cursor-pointer overflow-hidden border-0 p-0 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2">
                    <svg class="text-white relative z-10" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" aria-hidden="true" focusable="false">
                        <path d="M4.13 5.55C2.8 7.12 2 9.11 2 11.26c0 2.9 1.44 5.48 3.68 7.18V22l3.36-1.89c.94.27 1.93.41 2.96.41 5.52 0 10-4.15 10-9.26C22 6.15 17.52 2 12 2c-1.38 0-2.7.26-3.89.73"
                            stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="m11.28 9.25-3.78 4.5 3.69-.9 1.55.9 3.76-4.5-3.51.9-1.71-.9Z"
                            stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span class="absolute inset-0 before:absolute before:top-0 before:left-[-75%] before:h-full before:w-[50%] before:bg-gradient-to-r before:from-transparent before:via-white/50 before:to-transparent before:skew-x-12 before:animate-shine" aria-hidden="true"></span>
                </button>

            </div>
        </div>
        @endif

    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('chat-toggle-btn');
        const chatIcons = document.getElementById('chat-icons');
        if (!toggleBtn || !chatIcons) return;

        const chatLinks = chatIcons.querySelectorAll('a');
        let isOpen = false;

        toggleBtn.addEventListener('click', function() {
            isOpen = !isOpen;
            if (isOpen) {
                chatIcons.classList.remove('opacity-0', 'translate-y-6', 'pointer-events-none');
                chatIcons.classList.add('opacity-100', 'translate-y-0', 'pointer-events-auto');
                chatIcons.setAttribute('aria-hidden', 'false');
                toggleBtn.setAttribute('aria-expanded', 'true');
                toggleBtn.setAttribute('aria-label', 'Close chat options');
                chatLinks.forEach(link => link.removeAttribute('tabindex'));
            } else {
                chatIcons.classList.remove('opacity-100', 'translate-y-0', 'pointer-events-auto');
                chatIcons.classList.add('opacity-0', 'translate-y-6', 'pointer-events-none');
                chatIcons.setAttribute('aria-hidden', 'true');
                toggleBtn.setAttribute('aria-expanded', 'false');
                toggleBtn.setAttribute('aria-label', 'Open chat options');
                chatLinks.forEach(link => link.setAttribute('tabindex', '-1'));
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && isOpen) {
                toggleBtn.click();
                toggleBtn.focus();
            }
        });
    });
</script>
@endpush