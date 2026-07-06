@extends('layouts.public')

@section('content')
            <!-- hero area start -->
            <div class="togo-hero-5-ptb bg-pos togo-hero-5-bg gd-parallax p-relative fix pt-200 pb-10" data-background="{{ $hero->image_url ?? 'assets/img/hero/home-5/bg-hero.jpg' }}">
               <div class="container container-1440 h-100">
                  <div class="row h-100">
                     <div class="col-lg-12">
                        <div class="togo-hero-5-wrapper h-100">
                           <div class="togo-hero-5-heading z-index-1 mb-50">
                              <h4 class="togo-hero-5-title fade-anim" data-delay=".3">
                                 {!! nl2br(e($hero->punchline)) !!}
                              </h4>
                              <div class="togo-hero-5-text fade-anim" data-delay=".5">
                                 <p class="mb-20">{{ $hero->description }}</p>
                              </div>
                              <div class="togo-hero-5-btn fade-anim" data-delay=".7">
                                 <a class="togo-btn-primary" href="{{ route('appointment') }}">Book an Appointment</a>
                              </div>
                           </div>
                           <div class="togo-hero-5-bottom-wrap z-index-1">
                              <div class="row">
                                 <div class="col-lg-4 col-md-6">
                                    <div class="togo-hero-5-item mb-30">
                                       <div class="togo-hero-5-item-icon">
                                          <span>
                                             <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none">
                                                <path d="M12 2L4 5v6c0 5 3.4 9.4 8 11 4.6-1.6 8-6 8-11V5l-8-3Z" stroke="white" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M8.5 12l2.4 2.4L15.5 9.6" stroke="white" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                                             </svg>
                                          </span>
                                       </div>
                                       <div class="togo-hero-5-item-content">
                                          <h4 class="togo-hero-5-item-title">Trusted Care</h4>
                                          <p>Experienced dental and aesthetics team <br> with gentle, patient-first treatment.</p>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-lg-4 col-md-6">
                                    <div class="togo-hero-5-item mb-30">
                                       <div class="togo-hero-5-item-icon">
                                          <span>
                                             <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none">
                                                <path d="M12 3l1.7 4.3L18 9l-4.3 1.7L12 15l-1.7-4.3L6 9l4.3-1.7L12 3Z" stroke="white" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M18.5 14.5l.9 2.1 2.1.9-2.1.9-.9 2.1-.9-2.1-2.1-.9 2.1-.9.9-2.1Z" stroke="white" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                                             </svg>
                                          </span>
                                       </div>
                                       <div class="togo-hero-5-item-content">
                                          <h4 class="togo-hero-5-item-title">Modern Technology</h4>
                                          <p>Advanced equipment and techniques <br> for precise, comfortable results.</p>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-lg-4 col-md-6">
                                    <div class="togo-hero-5-item mb-30">
                                       <div class="togo-hero-5-item-icon">
                                          <span>
                                             <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none">
                                                <path d="M8 2v4M16 2v4M3 9h18M5 4h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2Z" stroke="white" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M9 15l2 2 4-4" stroke="white" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                                             </svg>
                                          </span>
                                       </div>
                                       <div class="togo-hero-5-item-content">
                                          <h4 class="togo-hero-5-item-title">Easy Appointments</h4>
                                          <p>Book online in under a minute and <br> we will confirm your visit promptly.</p>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <!-- hero area end -->

            <!-- about area start -->
             <div class="togo-about-5-ptb pt-100 pb-60">
               <div class="container container-1440">
                  <div class="row">
                     <div class="col-lg-12">
                        <div class="togo-about-5-heading text-center mb-40">
                           @if ($about->subtitle)<span class="togo-section-subtitle fade-anim" data-delay=".3">{{ $about->subtitle }}</span>@endif
                           <h4 class="togo-section-title fs-36 ff-marcellus mb-20 fade-anim" data-delay=".5">{!! nl2br(e($about->title)) !!}</h4>
                           @if ($about->description)
                           <div class="togo-about-5-text fade-anim" data-delay=".7">
                              <p>{{ $about->description }}</p>
                           </div>
                           @endif
                           <div class="mt-30 fade-anim" data-delay=".8">
                              <a class="togo-btn-primary bdr-style orange-bdr" href="{{ route('treatments') }}">Explore our treatments</a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
             </div>
            <!-- about area end -->


            <!-- treatment categories area start -->
            @if ($categories->isNotEmpty())
            <style>
               .gd-cat-card {
                  position: relative; display: block; border-radius: 18px; overflow: hidden;
                  aspect-ratio: 3 / 4; box-shadow: 0 10px 26px rgba(13,27,42,.10);
                  transition: transform .45s cubic-bezier(.2,.8,.2,1), box-shadow .45s ease;
               }
               .gd-cat-card img { width: 100%; height: 100%; object-fit: cover; transition: transform .7s cubic-bezier(.2,.8,.2,1); }
               .gd-cat-card:hover { transform: translateY(-8px); box-shadow: 0 26px 50px rgba(46, 125, 50,.25); }
               .gd-cat-card:hover img { transform: scale(1.1); }
               .gd-cat-shade { position: absolute; inset: 0; background: linear-gradient(180deg, rgba(13,27,42,0) 38%, rgba(13,27,42,.25) 58%, rgba(13,27,42,.85) 100%); }
               .gd-cat-name {
                  position: absolute; left: 16px; right: 16px; bottom: 16px; z-index: 2;
                  color: #fff; font-family: var(--togo-ff-marcellus); font-weight: 600; font-size: 1.18rem; line-height: 1.25;
                  text-shadow: 0 2px 10px rgba(0,0,0,.55); letter-spacing: .2px;
               }
            </style>
            <div class="togo-trand-ptb pt-60 pb-60">
               <div class="container container-1440">
                  <div class="row">
                     <div class="col-lg-12">
                        <div class="togo-trand-heading text-center mb-40">
                           <h4 class="togo-section-title ff-marcellus mb-1 fade-anim" data-delay=".3">Our Treatments</h4>
                           <div class="togo-trand-text fade-anim" data-delay=".5">
                              <p>Choose the care your smile needs</p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     @foreach ($categories as $cat)
                     <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-30">
                        <a href="{{ route('treatments', ['category' => $cat->slug]) }}" class="gd-cat-card">
                           <img src="{{ $cat->image_url ?? asset('assets/img/placeholder-category.svg') }}" alt="{{ $cat->name }}">
                           <span class="gd-cat-shade"></span>
                           <span class="gd-cat-name">{{ $cat->name }}</span>
                        </a>
                     </div>
                     @endforeach
                  </div>
               </div>
            </div>
            @endif
            <!-- treatment categories area end -->


            <!-- why choose us area start -->
            @if ($features->isNotEmpty())
            <style>
               /* Feature cards — matched 1:1 to the About page "Why Choose Us" look */
               .ab-features { padding: 80px 0 90px; background: #fff; }
               .ab-sec-head { text-align: center; max-width: 640px; margin: 0 auto 46px; }
               .ab-sec-head .eyebrow { color: #2e7d32; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; font-size: .8rem; }
               .ab-sec-head h2 { font-size: clamp(1.6rem, 3.4vw, 2.2rem); font-weight: 800; color: #14233a; margin: 8px 0 0; }
               .ab-feat-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 26px; }
               .ab-feat { background: #f6f8fb; border: 1px solid #eceff5; border-radius: 18px; padding: 30px 26px; text-align: center; transition: transform .4s ease, box-shadow .4s ease; }
               .ab-feat:hover { transform: translateY(-6px); box-shadow: 0 20px 40px rgba(46,125,50,.14); }
               .ab-feat-ic { width: 62px; height: 62px; margin: 0 auto 16px; border-radius: 16px; background: #e7f4ea; color: #2e7d32; display: grid; place-items: center; }
               .ab-feat-ic img { width: 34px; height: 34px; object-fit: contain; }
               .ab-feat-ic svg { width: 30px; height: 30px; }
               .ab-feat h3 { font-size: 1.08rem; font-weight: 800; color: #14233a; margin: 0 0 8px; }
               .ab-feat p { color: #5d6a82; font-size: .94rem; line-height: 1.65; margin: 0; }
            </style>
            <section class="ab-features">
               <div class="container container-1440">
                  <div class="ab-sec-head">
                     <span class="eyebrow">Why Choose Us</span>
                     <h2>Care that puts you first</h2>
                  </div>
                  <div class="ab-feat-grid">
                     @foreach ($features as $feature)
                        <div class="ab-feat">
                           <div class="ab-feat-ic">
                              @if ($feature->icon_url)
                                 <img src="{{ $feature->icon_url }}" alt="{{ $feature->title }}">
                              @else
                                 <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="m5 13 4 4L19 7" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                              @endif
                           </div>
                           <h3>{{ $feature->title }}</h3>
                           @if ($feature->description)
                              <p>{{ $feature->description }}</p>
                           @endif
                        </div>
                     @endforeach
                  </div>
               </div>
            </section>
            @endif
            <!-- why choose us area end -->




            <!-- offers area start -->
            @if ($offers->isNotEmpty())
            <style>
               .gd-offer-card {
                  display: flex; flex-direction: column; height: 100%;
                  background: #fff; border: 1px solid #eceff5; border-radius: 18px; overflow: hidden;
                  box-shadow: 0 8px 26px rgba(13,27,42,.07);
                  transition: transform .4s cubic-bezier(.2,.8,.2,1), box-shadow .4s ease;
               }
               .gd-offer-card:hover { transform: translateY(-8px); box-shadow: 0 22px 45px rgba(13,27,42,.13); }
               .gd-offer-thumb { position: relative; height: 190px; overflow: hidden; background: #e9eef5; }
               .gd-offer-thumb img { width: 100%; height: 100%; object-fit: cover; transition: transform .6s cubic-bezier(.2,.8,.2,1); }
               .gd-offer-card:hover .gd-offer-thumb img { transform: scale(1.08); }
               .gd-offer-tag {
                  position: absolute; top: 14px; left: 14px; z-index: 1;
                  background: #2e7d32; color: #fff; font-size: .72rem; font-weight: 700; letter-spacing: .06em;
                  text-transform: uppercase; padding: 5px 12px; border-radius: 50px;
               }
               .gd-offer-body { padding: 20px 20px 24px; display: flex; flex-direction: column; flex: 1; }
               .gd-offer-title { font-family: var(--togo-ff-marcellus); font-size: 1.2rem; font-weight: 600; color: #14233a; margin: 0 0 8px; }
               .gd-offer-desc { color: #647089; font-size: .93rem; line-height: 1.6; margin: 0 0 16px; flex: 1; }
               .gd-offer-btn {
                  align-self: flex-start; display: inline-flex; align-items: center; gap: 8px;
                  background: linear-gradient(135deg,#2e7d32,#43a047); color: #fff;
                  border-radius: 50px; padding: 11px 24px; font-weight: 700; font-size: .92rem; text-decoration: none;
                  box-shadow: 0 10px 22px rgba(46, 125, 50,.28); transition: transform .25s, box-shadow .25s;
               }
               .gd-offer-btn:hover { color: #fff; transform: translateY(-2px); box-shadow: 0 16px 30px rgba(46, 125, 50,.4); }
            </style>
             <div class="togo-tour-5-ptb pt-60 pb-60" data-bg-color="#FEFAF8">
               <div class="container container-1440">
                  <div class="row">
                     <div class="col-lg-12">
                         <div class="togo-tour-5-heading text-center mb-40">
                           <h4 class="togo-section-title ff-marcellus mb-1 fade-anim" data-delay=".3">Special Offers</h4>
                           <div class="togo-tour-5-text fade-anim" data-delay=".5">
                              <p>Smile-friendly savings on selected treatments.</p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row justify-content-center">
                     @foreach ($offers->take(3) as $offer)
                     <div class="col-lg-4 col-md-6 mb-30">
                        <div class="gd-offer-card">
                           <div class="gd-offer-thumb">
                              <span class="gd-offer-tag">Offer</span>
                              <img src="{{ $offer->image_url ?? asset('assets/img/placeholder-category.svg') }}" alt="{{ $offer->title }}" loading="lazy">
                           </div>
                           <div class="gd-offer-body">
                              <h4 class="gd-offer-title">{{ $offer->title }}</h4>
                              <p class="gd-offer-desc">{{ \Illuminate\Support\Str::limit($offer->description, 120) }}</p>
                              <a class="gd-offer-btn" href="{{ route('appointment') }}">Book Now</a>
                           </div>
                        </div>
                     </div>
                     @endforeach
                  </div>
                  <div class="row">
                     <div class="col-lg-12">
                        <div class="text-center mt-10 fade-anim" data-delay=".3">
                           <a class="togo-btn-primary bdr-style orange-bdr" href="{{ route('offers') }}">View all offers</a>
                        </div>
                     </div>
                  </div>
               </div>
             </div>
            @endif
            <!-- offers area end -->


            <!-- appointment CTA banner start -->
             <div class="togo-banner-5-ptb togo-banner-5-bg bg-pos gd-parallax p-relative pt-200 pb-200" data-background="{{ ($company ?? null) && $company->cta_image_path ? \Illuminate\Support\Facades\Storage::disk('public')->url($company->cta_image_path) : asset('assets/img/banner/home-5/banner-thumb.jpg') }}">
               <div class="container container-1440">
                  <div class="row">
                     <div class="col-xl-6 co-lg-8">
                        <div class="togo-banner-5-heading z-index-1">
                           <span class="togo-section-subtitle color-white mb-20 fade-anim" data-delay=".3">Your smile deserves the best</span>
                           <h4 class="togo-section-title fs-64 ff-marcellus color-white mb-25 fade-anim" data-delay=".5">Ready for a healthier, <br>
                           more confident <br>
                           smile?</h4>
                           <div class="fade-anim" data-delay=".7">
                              <a class="togo-btn-primary" href="{{ route('appointment') }}">Book an Appointment</a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
             </div>
            <!-- appointment CTA banner end -->


            <!-- testimonial area start -->
            @if ($testimonials->isNotEmpty())
             <div class="togo-testimonial-5-ptb pt-60 pb-60" data-bg-color="#FEFAF8">
               <div class="container container-1440">
                  <div class="row">
                     <div class="col-lg-6">
                        <div class="togo-testimonial-5-heading">
                           <h3 class="togo-section-title ff-marcellus fade-anim" data-delay=".3"><span class="d-inline-block mr-20">
                              <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 56 56" fill="none">
                                 <path d="M28 56C43.4385 56 56 43.4385 56 28C56 12.5615 43.4385 0 28 0C12.5615 0 0 12.5615 0 28C0 43.4385 12.5615 56 28 56ZM28 1.75C42.4743 1.75 54.25 13.5258 54.25 28C54.25 42.4743 42.4743 54.25 28 54.25C13.5258 54.25 1.75 42.4743 1.75 28C1.75 13.5258 13.5258 1.75 28 1.75Z" fill="#2e7d32"/>
                                 <path d="M18.7849 23.8831C19.6722 24.1718 20.5944 24.0388 21.4642 23.4946C21.8719 23.2391 21.9979 22.6983 21.7407 22.2888C21.4852 21.8811 20.9462 21.7551 20.5349 22.0123C20.1132 22.2748 19.7072 22.3413 19.3309 22.2206C18.9302 22.0893 18.5522 21.7516 18.2354 21.2441C17.9519 20.7926 17.8609 20.2571 17.9799 19.7373C18.1007 19.2158 18.4157 18.7748 18.8689 18.4913C19.9504 17.8088 21.3574 18.1991 22.2692 18.8833C23.8109 20.0366 24.5004 22.0421 24.5004 25.3776C24.5004 30.3021 22.2604 36.4253 17.9782 38.5971C17.5477 38.8158 17.3744 39.3426 17.5932 39.7748C17.7507 40.0776 18.0569 40.2526 18.3754 40.2526C18.5084 40.2526 18.6432 40.2211 18.7727 40.1581C23.9089 37.5523 26.2504 30.6678 26.2504 25.3776C26.2504 21.4891 25.3194 18.9813 23.3192 17.4816C21.6532 16.2268 19.4902 16.0396 17.9414 17.0073C17.0927 17.5376 16.5012 18.3671 16.2772 19.3436C16.0514 20.3201 16.2212 21.3246 16.7514 22.1716C17.2887 23.0291 17.9904 23.6206 18.7849 23.8831Z" fill="#2e7d32"/>
                                 <path d="M32.7849 23.8831C33.6704 24.1718 34.5944 24.0388 35.4642 23.4946C35.8719 23.2391 35.9979 22.6983 35.7407 22.2888C35.4852 21.8811 34.9462 21.7551 34.5349 22.0123C34.1149 22.2748 33.7072 22.3413 33.3309 22.2206C32.9302 22.0893 32.5522 21.7516 32.2354 21.2441C31.9519 20.7926 31.8609 20.2571 31.9799 19.7373C32.1007 19.2158 32.4157 18.7748 32.8689 18.4913C33.9522 17.8088 35.3592 18.1991 36.2692 18.8833C37.8109 20.0366 38.5004 22.0421 38.5004 25.3776C38.5004 30.3021 36.2604 36.4253 31.9782 38.5971C31.5477 38.8158 31.3744 39.3426 31.5932 39.7748C31.7507 40.0776 32.0569 40.2526 32.3754 40.2526C32.5084 40.2526 32.6432 40.2211 32.7727 40.1581C37.9089 37.5523 40.2504 30.6678 40.2504 25.3776C40.2504 21.4891 39.3194 18.9813 37.3192 17.4816C35.6532 16.2268 33.4902 16.0396 31.9414 17.0073C31.0927 17.5376 30.5012 18.3671 30.2772 19.3436C30.0514 20.3201 30.2212 21.3246 30.7514 22.1716C31.2887 23.0291 31.9904 23.6206 32.7849 23.8831Z" fill="#2e7d32"/>
                              </svg>
                           </span>What our patients say </h3>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="togo-destination-arrows d-flex align-items-center justify-content-lg-end togo-blog-4-slider-arrow mb-30">
                           <button class="togo-testimonial-prev">
                              <span>
                                 <svg xmlns="http://www.w3.org/2000/svg" width="7" height="13" viewBox="0 0 7 13" fill="none">
                                 <path d="M6.25 0.75L0.75 6.25L6.25 11.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                 </svg>
                              </span>
                           </button>
                           <button class="togo-testimonial-next">
                              <span>
                                 <svg xmlns="http://www.w3.org/2000/svg" width="7" height="13" viewBox="0 0 7 13" fill="none">
                                 <path d="M0.75 11.75L6.25 6.25L0.75 0.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                 </svg>
                              </span>
                           </button>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-lg-12">
                        <div class="togo-testimonial-5-slider-wrapper">
                           <div class="togo-testimonial-5-active swiper">
                              <div class="swiper-wrapper">
                                 @foreach ($testimonials as $t)
                                 <div class="swiper-slide">
                                    <div class="togo-testimonial-2-item tes-style-5">
                                       <div class="togo-testimonial-2-item-rating mb-12">
                                          @for ($i = 0; $i < (int) $t->rating; $i++)
                                          <span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M7.32327 1.08378C7.07807 0.638741 6.42974 0.638741 6.18454 1.08378C6.05096 1.32621 5.92281 1.5719 5.80023 1.82068C5.41424 2.6041 5.08355 3.41822 4.8131 4.25825C4.72059 4.5456 4.4457 4.74517 4.13108 4.75352C3.38864 4.77323 2.64755 4.83432 1.91266 4.93804C1.70278 4.96766 1.49401 5.00063 1.28642 5.0369C0.770247 5.12708 0.576561 5.7156 0.943106 6.07427C1.02672 6.15608 1.11104 6.23721 1.19606 6.31765C1.83183 6.91916 2.50669 7.48188 3.2166 8.0019C3.46144 8.18126 3.5621 8.48895 3.46852 8.7698C3.17533 9.6497 2.94843 10.5586 2.79353 11.4911C2.76246 11.678 2.7343 11.866 2.70907 12.0548C2.64186 12.5579 3.1809 12.9132 3.64877 12.6734C3.81578 12.5878 3.98131 12.4998 4.14532 12.4095C4.89781 11.9953 5.61824 11.5324 6.30207 11.0252C6.56749 10.8283 6.94033 10.8283 7.20574 11.0252C7.88958 11.5324 8.61 11.9953 9.36249 12.4095C9.5265 12.4998 9.69203 12.5878 9.85904 12.6734C10.3269 12.9132 10.866 12.5579 10.7987 12.0548C10.7735 11.866 10.7453 11.678 10.7143 11.4911C10.5594 10.5586 10.3325 9.6497 10.0393 8.7698C9.94572 8.48895 10.0464 8.18126 10.2912 8.0019C11.0011 7.48188 11.676 6.91916 12.3118 6.31765C12.3968 6.23721 12.4811 6.15608 12.5647 6.07427C12.9313 5.7156 12.7376 5.12708 12.2214 5.0369C12.0138 5.00063 11.805 4.96766 11.5951 4.93804C10.8603 4.83432 10.1192 4.77323 9.37673 4.75352C9.06212 4.74517 8.78723 4.5456 8.69471 4.25825C8.42426 3.41822 8.09358 2.6041 7.70758 1.82068C7.585 1.5719 7.45685 1.32621 7.32327 1.08378Z" fill="#2e7d32" stroke="#2e7d32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                                          @endfor
                                       </div>
                                       @if ($t->title)<h4 class="togo-testimonial-2-item-title">{{ $t->title }}</h4>@endif
                                       <div class="togo-testimonial-2-item-content mb-28">
                                          <p>{{ $t->quote }}</p>
                                       </div>
                                       <div class="togo-testimonial-2-item-user d-flex">
                                          @if ($t->photo_url)
                                          <div class="togo-testimonial-2-item-user-thumb">
                                             <img src="{{ $t->photo_url }}" alt="{{ $t->name }}">
                                          </div>
                                          @endif
                                          <div class="togo-testimonial-2-item-user-content">
                                             <h4>{{ $t->name }}</h4>
                                             @if ($t->role)<span>{{ $t->role }}</span>@endif
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 @endforeach
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
             </div>
            @endif
            <!-- testimonial area end -->


            <!-- blog area start -->
            <style>
               .gd-blog-home-title { font-family: var(--togo-ff-marcellus); font-size: 1.4rem; line-height: 1.35; font-weight: 600; margin-bottom: 10px; }
               .gd-blog-home-title a { color: #14233a; transition: color .25s ease; }
               .gd-blog-home-title a:hover { color: #2e7d32; }
               .gd-blog-home-excerpt { color: #647089; font-size: .95rem; line-height: 1.65; margin: 0; }
               .gd-blog-home-subtitle { color: #647089; font-size: 1.05rem; line-height: 1.7; margin: 14px 0 0; max-width: 560px; }
               .gd-blog-home-btn {
                  display: inline-flex; align-items: center; gap: 9px;
                  background: linear-gradient(135deg, #2e7d32, #43a047); color: #fff;
                  border-radius: 50px; padding: 13px 28px; font-weight: 700; font-size: .98rem;
                  text-decoration: none; box-shadow: 0 12px 26px rgba(46, 125, 50,.3);
                  transition: transform .28s ease, box-shadow .28s ease;
               }
               .gd-blog-home-btn span { color: #fff; }
               .gd-blog-home-btn svg { transition: transform .28s ease; }
               .gd-blog-home-btn:hover { color: #fff; transform: translateY(-3px); box-shadow: 0 18px 34px rgba(46, 125, 50,.42); }
               .gd-blog-home-btn:hover svg { transform: translateX(5px); }
               .togo-blog-2-item-thumb img { width: 100%; height: 220px; object-fit: cover; border-radius: 14px; }
            </style>
             <div class="togo-blog-2-ptb pt-80 pb-50">
               <div class="container container-1440">
                  <div class="row align-items-center">
                     <div class="col-lg-6">
                        <div class="togo-tour-heading fade-anim" data-delay=".3">
                           <h3 class="togo-section-title ff-marcellus">Articles by our specialists</h3>
                           <p class="gd-blog-home-subtitle">Oral health tips, treatment guides and aesthetics advice from our team to help you care for your smile.</p>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="togo-tour-right text-lg-end mb-30 fade-anim" data-delay=".5">
                           <a class="gd-blog-home-btn" href="{{ route('blog') }}">
                              <span>View all posts</span>
                              <svg width="17" height="17" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                           </a>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     @forelse ($blogs as $blog)
                     <div class="col-xl-4 col-lg-4 col-sm-6">
                        <div class="togo-blog-2-item mb-30">
                           <div class="togo-blog-2-item-thumb mb-20">
                              <a href="{{ route('blog.show', $blog->slug) }}">
                                 <img src="{{ $blog->image_url ?? asset('assets/img/placeholder-category.svg') }}" alt="{{ $blog->title }}">
                              </a>
                           </div>
                           <div class="togo-blog-2-item-content">
                              <h4 class="togo-blog-2-item-title ff-marcellus gd-blog-home-title">
                                 <a href="{{ route('blog.show', $blog->slug) }}">{{ $blog->title }}</a>
                              </h4>
                              @if ($blog->excerpt)
                                 <p class="gd-blog-home-excerpt">{{ $blog->excerpt }}</p>
                              @endif
                           </div>
                        </div>
                     </div>
                     @empty
                     <div class="col-12">
                        <p class="text-muted">Articles will appear here soon.</p>
                     </div>
                     @endforelse
                  </div>
               </div>
             </div>
            <!-- blog area end -->
@endsection
