            <!-- footer area start -->
            <div class="togo-footer-ptb pt-60" data-bg-color="#0d1b2a">
               <div class="container container-1440">
                  <div class="togo-footer-main-wrapper black-style pb-10">
                     <div class="row">
                        <div class="col-lg-4 col-sm-6">
                           <div class="togo-footer-widget mb-40 togo-footer-col-1">
                              <h4 class="togo-footer-widget-title mb-25">Contact us</h4>
                              <div class="togo-footer-widget-info mb-15">
                                 @if ($company->email)
                                 <div class="togo-footer-widget-info-item">
                                    <a href="mailto:{{ $company->email }}">
                                       <span>
                                          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                                             <path d="M1.83398 10.9998C1.83398 7.54287 1.83398 5.81439 3.17641 4.74045C4.51884 3.6665 6.67944 3.6665 11.0007 3.6665C15.3219 3.6665 17.4825 3.6665 18.8249 4.74045C20.1673 5.81439 20.1673 7.54287 20.1673 10.9998C20.1673 14.4568 20.1673 16.1853 18.8249 17.2592C17.4825 18.3332 15.3219 18.3332 11.0007 18.3332C6.67944 18.3332 4.51884 18.3332 3.17641 17.2592C1.83398 16.1853 1.83398 14.4568 1.83398 10.9998Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                             <path d="M18.9434 4.86768L14.5201 8.98251C12.8365 10.3855 11.9947 11.087 10.9991 11.087C10.0034 11.087 9.16162 10.3855 7.47804 8.98251L3.05469 4.86768" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                          </svg>
                                       </span>
                                       {{ $company->email }}
                                    </a>
                                 </div>
                                 @endif
                                 @php($footerPhones = collect([
                                    ['label' => 'Reception', 'value' => $company->tickets_phone],
                                    ['label' => 'Appointments', 'value' => $company->packages_phone],
                                    ['label' => 'Emergency', 'value' => $company->visa_phone],
                                 ])->filter(fn ($d) => filled($d['value']))->values())
                                 @forelse ($footerPhones as $d)
                                 <div class="togo-footer-widget-info-item">
                                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $d['value']) }}">
                                       <span>
                                          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                                             <path d="M14.3 13.3113C12.1046 15.622 6.5045 10.0722 8.70828 7.75274C10.0538 6.33657 8.53383 4.71815 7.69249 3.52856C6.11347 1.29596 2.64707 4.37837 2.75235 6.33915C3.08433 12.5224 9.77308 19.8501 16.2502 19.2109C18.2765 19.011 20.6047 15.3516 18.2805 14.0142C17.1183 13.3454 15.523 12.0241 14.3 13.3113Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                          </svg>
                                       </span> <strong style="font-weight:600;">{{ $d['label'] }}:</strong>&nbsp;{{ $d['value'] }}</a>
                                 </div>
                                 @empty
                                 @if ($company->phone)
                                 <div class="togo-footer-widget-info-item">
                                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $company->phone) }}">
                                       <span>
                                          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                                             <path d="M14.3 13.3113C12.1046 15.622 6.5045 10.0722 8.70828 7.75274C10.0538 6.33657 8.53383 4.71815 7.69249 3.52856C6.11347 1.29596 2.64707 4.37837 2.75235 6.33915C3.08433 12.5224 9.77308 19.8501 16.2502 19.2109C18.2765 19.011 20.6047 15.3516 18.2805 14.0142C17.1183 13.3454 15.523 12.0241 14.3 13.3113Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                          </svg>
                                       </span> {{ $company->phone }}</a>
                                 </div>
                                 @endif
                                 @endforelse
                                 @if ($company->address || $company->city || $company->country)
                                 <div class="togo-footer-widget-info-item">
                                    <a href="{{ $company->map_embed ? '#' : '#' }}">
                                       <span>
                                          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                                             <path d="M11.5132 19.0857C11.206 19.3048 10.794 19.3048 10.4868 19.0857C6.06043 15.9292 1.36177 9.43901 6.11114 4.74951C7.40775 3.46924 9.16632 2.75 11 2.75C12.8337 2.75 14.5923 3.46924 15.8889 4.74951C20.6382 9.43901 15.9396 15.9292 11.5132 19.0857Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                             <path d="M10.9993 11.0002C12.0119 11.0002 12.8327 10.1794 12.8327 9.16683C12.8327 8.15431 12.0119 7.3335 10.9993 7.3335C9.98683 7.3335 9.16602 8.15431 9.16602 9.16683C9.16602 10.1794 9.98683 11.0002 10.9993 11.0002Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                          </svg>
                                       </span>
                                       {{ $company->address }}@if($company->city || $company->state || $company->country)<br>{{ collect([$company->city, $company->state, $company->country])->filter()->join(', ') }}@endif</a>
                                 </div>
                                 @endif
                              </div>
                           </div>
                        </div>
                        <div class="col-lg-2 col-sm-6">
                           <div class="togo-footer-widget mb-40 togo-footer-col-2">
                              <h4 class="togo-footer-widget-title mb-25">Quick Links</h4>
                              <div class="togo-footer-widget-menu">
                                 <ul>
                                    <li><a class="hover-line" href="{{ route('treatments') }}">Treatments</a></li>
                                    <li><a class="hover-line" href="{{ route('testimonials') }}">Testimonials</a></li>
                                    <li><a class="hover-line" href="{{ route('offers') }}">Offers</a></li>
                                    <li><a class="hover-line" href="{{ route('appointment') }}">Book Appointment</a></li>
                                 </ul>
                              </div>
                           </div>
                        </div>
                        <div class="col-lg-2 col-sm-6">
                           <div class="togo-footer-widget mb-40 togo-footer-col-3">
                              <h4 class="togo-footer-widget-title mb-25">Clinic</h4>
                              <div class="togo-footer-widget-menu">
                                 <ul>
                                    <li><a class="hover-line" href="{{ route('about') }}">About us</a></li>
                                    <li><a class="hover-line" href="{{ route('achievements') }}">Achievements</a></li>
                                    <li><a class="hover-line" href="{{ route('faqs') }}">FAQs</a></li>
                                    <li><a class="hover-line" href="{{ route('blog') }}">Blog</a></li>
                                    <li><a class="hover-line" href="{{ route('contact') }}">Contact</a></li>
                                    <li><a class="hover-line" href="{{ route('page', 'privacy-policy') }}">Privacy Policy</a></li>
                                    <li><a class="hover-line" href="{{ route('page', 'terms-conditions') }}">Terms &amp; Conditions</a></li>
                                 </ul>
                              </div>
                           </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                           <div class="togo-footer-widget mb-40 togo-footer-col-4">
                              <h4 class="togo-footer-widget-title mb-28">Stay in touch</h4>
                              <div class="togo-footer-widget-input mb-30">
                                 <p>Subscribe to our Newsletter for <br> Oral Health Tips and Special Offers</p>
                                 <form class="p-relative" id="gdNewsletterForm" data-action="{{ route('newsletter.subscribe') }}" novalidate>
                                    <x-form-shield />
                                    <input type="email" name="email" id="gdNewsletterEmail" placeholder="Enter your email" required>
                                    <button type="submit" class="togo-footer-widget-input-btn" aria-label="Subscribe">
                                       <span>
                                          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                                             <path d="M18.5969 2.77847C18.9846 2.64279 19.3572 3.01541 19.2215 3.40306L13.79 18.9217C13.6433 19.3408 13.0597 19.3646 12.8794 18.9589L9.92881 12.32C9.87952 12.2091 9.79085 12.1205 9.67995 12.0712L3.04112 9.1206C2.63543 8.94029 2.65924 8.35666 3.07827 8.21L18.5969 2.77847Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                             <path d="M12.832 9.1665L10.082 11.9165" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                          </svg>
                                       </span>
                                    </button>
                                 </form>
                                 <div id="gdNewsletterMsg" class="gd-newsletter-msg" role="status" style="display:none;"></div>
                              </div>
                              @if ($company->facebook_url || $company->instagram_url || $company->twitter_url || $company->youtube_url)
                              <div class="togo-footer-widget-social-wrap mb-30">
                                 <h4 class="togo-footer-widget-title mb-14">Follow us</h4>
                                 <div class="togo-footer-widget-social-icon">
                                    @if ($company->facebook_url)
                                    <a href="{{ $company->facebook_url }}" target="_blank" rel="noopener">
                                       <span>
                                          <svg xmlns="http://www.w3.org/2000/svg" width="13" height="20" viewBox="0 0 13 20" fill="none">
                                             <path d="M0.75 7.75V11.75H3.75V18.75H7.75V11.75H10.75L11.75 7.75H7.75V5.75C7.75 5.20533 8.20533 4.75 8.75 4.75H11.75V0.75H8.75C6.02667 0.75 3.75 3.02667 3.75 5.75V7.75H0.75Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                          </svg>
                                       </span>
                                    </a>
                                    @endif
                                    @if ($company->instagram_url)
                                    <a href="{{ $company->instagram_url }}" target="_blank" rel="noopener"><span>
                                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                             <path d="M16.5 3H7.5C5.01472 3 3 5.01472 3 7.5V16.5C3 18.9853 5.01472 21 7.5 21H16.5C18.9853 21 21 18.9853 21 16.5V7.5C21 5.01472 18.9853 3 16.5 3Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                             <path d="M15.4621 11.4866C15.5701 12.2148 15.4457 12.9585 15.1067 13.612C14.7676 14.2654 14.2311 14.7953 13.5736 15.1263C12.916 15.4573 12.1708 15.5725 11.444 15.4555C10.7171 15.3386 10.0457 14.9954 9.52513 14.4749C9.00457 13.9543 8.66141 13.2829 8.54446 12.556C8.4275 11.8292 8.5427 11.084 8.87368 10.4264C9.20466 9.76886 9.73456 9.23238 10.388 8.89332C11.0415 8.55426 11.7852 8.42988 12.5134 8.53786C13.2562 8.64801 13.9439 8.99414 14.4749 9.52513C15.0059 10.0561 15.352 10.7438 15.4621 11.4866Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                             <path d="M17 6.5H17.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                          </svg>
                                       </span></a>
                                    @endif
                                    @if ($company->twitter_url)
                                    <a href="{{ $company->twitter_url }}" target="_blank" rel="noopener"><span>
                                          <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" fill="none">
                                             <path d="M14.5 0.75L9.06391 7.10276M1.66667 15.4167L7.10276 9.06391M7.10276 9.06391L12.4146 15.1021C12.5892 15.3006 12.8577 15.4167 13.1421 15.4167H14.4934C15.2603 15.4167 15.6917 14.6368 15.2208 14.1016L9.06391 7.10276M7.10276 9.06391L0.945838 2.06506C0.475005 1.52984 0.906398 0.75 1.6733 0.75H3.02462C3.30901 0.75 3.57748 0.866089 3.75208 1.06457L9.06391 7.10276" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                          </svg>
                                       </span></a>
                                    @endif
                                    @if ($company->youtube_url)
                                    <a href="{{ $company->youtube_url }}" target="_blank" rel="noopener"><span>
                                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                             <path d="M10.5 9.90776V14.0923C10.5 14.3174 10.6847 14.5 10.9125 14.5C10.9934 14.5 11.0725 14.4765 11.1399 14.4324L14.3149 12.3582C14.505 12.234 14.5572 11.9811 14.4316 11.7932C14.4016 11.7483 14.3628 11.7097 14.3176 11.6797L11.1426 9.5694C10.9536 9.44378 10.6973 9.49339 10.5702 9.68029C10.5244 9.74755 10.5 9.82675 10.5 9.90776Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                             <path d="M2 12C2 8.70017 2 7.05025 3.46447 6.02513C4.92893 5 7.28595 5 12 5C16.714 5 19.0711 5 20.5355 6.02513C22 7.05025 22 8.70017 22 12C22 15.2998 22 16.9497 20.5355 17.9749C19.0711 19 16.714 19 12 19C7.28595 19 4.92893 19 3.46447 17.9749C2 16.9497 2 15.2998 2 12Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                          </svg>
                                       </span></a>
                                    @endif
                                 </div>
                              </div>
                              @endif
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="togo-footer-2-top-border pt-35 pb-30">
                     @php($legalIds = array_filter([
                        'Reg. No.' => $company->registration_number ?? null,
                        'License No.' => $company->license_no ?? null,
                     ]))
                     @if (! empty($legalIds))
                     <div class="gd-footer-legal">
                        @foreach ($legalIds as $label => $value)
                           <span class="gd-footer-legal-item"><span class="lbl">{{ $label }}</span> {{ $value }}</span>
                        @endforeach
                     </div>
                     @endif
                     <div class="row align-items-center">
                        <div class="col-md-6">
                           <div class="togo-footer-copyright-text">
                              <p>{{ $company->company_name ?? 'Gagan Dental & Aesthetics Clinic' }} &copy; {{ date('Y') }} all rights reserved.</p>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="togo-footer-copyright-text text-md-end">
                              <p>Powered by <a href="http://www.slashcodesoftware.com" target="_blank" rel="noopener noreferrer" style="color:#2e7d32;font-weight:600;">Slashcode Software Pvt Ltd</a></p>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <!-- footer area end -->

