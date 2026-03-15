 
<!DOCTYPE html>
<html lang="en">

<head >
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SALTBAY -    @yield('title') </title>
    <meta name="robots" content="index, follow, max-image-preview:large">
    <meta name="googlebot" content="index, follow">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="icon" href="/favicon.ico">

  

    <!-- Pixel Setup -->
      <!-- Facebook Pixel Code -->
      <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '749680890686257');
        fbq('track', 'PageView');
      </script>
      <noscript>
        <img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=749680890686257&ev=PageView&noscript=1"/>
      </noscript>
      <!-- End Facebook Pixel Code -->

  @yield('meta') 

      <!-- Preconnect for Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />

    <!-- Google Font (Ubuntu) -->
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap" rel="stylesheet" />

  <!-- Font Awesome async preload -->
  <link rel="preload" href="{{ asset('fontawesome/css/all.min.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript>
      <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
  </noscript>

<!-- Slick Slider CSS async preload -->
<link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"
      as="style" onload="this.onload=null;this.rel='stylesheet'">
<link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"
      as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css">
</noscript>

<!-- AOS CSS async preload -->
<link rel="preload" href="https://unpkg.com/aos@2.3.1/dist/aos.css"
      as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript>
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
</noscript>

<!-- Tailwind + Custom CSS -->
@vite(['resources/sass/app.scss', 'resources/js/app.js'])
<link rel="preload" href="{{ asset('frontend/css/custom.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript>
    <link rel="stylesheet" href="{{ asset('frontend/css/custom.css') }}">
</noscript>

<!-- AOS JS defer -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js" defer></script>

</head>

<body class=" bg-gradient-to-r from-blue-50 to-pink-30 font-ubuntu" data-page="index">

    <!--Start Header-->
    @include('frontend.header')

    <main class="min-h-screen">
        @yield('content')
    </main>
    <!--Start Footer-->
    @include('frontend.footer')

    <!-- jQuery (required for Slick) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Slick Slider JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>

    <script src="https://unpkg.com/lenis@1.1.20/dist/lenis.min.js"></script>

    <!-- Custom JavaScript -->
  <script src="{{ asset('frontend/js/script.js') }}"></script>

   <script>
