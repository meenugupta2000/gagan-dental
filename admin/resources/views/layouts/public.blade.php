<!doctype html>
<html class="no-js" lang="en">

<head>

   <meta charset="utf-8">
   <meta http-equiv="x-ua-compatible" content="ie=edge">
   <meta name="csrf-token" content="{{ csrf_token() }}">
   {{-- Meta name is read by the bundled theme JS (assets/js/scripts.js) — do not rename. --}}
   <meta name="ltc-widgets-url" content="{{ route('api.widgets') }}">

   {{-- Resolve the theme's relative asset/link paths against the site root, so pages at any URL (e.g. /treatments) load correctly. --}}
   <base href="{{ rtrim(url('/'), '/') }}/">
   <title>@yield('title', ($company->company_name ?? 'Gagan Dental & Aesthetics Clinic') . ' – ' . ($company->tagline ?: 'Dental & Aesthetics Clinic'))</title>
   <meta name="description" content="@yield('meta_description', $company->tagline ?? '')">
   <meta name="viewport" content="width=device-width, initial-scale=1">

   <!-- Favicon (from Company Info when set) -->
   @if (($company ?? null) && $company->favicon_path)
   <link rel="shortcut icon" type="image/x-icon" href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($company->favicon_path) }}">
   @endif

   <!-- CSS here -->
   <link rel="stylesheet" href="assets/css/bootstrap.css">
   <link rel="stylesheet" href="assets/css/swiper-bundle.css">
   <link rel="stylesheet" href="assets/css/magnific-popup.css">
   <link rel="stylesheet" href="assets/css/datepicker.css">
   <link rel="stylesheet" href="assets/css/font-awesome-pro.css">
   <link rel="stylesheet" href="assets/css/main.css">

</head>

 