@push('scripts')
<style>
    .gd-newsletter-msg { margin-top: 10px; font-size: .82rem; font-weight: 600; }
    .gd-newsletter-msg.is-success { color: #34d399; }
    .gd-newsletter-msg.is-error { color: #ff8a73; }
    .gd-footer-legal {
        display: flex; flex-wrap: wrap; gap: 8px 26px; margin-bottom: 18px; padding-bottom: 18px;
        border-bottom: 1px solid rgba(255, 255, 255, .1);
    }
    .gd-footer-legal-item { color: rgba(255, 255, 255, .6); font-size: .82rem; letter-spacing: .01em; }
    .gd-footer-legal-item .lbl { color: rgba(255, 255, 255, .85); font-weight: 700; text-transform: uppercase; font-size: .72rem; letter-spacing: .05em; }

    /* --- Brand-green accents (Option A): tie the navy footer to the theme --- */
    .togo-footer-ptb .togo-footer-main-wrapper.black-style .togo-footer-widget-title { color: #43a047; }
    .togo-footer-ptb .togo-footer-2-top-border { border-top-color: rgba(67, 160, 71, .45); }
    .togo-footer-ptb .gd-footer-legal { border-bottom-color: rgba(67, 160, 71, .3); }
    .togo-footer-ptb .togo-footer-widget-input-btn {
        top: 50%; right: 8px; transform: translateY(-50%);
        width: 42px; height: 42px; border-radius: 50%;
        background: linear-gradient(135deg, #2e7d32, #43a047);
        display: grid; place-items: center;
        box-shadow: 0 6px 14px rgba(46, 125, 50, .35);
        transition: box-shadow .2s ease, transform .2s ease;
    }
    .togo-footer-ptb .togo-footer-widget-input-btn:hover { transform: translateY(-50%) scale(1.06); box-shadow: 0 8px 20px rgba(46, 125, 50, .5); }
    .togo-footer-ptb .togo-footer-widget-input-btn span { color: #fff; margin: 0; }
</style>
<script>
    (function () {
        var form = document.getElementById('gdNewsletterForm');
        if (!form) return;
        var input = document.getElementById('gdNewsletterEmail');
        var msg = document.getElementById('gdNewsletterMsg');
        var token = (document.querySelector('meta[name="csrf-token"]') || {}).content;
        var emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        function show(text, ok) {
            msg.textContent = text;
            msg.className = 'gd-newsletter-msg ' + (ok ? 'is-success' : 'is-error');
            msg.style.display = 'block';
        }

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            var email = (input.value || '').trim();
            if (!emailRe.test(email)) { show('Please enter a valid email address.', false); input.focus(); return; }

            var btn = form.querySelector('button[type="submit"]');
            if (btn) btn.disabled = true;

            var hp = form.querySelector('input[name="website"]');
            var ts = form.querySelector('input[name="form_ts"]');

            fetch(form.getAttribute('data-action'), {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': token },
                body: JSON.stringify({ email: email, website: hp ? hp.value : '', form_ts: ts ? ts.value : '' })
            }).then(function (r) {
                return r.json().then(function (d) { return { status: r.status, data: d }; });
            }).then(function (res) {
                if (res.status >= 200 && res.status < 300) {
                    show(res.data.message || 'Thanks for subscribing!', true);
                    form.reset();
                } else if (res.status === 422) {
                    var errs = res.data.errors || {};
                    show((errs.email && errs.email[0]) || 'Please enter a valid email address.', false);
                } else {
                    show('Something went wrong. Please try again.', false);
                }
            }).catch(function () {
                show('Something went wrong. Please try again.', false);
            }).finally(function () {
                if (btn) btn.disabled = false;
            });
        });
    })();
</script>
@endpush
