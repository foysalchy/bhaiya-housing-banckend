// ── Menu Open/Close ──
const overlay  = document.getElementById('menuOverlay');
const menuImg  = document.getElementById('menuImage');
const allLinks = document.querySelectorAll('.menu-link');

function openMenu() {
  overlay.classList.add('is-open');
  document.body.style.overflow = 'hidden';
}

function closeMenu() {
  overlay.classList.remove('is-open');
  document.body.style.overflow = '';
}

// ── Hover Image Swap ──
function hoverLink(el) {
  allLinks.forEach(l => l.style.opacity = '0.25');
  el.style.opacity = '1';

  const newSrc = el.dataset.img;
  if (!newSrc || !menuImg) return;

  menuImg.style.opacity = '0';
  menuImg.style.transform = 'scale(1.08)';
  menuImg.style.transition = 'opacity 0.3s ease, transform 0.5s ease';

  const tempImg = new Image();
  tempImg.onload = () => {
    setTimeout(() => {
      menuImg.src = newSrc;
      menuImg.style.opacity = '1';
      menuImg.style.transform = 'scale(1.03)';
    }, 200);
  };
  tempImg.onerror = () => {
    
    document.getElementById('menuImageWrap').style.background = '#1e3525';
    menuImg.style.display = 'none';
  };
  tempImg.src = newSrc;
}

function unhoverLink(el) {
  allLinks.forEach(l => l.style.opacity = '0.5');
}

    let current = 0;
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.dot');

    function goToSlide(index) {
        slides[current].classList.remove('opacity-100');
        slides[current].classList.add('opacity-0');
        dots[current].classList.remove('h-8', 'opacity-100');
        dots[current].classList.add('h-8', 'opacity-40');

        current = index;

        slides[current].classList.remove('opacity-0');
        slides[current].classList.add('opacity-100');
        dots[current].classList.remove('h-8', 'opacity-40');
        dots[current].classList.add('h-8', 'opacity-100');
    }

    // Auto play
    setInterval(() => {
        goToSlide((current + 1) % slides.length);
    }, 4000);

    function filterTab(el) {
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('bg-gray-900', 'text-white');
            btn.classList.add('bg-white', 'text-gray-700', 'border', 'border-gray-200');
        });
        el.classList.add('bg-gray-900', 'text-white');
        el.classList.remove('bg-white', 'text-gray-700', 'border', 'border-gray-200');
    }

    const timelineData = [
        {
            year: "1972",
            title: "Bhaiya <br> Group",
            desc: "Bhaiya Group of Industries is one of Bangladesh’s most prominent and diversified conglomerates, with a legacy spanning over 50 years. Founded by Alhaj Moksud Ali."
        },
        {
            year: "1988",
            title: "Industrial <br> Expansion",
            desc: "The group expanded its footprint into the manufacturing sector, establishing state-of-the-art facilities and contributing significantly to the national economy."
        },
        {
            year: "2005",
            title: "Real Estate <br> Milestone",
            desc: "Bhaiya Housing started its journey to redefine modern living, focusing on quality architecture and sustainable urban development projects."
        },
        {
            year: "2015",
            title: "Diversified <br> Portfolio",
            desc: "Further diversification into logistics, insurance, and hospitality services, marking a new era of excellence and trust across various sectors."
        },
        {
            year: "2024",
            title: "Future <br> Horizons",
            desc: "Continuing the legacy with innovation and sustainability at the core, building spaces that inspire and empower future generations."
        }
    ];

    function changeTimeline(index) {
        const yearEl = document.getElementById('timeline-year');
        const titleEl = document.getElementById('timeline-title');
        const descEl = document.getElementById('timeline-desc');
        const contentWrap = document.getElementById('content-wrap');
        const dots = document.querySelectorAll('.nav-dot');
        const progressLine = document.getElementById('progress-line');

        contentWrap.style.opacity = '0';
        contentWrap.style.transform = 'translateY(20px)';
        yearEl.style.opacity = '0';
        yearEl.style.transform = 'translate(-20px, 0)';

        setTimeout(() => {
            yearEl.innerText = timelineData[index].year;
            titleEl.innerHTML = timelineData[index].title;
            descEl.innerText = timelineData[index].desc;

            contentWrap.style.opacity = '1';
            contentWrap.style.transform = 'translateY(0)';
            yearEl.style.opacity = '0.9';
            yearEl.style.transform = 'translate(0, 0)';

            dots.forEach((dot, i) => {
                if(i === index) {
                    dot.classList.add('bg-white', 'shadow-[0_0_15px_white]', 'ring-8', 'ring-white/10');
                    dot.classList.remove('bg-gray-600');
                } else {
                    dot.classList.remove('bg-white', 'shadow-[0_0_15px_white]', 'ring-8', 'ring-white/10');
                    dot.classList.add('bg-gray-600');
                }
            });

            const progress = (index / (timelineData.length - 1)) * 100;
            progressLine.style.width = progress + '%';

        }, 400); 
    }
    window.onload = () => changeTimeline(0);

// ESC key close
document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape') closeMenu();
});