<body>

      <!-- Loader Start -->
   <div class="togo-loader gdc-loader">
      <div class="gdc-loader-box">
         <div class="gdc-loader-badge">
            <span class="gdc-loader-ring"></span>
            <img class="gdc-loader-logo" src="{{ asset('assets/img/loader-logo.png') }}" alt="{{ $company->company_name ?? 'Gagan Dental & Aesthetics Clinic' }}">
         </div>
         <div class="gdc-loader-name">{{ $company->company_name ?? 'Gagan Dental & Aesthetics Clinic' }}</div>
         <div class="gdc-loader-dots"><span></span><span></span><span></span></div>
      </div>
   </div>
   <!-- Loader End -->
   

   <!-- back btn start -->
   <div class="togo-back-wrapper">
      <button id="back-btn-top" type="button" class="togo-back-btn">
         <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M11 6L6 1L1 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
            stroke-linejoin="round" />
         </svg>
      </button>
   </div>
   <!-- back btn end -->


   <!-- cart-area-start -->
   <div class="cart-area">
      <div class="cart-wrapper">
         <div class="cart-top">
            <div class="cart-title-wrap">
               <h4 class="cart-title">Your Cart </h4>
            </div> 
            <div class="cart-close">
               <button class="offcanvas-close-btn">
                  <svg width="37" height="38" viewBox="0 0 37 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M9.19141 9.80762L27.5762 28.1924" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                     <path d="M9.19141 28.1924L27.5762 9.80761" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                  </svg>
               </button>
            </div>
         </div>
         <div class="cart-empty-content">
            <span class="cart-empty-icon">
               <svg width="70" height="78" fill="none"> <path fill="#888" fill-rule="evenodd" d="m2.357 32.177.732 3.764a1.13 1.13 0 1 1-2.216.433L.14 32.609c-.891-4.581 2.577-8.87 7.23-8.87H62.63c4.597 0 8.053 4.194 7.254 8.738l-6.933 39.386C62.329 75.406 59.278 78 55.698 78H15.73c-3.438 0-6.41-2.398-7.179-5.767l-1.08-4.735a1.129 1.129 0 1 1 2.201-.504l1.08 4.735c.538 2.355 2.607 4.01 4.978 4.01h39.968c2.468 0 4.594-1.79 5.03-4.268l6.933-39.386C68.22 28.899 65.798 26 62.63 26H7.37c-3.206 0-5.638 2.965-5.013 6.177Z" clip-rule="evenodd"></path> <path fill="#888" d="M32.633 2.802a1.805 1.805 0 0 0-.489-2.496 1.786 1.786 0 0 0-2.485.49L11.027 28.684a1.805 1.805 0 0 0 .489 2.497A1.786 1.786 0 0 0 14 30.689L32.633 2.802ZM56.038 30.501a1.786 1.786 0 0 0 2.447-.657c.495-.86.203-1.96-.654-2.458L35.096 14.172a1.786 1.786 0 0 0-2.447.656c-.495.86-.203 1.96.654 2.459L56.038 30.5Z"></path> <path fill="#888" fill-rule="evenodd" d="M35.012 53.02c-.298.07-.663.362-.897.674-.514.683-1.412.76-2.008.17-.595-.588-.662-1.62-.148-2.303.477-.635 1.358-1.48 2.488-1.742a2.917 2.917 0 0 1 1.943.207c.67.319 1.247.882 1.727 1.643.46.731.319 1.752-.318 2.281-.637.53-1.527.366-1.988-.365-.237-.375-.42-.498-.51-.54a.412.412 0 0 0-.29-.025Z" clip-rule="evenodd"></path> <path fill="#888" d="M25.402 47.478a1.695 1.695 0 1 0-.002-3.389 1.695 1.695 0 0 0 .003 3.39ZM44.596 47.478c.936 0 1.693-.759 1.693-1.695a1.694 1.694 0 1 0-3.387 0c0 .936.758 1.695 1.694 1.695Z"></path></svg>
            </span>
            <h4 class="cart-empty-title">Your cart is currently empty!</h4>
            <div class="cart-empty-text">
               <p>You may browse our treatments and book an appointment that suits you.</p>
            </div>
            <div class="cart-empty-btn">
               <a class="togo-btn-primary" href="{{ route('treatments') }}">Browse Treatments</a>
            </div>
         </div>
      </div>
   </div>
   <!-- cart-area-end -->


   <!-- offcanvus-area-start -->
   <div class="offcanvas-area ">
      <div class="offcanvas-wrapper">
         <div class="offcanvas-top d-flex align-items-center justify-content-between">
            <div class="offcanvas-logo">
               <a href="{{ route('home') }}">
                  @if (($company ?? null) && $company->logo_path)
                     <img width="120" src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($company->logo_path) }}" alt="{{ $company->company_name ?? 'Gagan Dental & Aesthetics Clinic' }}">
                  @else
                     <span class="offcanvas-logo-text">{{ $company->company_name ?? 'Gagan Dental & Aesthetics Clinic' }}</span>
                  @endif
               </a>
            </div>
            <div class="offcanvas-close">
               <button class="offcanvas-close-btn">
                  <svg width="37" height="38" viewBox="0 0 37 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M9.19141 9.80762L27.5762 28.1924" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                     <path d="M9.19141 28.1924L27.5762 9.80761" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                  </svg>
               </button>
            </div>
         </div>
         <div class="offcanvas-content">
            <div class="togo-mobilemenu-content fix mb-30"></div>
         </div>
      </div>
   </div>
   <div class="body-overlay"></div>
   <!-- offcanvus-area-end -->

   <header>
      @include('partials.header')
   </header>

   <div id="has-smooth">
      <div id="has-smooth-wrap">
         <main>

            @yield('content')

         </main>

         <footer>
            @include('partials.footer')
         </footer>
      </div>
   </div>

   <!-- JS here -->
   <script src="assets/js/vendor/jquery.js"></script>
   <script src="assets/js/bootstrap-bundle.js"></script>
   <script src="assets/js/swiper-bundle.js"></script>
   <script src="assets/js/magnific-popup.js"></script>
   <script src="assets/js/nice-select.js"></script>
   <script src="assets/js/purecounter.js"></script>
   <script src="assets/js/fecha.js"></script>
   <script src="assets/js/hotel-datepicker.js"></script>
   <script src="assets/js/incluid-bundle.js"></script>
   <script src="assets/js/scripts.js"></script>
   <script>
      // The theme uses href="#" as placeholder links; with <base href> set, those
      // would navigate to the home page — neutralise them so they stay put.
      document.addEventListener('click', function (e) {
         var a = e.target.closest && e.target.closest('a[href="#"]');
         if (a) e.preventDefault();
      });
   </script>

   <style>
      /* True "fixed image" parallax for .gd-parallax sections. The image lives on a
         viewport-sized layer that is re-pinned to the viewport every frame, while the
         section (overflow: hidden) scrolls over it like a window. This works inside
         the theme's GSAP ScrollSmoother transform — where background-attachment:fixed
         is ignored by browsers — and on mobile. */
      .gd-parallax { position: relative; overflow: hidden; isolation: isolate; }
      .gd-parallax-media {
         position: absolute; top: 0; left: 0; width: 100%; height: 100vh;
         background-size: cover; background-position: center; background-repeat: no-repeat;
         z-index: -1; will-change: transform; pointer-events: none;
      }
   </style>
   <script>
      (function () {
         var sections = [].slice.call(document.querySelectorAll('.gd-parallax'));
         if (!sections.length) return;

         var items = [];

         sections.forEach(function (sec) {
            // Resolve the image: data-background (theme convention) or inline style (page-hero).
            var url = sec.getAttribute('data-background');
            var bg = url ? 'url("' + url + '")' : (sec.style.backgroundImage || window.getComputedStyle(sec).backgroundImage);
            if (!bg || bg === 'none') return;

            var media = document.createElement('div');
            media.className = 'gd-parallax-media';
            media.style.backgroundImage = bg;
            sec.insertBefore(media, sec.firstChild);

            // The media layer now paints the image — blank the section's own background
            // and drop data-background so the theme JS doesn't re-apply it at ready.
            sec.style.backgroundImage = 'none';
            sec.removeAttribute('data-background');
            items.push({ sec: sec, media: media, y: null, h: null });
         });
         if (!items.length) return;

         function update() {
            var vh = window.innerHeight;
            for (var i = 0; i < items.length; i++) {
               var it = items[i];
               var rect = it.sec.getBoundingClientRect();
               if (rect.bottom <= 0 || rect.top >= vh) continue;   // off-screen: skip
               if (it.h !== vh) { it.h = vh; it.media.style.height = vh + 'px'; }
               // Counter-translate so the layer always hugs the viewport → image appears fixed.
               var y = (-rect.top).toFixed(1);
               if (it.y !== y) { it.y = y; it.media.style.transform = 'translate3d(0,' + y + 'px,0)'; }
            }
         }

         if (window.gsap && window.gsap.ticker) {
            window.gsap.ticker.add(update);        // in sync with the theme's ScrollSmoother
         } else {
            (function loop() { update(); window.requestAnimationFrame(loop); })();
         }
         update();
      })();
   </script>
   @stack('scripts')
</body>
</html>
