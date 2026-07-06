      <!-- header area start -->
      <div class="togo-header-4-ptb togo-hdr-transparent ltc-header-stuck">
         <div class="container-fluid p-0">
            <div class="togo-header-wrapper">
               <div class="row align-items-center">
                  <div class="col-xl-3 col-lg-6 col-6">
                     <div class="togo-header-logo">
                        <a href="{{ route('home') }}">
                           @if ($company->logo_path)
                              <img width="120" src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($company->logo_path) }}" alt="{{ $company->company_name }}">
                           @else
                              <span class="togo-header-logo-text">{{ $company->company_name ?? 'Gagan Dental & Aesthetics Clinic' }}</span>
                           @endif
                        </a>
                     </div>
                  </div>
                  <div class="col-xl-6 d-none d-xl-block">
                     <div class="togo-header-style-2 text-center">
                        <div class="togo-header-menu togo-header-submenu">
                           <nav class="togo-mobile-menu">
                              <ul>
                                 <li><a href="{{ route('home') }}">Home</a></li>
                                 <li><a href="{{ route('about') }}">About</a></li>
                                 <li><a href="{{ route('achievements') }}">Achievements</a></li>
                                 @include('partials.treatments-menu')
                                 <li><a href="{{ route('testimonials') }}">Testimonials</a></li>
                                 <li><a href="{{ route('offers') }}">Offers</a></li>
                                 <li><a href="{{ route('blog') }}">Blog</a></li>
                                 <li><a href="{{ route('faqs') }}">FAQs</a></li>
                                 <li><a href="{{ route('contact') }}">Contact</a></li>
                              </ul>
                           </nav>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-3 col-lg-6 col-6">
                     <div class="togo-header-2-right d-flex align-items-center justify-content-end">
                        <div class="togo-header-btn-box ml-20 d-none d-md-block">
                           <a href="{{ route('appointment') }}" class="togo-btn-primary">
                              <span>
                                 <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none">
                                 <path d="M8 2v4M16 2v4M3 9h18M5 4h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                 </svg>
                              </span>
                              Book Appointment
                           </a>
                        </div>
                        <div class="togo-header-2-bar ml-20">
                           <button class="togo-offcanvas-2-open-btn offcanvas-open-btn">
                              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M4.5 6.5H19.5" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M4.5 12H19.5" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M4.5 17.5H19.5" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                              </svg>
                           </button>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- header area end -->
