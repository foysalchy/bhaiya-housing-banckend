import './bootstrap';
import AOS from 'aos';
import 'aos/dist/aos.css';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

// ১. গ্লোবাল এক্সেস (সবার আগে)
window.gsap = gsap;
window.ScrollTrigger = ScrollTrigger;
window.AOS = AOS;
window.isMobile = window.innerWidth < 1024;
gsap.registerPlugin(ScrollTrigger);

const initApp = () => {
    // ২. AOS ও Parallax (মোবাইলে অফ)
    AOS.init({ duration: 800, once: true, disable: window.isMobile });

    if (!window.isMobile) {
        // ডেক্সটপ Parallax
        gsap.utils.toArray("[data-speed]").forEach((el) => {
            gsap.to(el, {
                y: (i, target) => (1 - parseFloat(target.dataset.speed || 1)) * 100,
                scrollTrigger: { trigger: el, scrub: true }
            });
        });

        // ৩. Quality Image Hover Zoom (যেটা কাজ করছিল না)
        document.querySelectorAll('.quality-col').forEach(col => {
            const wrap = col.querySelector('.quality-img-wrap');
            const img = col.querySelector('.quality-img');
            if (wrap && img) {
                col.addEventListener('mouseenter', () => {
                    wrap.style.width = '100%';
                    img.style.transform = 'scale(1.06)';
                });
                col.addEventListener('mouseleave', () => {
                    wrap.style.width = '75%';
                    img.style.transform = 'scale(1)';
                });
            }
        });
    }

    // ৪. Quality Border Line (Home Page)
    if (document.querySelector('.quality-border-line')) {
        gsap.to('.quality-border-line', {
            width: '100%',
            duration: 1.4,
            scrollTrigger: { trigger: '#quality-grid', start: 'top 80%', once: true }
        });
    }
};

// ৫. হেডার লজিক
const initHeader = () => {
    const header = document.getElementById("site-header");
    let lastScroll = 0;
    window.addEventListener("scroll", () => {
        const s = window.scrollY;
        if (s > 100 && s > lastScroll) header?.classList.add("hide");
        else header?.classList.remove("hide");
        lastScroll = s;
    }, { passive: true });
};

window.addEventListener('load', () => {
    initApp();
    initHeader();
});

// ৬. ভিডিও মোডাল ফাংশন (গ্লোবাল)
window.openVideoModal = () => {
    const modal = document.getElementById('videoModal');
    const video = document.getElementById('modalVideo');
    if (!video.src) {
        video.src = video.getAttribute('data-src');
        video.load();
    }
    modal.style.display = 'flex';
    video.play();
};
window.closeVideoModal = () => {
    const video = document.getElementById('modalVideo');
    if (video) video.pause();
    document.getElementById('videoModal').style.display = 'none';
};