$(document).ready(function () {

  let isAnimating = false;

  function updateSlideContent(slideIndex, slick) {
    if (isAnimating) return;
    isAnimating = true;

    const slide = $(slick.$slides[slideIndex]);

    const category = slide.data('category');
    const title = slide.data('title');
    const description = slide.data('body');
    const imgPath = slide.find('img').attr('src');

    // Fade out
    $('.slide-content').removeClass('fade-in').addClass('fade-out');

    setTimeout(function () {
      $('#slide-category').text(category);
      $('#slide-title').text(title);
      $('#slide-description').text(description);

      changeBackground(imgPath);

      $('.slide-content').removeClass('fade-out').addClass('fade-in');

      setTimeout(() => isAnimating = false, 100);
    }, 600);
  }

  // Slick init
  $('.residence-slider').slick({
    dots: false,
    infinite: true,
    speed: 500,
    slidesToShow: 1,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 4000,
    arrows: false
  });

  // On slide change
  $('.residence-slider').on('beforeChange', function (e, slick, current, next) {
    updateSlideContent(next, slick);
  });

  // Background transition
  function changeBackground(path) {
    const section = $('#modern-luxury-slider');
    const oldBg = section.find('.bg-fader');

    const newBg = $('<div class="bg-fader absolute inset-0 z-0"></div>').css({
      backgroundImage: `url(${path})`,
      backgroundSize: 'cover',
      backgroundPosition: 'center',
      opacity: 0,
      zIndex: -1
    });

    section.append(newBg);

    newBg.animate({ opacity: 1 }, 800, () => oldBg.remove());
  }

  // Nav buttons
  $('.slider-prev').on('click', () => $('.residence-slider').slick('slickPrev'));
  $('.slider-next').on('click', () => $('.residence-slider').slick('slickNext'));

});
</script>



   
  <script>
    $(document).ready(function () {
      // Initialize Slick Slider
      $('.ownership-slider').slick({
        dots: true,
        infinite: true,
        speed: 500,
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 3000,
        arrows: false, // Disable default arrows
        centerMode: false,
        responsive: [
          {
            breakpoint: 1024,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 1,
            }
          },
          {
            breakpoint: 768,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 1,
            }
          }
        ]
      });

      // Function to bind navigation buttons
      function bindOwnershipNavigation() {
        // Unbind existing handlers
        $(document).off('click', '.ownership-slider-prev');
        $(document).off('click', '.ownership-slider-next');
        $(document).off('mousedown touchstart', '.ownership-slider-prev');
        $(document).off('mousedown touchstart', '.ownership-slider-next');

        // Bind click events
        $(document).on('click', '.ownership-slider-prev', function (e) {
          e.preventDefault();
          e.stopPropagation();

          const slider = $('.ownership-slider');
          if (slider.length && slider.hasClass('slick-initialized')) {
            slider.slick('slickPrev');
          }
        });

        $(document).on('click', '.ownership-slider-next', function (e) {
          e.preventDefault();
          e.stopPropagation();


          const slider = $('.ownership-slider');
          if (slider.length && slider.hasClass('slick-initialized')) {
            slider.slick('slickNext');
          }
        });

        // Fallback with mousedown
        $(document).on('mousedown touchstart', '.ownership-slider-prev', function (e) {
          e.preventDefault();
          e.stopPropagation();
          $('.ownership-slider').slick('slickPrev');
        });

        $(document).on('mousedown touchstart', '.ownership-slider-next', function (e) {
          e.preventDefault();
          e.stopPropagation();
          $('.ownership-slider').slick('slickNext');
        });
      }

      // Initial bind
      bindOwnershipNavigation();

      // Re-bind on window resize
      let resizeTimer;
      $(window).on('resize', function () {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function () {
          bindOwnershipNavigation();
        }, 250);
      });
    });
  </script>
  <script>
    $(document).ready(function () {
      const totalSlides = 3;

      $('.benefits-slider').slick({
        dots: true,
        infinite: true,
        speed: 600,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 4000,
        arrows: false,
        fade: true,
        cssEase: 'linear'
      });

      // Update benefit content and progress bar on slide change
      $('.benefits-slider').on('afterChange', function (event, slick, currentSlide) {
        // Hide all benefit contents
        $('.benefit-content').removeClass('active');

        // Show current benefit content
        $(`.benefit-content[data-benefit="${currentSlide}"]`).addClass('active');

        // Update progress bar
        const progressPercent = ((currentSlide + 1) / totalSlides) * 100;
        $('#progressBar').css('width', progressPercent + '%');
      });
    });
  </script>
  <script>
    // Get all thumbnails and main image
    const thumbnails = document.querySelectorAll('.thumbnail');
    const mainImage = document.getElementById('mainImage');

    // Add click event to each thumbnail
    thumbnails.forEach(thumbnail => {
      thumbnail.addEventListener('click', function () {
        // Get the image URL from data attribute
        const newImageSrc = this.getAttribute('data-image');

        // Don't do anything if clicking the same image
        if (mainImage.src === newImageSrc) return;

        // Add fade-out and scale effect
        mainImage.classList.remove('fade-in');
        mainImage.classList.add('fade-out');

        // Change image after animation
        setTimeout(() => {
          mainImage.src = newImageSrc;
          mainImage.classList.remove('fade-out');
          mainImage.classList.add('fade-in');
        }, 600);

        // Remove active class from all thumbnails
        thumbnails.forEach(thumb => {
          thumb.classList.remove('active');
          thumb.classList.remove('border-blue-500');
          thumb.classList.add('border-gray-200');
        });

        // Add active class to clicked thumbnail
        this.classList.add('active');
        this.classList.remove('border-gray-200');
        this.classList.add('border-blue-500');
      });
    });
     $(document).ready(function () {
      // Content data for each slide
        AOS.init(); });
  </script>

</body>

</html>
