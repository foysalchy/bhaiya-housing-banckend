<div class="relative mt-0 pt-0">
    <div>

        {{--
            Google reCAPTCHA v3 (invisible — no checkbox UI).
            Site key comes from config/services.php -> env('RECAPTCHA_SITE_KEY').
            Loaded once, guarded in case the site already includes it elsewhere.
        --}}
        @if(!isset($recaptchaSiteKey))
            @php($recaptchaSiteKey = config('services.recaptcha.site_key'))
        @endif
        @if($recaptchaSiteKey)
        <script>
            window.__recaptchaSiteKey = @json($recaptchaSiteKey);
        </script>
        @once
        <script src="https://www.google.com/recaptcha/api.js?render={{ $recaptchaSiteKey }}"></script>
        <style>
            /*
                Google's default reCAPTCHA v3 badge is a small fixed
                bottom-right shield icon — it visually collides with our
                own floating buttons in that corner. Hiding it is allowed
                by Google's terms ONLY if the required attribution text
                (see the form's "protected by reCAPTCHA" note) is shown
                somewhere on the page instead.
            */
            .grecaptcha-badge { visibility: hidden !important; }
        </style>
        @endonce
        @endif

        {{-- Phone Button — (বাম পাশে নিচে) --}}
        @if($setting?->extra)
        <div class="fixed lg:bottom-10 bottom-8 lg:left-20 left-4 z-40 w-fit">
            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $setting->extra) }}"
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

        {{-- Chat Toggle + Socials — (বাম পাশে, ফোনের ঠিক উপরে) --}}
        @if($socials->isNotEmpty())
        <div class="fixed lg:bottom-26 bottom-24 lg:left-20 left-4 z-40">
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

        {{-- Scroll to Top Button — (ডান পাশে নিচে) --}}
        <button
            id="scroll-to-top-btn"
            type="button"
            aria-label="Scroll to top"
            class="fixed lg:bottom-10 bottom-8 lg:right-20 right-4 z-40 w-12 h-12 flex items-center justify-center bg-[linear-gradient(180deg,#0088CD_0%,#A855F7_100%)] rounded-full shadow-lg border-0 p-0 cursor-pointer overflow-hidden opacity-0 translate-y-6 pointer-events-none transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2">
            <svg class="text-white relative z-10" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                <polyline points="18 15 12 9 6 15"></polyline>
            </svg>
            <span class="absolute inset-0 before:absolute before:top-0 before:left-[-75%] before:h-full before:w-[50%] before:bg-gradient-to-r before:from-transparent before:via-white/50 before:to-transparent before:skew-x-12 before:animate-shine" aria-hidden="true"></span>
        </button>

        {{-- ===================== Apartment Inquiry Chat Widget — (ডান পাশে, scroll-to-top এর ঠিক উপরে) ===================== --}}
        <div id="inquiry-widget" class="fixed lg:bottom-26 bottom-24 lg:right-20 right-4 z-50">

            {{-- Floating toggle button (messenger-style) --}}
            <button
                id="inquiry-toggle-btn"
                type="button"
                aria-expanded="false"
                aria-controls="inquiry-card"
                aria-label="Open apartment inquiry form"
                class="relative w-12 h-12 flex items-center justify-center bg-[linear-gradient(180deg,#0088CD_0%,#A855F7_100%)] rounded-full shadow-lg cursor-pointer overflow-hidden border-0 p-0 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2">
                <svg class="text-white relative z-10" xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                    viewBox="0 0 24 24" fill="none" aria-hidden="true" focusable="false">
                    <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span class="absolute inset-0 before:absolute before:top-0 before:left-[-75%] before:h-full before:w-[50%] before:bg-gradient-to-r before:from-transparent before:via-white/50 before:to-transparent before:skew-x-12 before:animate-shine" aria-hidden="true"></span>
            </button>

            {{-- Inquiry form card --}}
            <div id="inquiry-card"
                class="hidden opacity-0 scale-95 pointer-events-none origin-bottom-right transition-all duration-300
                       fixed lg:absolute inset-x-4 bottom-24 lg:inset-auto lg:bottom-16 lg:right-0
                       lg:w-80 w-auto max-h-[80vh] overflow-y-auto bg-white rounded-2xl shadow-2xl"
                role="dialog" aria-modal="false" aria-labelledby="inquiry-card-title">

                <div class="flex items-start justify-between gap-3 p-4 rounded-t-2xl bg-[linear-gradient(180deg,#0088CD_0%,#A855F7_100%)] text-white">
                    <h3 id="inquiry-card-title" class="font-semibold leading-snug">
                        Are you interested to buy an apartment?
                    </h3>
                    <button id="inquiry-close-btn" type="button" aria-label="Close form"
                        class="shrink-0 w-7 h-7 flex items-center justify-center rounded-full bg-white/20 hover:bg-white/30 border-0 cursor-pointer">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" aria-hidden="true">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>

     
                <div id="inquiry-form" class="p-4 space-y-3" data-action="{{ route('contact.inquiry') }}">
                    @csrf
                    <input type="hidden" name="type" value="lead">
                    <input type="hidden" name="subject" value="Interested to buy an apartment">
                    <input type="hidden" name="source" value="floating_widget">

                    <div>
                        <label for="inquiry-name" class="block text-sm font-medium text-gray-700 mb-1">Name <span class="text-red-500">*</span></label>
                        <input id="inquiry-name" name="name" type="text" required
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-900 placeholder-gray-400 bg-white focus:outline-none focus:ring-2 focus:ring-[#0088CD]">
                    </div>

                    <div>
                        <label for="inquiry-phone" class="block text-sm font-medium text-gray-700 mb-1">Phone <span class="text-red-500">*</span></label>
                        <input id="inquiry-phone" name="phone" type="number" required
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-900 placeholder-gray-400 bg-white focus:outline-none focus:ring-2 focus:ring-[#0088CD]">
                    </div>

                    <div>
                        <label for="inquiry-email" class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-gray-400 text-xs">(optional)</span></label>
                        <input id="inquiry-email" name="email" type="email"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-900 placeholder-gray-400 bg-white focus:outline-none focus:ring-2 focus:ring-[#0088CD]">
                    </div>

                    <div>
                        <label for="inquiry-designation" class="block text-sm font-medium text-gray-700 mb-1">Designation <span class="text-gray-400 text-xs">(optional)</span></label>
                        <input id="inquiry-designation" name="designation" type="text"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-900 placeholder-gray-400 bg-white focus:outline-none focus:ring-2 focus:ring-[#0088CD]">
                    </div>

                    <div>
                        <label for="inquiry-message" class="block text-sm font-medium text-gray-700 mb-1">Message <span class="text-gray-400 text-xs">(optional)</span></label>
                        <textarea id="inquiry-message" name="message" rows="3"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-900 placeholder-gray-400 bg-white resize-none focus:outline-none focus:ring-2 focus:ring-[#0088CD]"></textarea>
                    </div>

                    <p id="inquiry-error" class="hidden text-sm text-red-500"></p>

                    <button type="button" id="inquiry-submit-btn"
                        class="w-full mt-1 py-2.5 rounded-lg font-medium text-white bg-[linear-gradient(180deg,#0088CD_0%,#A855F7_100%)] cursor-pointer border-0 disabled:opacity-60">
                        Submit
                    </button>

                    @if($recaptchaSiteKey ?? config('services.recaptcha.site_key'))
                    <p class="text-[11px] leading-snug text-gray-400 text-center mt-2">
                        This site is protected by reCAPTCHA and the Google
                        <a href="https://policies.google.com/privacy" target="_blank" rel="noopener noreferrer" class="underline">Privacy Policy</a> and
                        <a href="https://policies.google.com/terms" target="_blank" rel="noopener noreferrer" class="underline">Terms of Service</a> apply.
                    </p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Centered "submitted" success overlay --}}
        <div id="inquiry-success-overlay"
            class="hidden opacity-0 fixed inset-0 z-[60] flex items-center justify-center pointer-events-none transition-opacity duration-300 bg-black/20">
            <div class="bg-white rounded-2xl shadow-2xl px-8 py-6 flex flex-col items-center gap-3 mx-4">
                <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                </div>
                <p class="font-medium text-gray-800 text-center">Form submitted successfully!</p>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {

        // Guard against this whole script running more than once — if this
        // partial ever gets included twice on the same page (layout +
        // page-level include, for example), every button below would get
        // TWO click listeners, firing two concurrent submissions from a
        // single click. That race condition explains inconsistent
        // behavior between browsers (whichever request's response lands
        // last wins the UI state), even when the first request already
        // saved to the DB successfully.
        if (window.__floatingWidgetsInitialized) {
            return;
        }
        window.__floatingWidgetsInitialized = true;

        // Resolves with a fresh reCAPTCHA v3 token, or null if the site key
        // isn't configured / the script hasn't loaded — submission still
        // works in that case, it's just unprotected (e.g. local dev without keys).
        function getRecaptchaToken(action) {
            return new Promise(function(resolve) {
                if (!window.grecaptcha || !window.__recaptchaSiteKey) {
                    resolve(null);
                    return;
                }
                grecaptcha.ready(function() {
                    grecaptcha.execute(window.__recaptchaSiteKey, { action: action })
                        .then(resolve)
                        .catch(function() { resolve(null); });
                });
            });
        }

        // --- Chat Toggle Logic ---
        const toggleBtn = document.getElementById('chat-toggle-btn');
        const chatIcons = document.getElementById('chat-icons');
        if (toggleBtn && chatIcons) {
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
        }

        // --- Scroll to Top Logic ---
        const scrollTopBtn = document.getElementById('scroll-to-top-btn');
        if (scrollTopBtn) {
            // স্ক্রল ৩০০ পিক্সেল অতিক্রম করলে বাটনটি দেখাবে
            window.addEventListener('scroll', function() {
                if (window.scrollY > 300) {
                    scrollTopBtn.classList.remove('opacity-0', 'translate-y-6', 'pointer-events-none');
                    scrollTopBtn.classList.add('opacity-100', 'translate-y-0', 'pointer-events-auto');
                } else {
                    scrollTopBtn.classList.remove('opacity-100', 'translate-y-0', 'pointer-events-auto');
                    scrollTopBtn.classList.add('opacity-0', 'translate-y-6', 'pointer-events-none');
                }
            });

            // বাটনে ক্লিক করলে স্মুথ স্ক্রল হয়ে উপরে যাবে
            scrollTopBtn.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        }

        // --- Apartment Inquiry Widget Logic ---
        const inquiryToggleBtn = document.getElementById('inquiry-toggle-btn');
        const inquiryCard = document.getElementById('inquiry-card');
        const inquiryCloseBtn = document.getElementById('inquiry-close-btn');
        const inquiryForm = document.getElementById('inquiry-form');
        const inquiryError = document.getElementById('inquiry-error');
        const successOverlay = document.getElementById('inquiry-success-overlay');

        if (inquiryToggleBtn && inquiryCard) {

            const DISMISS_KEY = 'inquiryWidgetDismissed';

            function markInquiryDismissed() {
                try { sessionStorage.setItem(DISMISS_KEY, '1'); } catch (e) {}
            }

            function wasInquiryDismissed() {
                try { return sessionStorage.getItem(DISMISS_KEY) === '1'; } catch (e) { return false; }
            }

            function openInquiryCard() {
                inquiryCard.classList.remove('hidden');
                // reflow before animating in
                requestAnimationFrame(() => {
                    inquiryCard.classList.remove('opacity-0', 'scale-95', 'pointer-events-none');
                    inquiryCard.classList.add('opacity-100', 'scale-100');
                });
                inquiryToggleBtn.setAttribute('aria-expanded', 'true');
                inquiryToggleBtn.setAttribute('aria-label', 'Close apartment inquiry form');
                // Page scroll stays enabled on purpose — no overflow lock on <body>.
            }

            function closeInquiryCard() {
                inquiryCard.classList.remove('opacity-100', 'scale-100');
                inquiryCard.classList.add('opacity-0', 'scale-95', 'pointer-events-none');
                inquiryToggleBtn.setAttribute('aria-expanded', 'false');
                inquiryToggleBtn.setAttribute('aria-label', 'Open apartment inquiry form');
                setTimeout(() => inquiryCard.classList.add('hidden'), 300);
                // Once dismissed (in any way) it should not auto-pop again
                // on later pages this session — only manual clicks reopen it.
                markInquiryDismissed();
            }

            function isInquiryOpen() {
                return !inquiryCard.classList.contains('hidden') && inquiryCard.classList.contains('opacity-100');
            }

            inquiryToggleBtn.addEventListener('click', function() {
                isInquiryOpen() ? closeInquiryCard() : openInquiryCard();
            });

            inquiryCloseBtn.addEventListener('click', closeInquiryCard);

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && isInquiryOpen()) {
                    closeInquiryCard();
                }
            });

            // Auto-open the form once per browser session, on both mobile
            // and desktop. Once the user closes it (× button, Escape,
            // clicking the toggle to close, or a successful submit), it
            // will NOT auto-open again on subsequent page loads this
            // session — it just sits as a normal floating button that
            // opens only when clicked.
            if (!wasInquiryDismissed()) {
                setTimeout(openInquiryCard, 900);
            }

            // --- Form submit (AJAX) ---
            // inquiryForm is a <div>, not a real <form>, so there's no native
            // submit event or FormData(form) shortcut — fields are collected
            // and validated manually, and the request fires on a button click.
            const inquirySubmitBtn = document.getElementById('inquiry-submit-btn');

            function resetInquiryFieldStyles() {
                inquiryForm.querySelectorAll('input, textarea').forEach(function(el) {
                    el.classList.remove('border-red-500');
                });
            }

            if (inquiryForm && inquirySubmitBtn) {
                let inquirySubmitInFlight = false;

                inquirySubmitBtn.addEventListener('click', function() {
                    if (inquirySubmitInFlight) {
                        return; // a request is already out — ignore extra clicks
                    }

                    inquiryError.classList.add('hidden');
                    resetInquiryFieldStyles();

                    const nameEl = document.getElementById('inquiry-name');
                    const phoneEl = document.getElementById('inquiry-phone');
                    const missing = [];

                    if (!nameEl.value.trim()) { missing.push(nameEl); }
                    if (!phoneEl.value.trim()) { missing.push(phoneEl); }

                    if (missing.length) {
                        missing.forEach(el => el.classList.add('border-red-500'));
                        inquiryError.textContent = 'Name and Phone are required.';
                        inquiryError.classList.remove('hidden');
                        missing[0].focus();
                        return;
                    }

                    inquirySubmitInFlight = true;
                    const originalLabel = inquirySubmitBtn.textContent;
                    inquirySubmitBtn.disabled = true;
                    inquirySubmitBtn.textContent = 'Sending...';

                    getRecaptchaToken('inquiry_submit').then(function(token) {
                        const formData = new FormData();
                        inquiryForm.querySelectorAll('input, textarea').forEach(function(el) {
                            if (el.name) { formData.append(el.name, el.value); }
                        });
                        if (token) {
                            formData.append('g-recaptcha-response', token);
                        }

                        return fetch(inquiryForm.dataset.action, {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                            },
                            body: formData,
                        });
                    })
                        .then(async (res) => {
                            const raw = await res.text();
                            let data = {};
                            try { data = raw ? JSON.parse(raw) : {}; } catch (parseErr) {
                                // Response wasn't valid JSON — log the raw body so the
                                // real cause (HTML error page, redirect, etc.) is visible
                                // in the console instead of a generic message.
                                console.error('Inquiry form: non-JSON response', res.status, raw);
                            }
                            if (!res.ok) {
                                const err = new Error('Request failed with status ' + res.status);
                                err.data = data;
                                throw err;
                            }
                            return data;
                        })
                        .then(function() {
                            inquiryForm.querySelectorAll('input[type="text"], input[type="number"], input[type="email"], textarea').forEach(function(el) {
                                el.value = '';
                            });
                            closeInquiryCard();
                            showSuccessOverlay();
                        })
                        .catch(function(err) {
                            // Log the actual error (network failure, blocked
                            // request, parse error, etc.) so it's visible in
                            // the console instead of only the generic message.
                            console.error('Inquiry form submit failed:', err);
                            const messages = err && err.data && err.data.errors
                                ? Object.values(err.data.errors).flat().join(' ')
                                : 'Something went wrong. Please check the form and try again.';
                            inquiryError.textContent = messages;
                            inquiryError.classList.remove('hidden');
                        })
                        .finally(function() {
                            inquirySubmitInFlight = false;
                            inquirySubmitBtn.disabled = false;
                            inquirySubmitBtn.textContent = originalLabel;
                        });
                });
            }
        }

        function showSuccessOverlay() {
            if (!successOverlay) return;
            successOverlay.classList.remove('hidden');
            requestAnimationFrame(() => successOverlay.classList.add('opacity-100'));
            setTimeout(function() {
                successOverlay.classList.remove('opacity-100');
                setTimeout(() => successOverlay.classList.add('hidden'), 300);
            }, 2000);
        }
    });
</script>
@endpush