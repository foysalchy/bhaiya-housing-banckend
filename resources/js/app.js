import "./bootstrap";
import AOS from "aos";
import "aos/dist/aos.css";
import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import Swiper from "swiper/bundle";
import "swiper/css/bundle";
import Lenis from "lenis";
import GLightbox from 'glightbox';
import 'glightbox/dist/css/glightbox.min.css';
window.Swiper = Swiper;

// ১. গ্লোবাল এক্সেস (সবার আগে)
window.AOS = AOS;
window.gsap = gsap;
window.ScrollTrigger = ScrollTrigger;
gsap.registerPlugin(ScrollTrigger);
window.isMobile = window.innerWidth < 1024;
const lenis = new Lenis();
lenis.on("scroll", ScrollTrigger.update);
gsap.ticker.add((time) => lenis.raf(time * 1000));
gsap.ticker.lagSmoothing(0);
window.lenis = lenis;

const lightbox = GLightbox({
    selector: '.glightbox', 
    touchNavigation: true,
    loop: true,
    zoomable: true
});
const initApp = () => {
    AOS.init({
        duration: 800,
        once: true,
        disable: window.isMobile,
    });

    if (!window.isMobile) {
        gsap.utils.toArray(".scroll-move").forEach((el) => {
            const speed = parseFloat(el.dataset.speed || 0.2);
            let rawAxis = el.dataset.axis || "Y";
            let isNegative = rawAxis.startsWith("-");
            let axis = isNegative
                ? rawAxis.substring(1).toLowerCase()
                : rawAxis.toLowerCase();

            // মুভমেন্ট ৫০০ পিক্সেল পর্যন্ত বাড়ানো হলো যাতে অনেক বেশি নড়াচড়া করে
            let moveDistance = 500 * speed;
            let finalMove = isNegative ? moveDistance : -moveDistance;

            gsap.to(el, {
                [axis]: finalMove,
                ease: "none",
                scrollTrigger: {
                    trigger: el,
                    start: "top bottom", // স্ক্রিনে ঢোকার সময় শুরু
                    end: "bottom top", // স্ক্রিন থেকে বের হওয়ার সময় শেষ
                    scrub: 1.5, // 👈 এটি আপনার আগের 'lerp' এর মতো স্মুথ ইফেক্ট দিবে
                },
            });
        });
        // Quality Image Hover Zoom
        document.querySelectorAll(".quality-col").forEach((col) => {
            const wrap = col.querySelector(".quality-img-wrap");
            const img = col.querySelector(".quality-img");
            if (wrap && img) {
                col.addEventListener("mouseenter", () => {
                    wrap.style.width = "100%";
                    img.style.transform = "scale(1.06)";
                });
                col.addEventListener("mouseleave", () => {
                    wrap.style.width = "75%";
                    img.style.transform = "scale(1)";
                });
            }
        });
    }

    // ৩. Quality Border Line (Home Page)
    if (document.querySelector(".quality-border-line")) {
        gsap.to(".quality-border-line", {
            width: "100%",
            duration: 1.4,
            scrollTrigger: {
                trigger: "#quality-grid",
                start: "top 80%",
                once: true,
            },
        });
    }
};

// ৫. ভিডিও মোডাল ফাংশন
window.openVideoModal = () => {
    const modal = document.getElementById("videoModal");
    const video = document.getElementById("modalVideo");
    if (modal && video) {
        modal.style.display = "flex";
        video.currentTime = 0;
        video.play().catch(() => {});
    }
};

window.closeVideoModal = () => {
    const modal = document.getElementById("videoModal");
    const video = document.getElementById("modalVideo");
    if (video) video.pause();
    if (modal) modal.style.display = "none";
};
// ৪. হেডার লজিক (অপ্টিমাইজড)
const initHeader = () => {
    const header = document.getElementById("site-header");
    if (!header) return;
    let lastScroll = 0;

    lenis.on("scroll", ({ scroll }) => {
        if (scroll > 100 && scroll > lastScroll) {
            header.style.transform = "translateY(-100%)";
        } else {
            header.style.transform = "translateY(0)";
            header.style.background = scroll > 80 ? "#152018" : "transparent";
        }
        lastScroll = scroll;
    });
};
window.openMenu = () => {
    const overlay = document.getElementById("menuOverlay");
    if (overlay) {
        overlay.classList.add("is-open");
        overlay.style.pointerEvents = "all";
        document.body.style.overflow = "hidden";
    }
};

window.closeMenu = () => {
    const overlay = document.getElementById("menuOverlay");
    if (overlay) {
        overlay.classList.remove("is-open");
        overlay.style.pointerEvents = "none";
        document.body.style.overflow = "";
    }
};
window.hoverLink = (el) => {
    const img = el.getAttribute("data-img");
    const menuImg = document.getElementById("menuImage");
    if (img && menuImg) {
        menuImg.src = img;
    }
};
// সব লজিক উইন্ডো লোড হওয়ার পর রান করুন
// app.js এর শেষে এই পরিবর্তনটি করুন
window.addEventListener("load", () => {
    // পেজ লোড হওয়ার ১ সেকেন্ড পর ভারী কাজগুলো শুরু হবে
    setTimeout(() => {
        initApp();
        initHeader();
        if (window.AOS) window.AOS.refresh();
    }, 1000);
});
