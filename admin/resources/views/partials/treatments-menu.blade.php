                                 <li class="togo-dropdown p-static">
                                    <a href="{{ route('treatments') }}">Treatments</a>
                                    @if ($menuCategories->isNotEmpty())
                                    {{-- NOTE: the "togo-megamenu-destination*" class names below are theme
                                         CSS/JS hooks (assets/js/scripts.js switches the panels via
                                         .togo-megamenu-nav li / .togo-megamenu-destination-wrap) — keep them. --}}
                                    <div class="togo-megamenu mobile-slide">
                                       <div class="row">
                                          <div class="col-xl-3">
                                             <div class="togo-megamenu-nav">
                                                <ul>
                                                   @foreach ($menuCategories as $i => $m)
                                                   <li class="{{ $i === 0 ? 'active' : '' }}">
                                                      <a href="#">{{ $m->category->name }}
                                                         <span>
                                                            <svg aria-hidden="true" role="img" focusable="false" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                               <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                                            </svg>
                                                         </span>
                                                      </a>
                                                   </li>
                                                   @endforeach
                                                </ul>
                                                <div class="togo-megamenu-show d-none d-xl-block">
                                                   <a class="togo-tour-btn line-border" href="{{ route('treatments') }}">
                                                      <span>View all</span>
                                                   </a>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="col-xl-6">
                                             <div class="togo-megamenu-destination">
                                                @foreach ($menuCategories as $i => $m)
                                                <div class="togo-megamenu-destination-wrap {{ $i === 0 ? '' : 'd-none' }}">
                                                   <span class="togo-megamenu-destination-title">{{ $m->category->name }}</span>
                                                   <div class="row">
                                                      @foreach ($m->treatments->take(6) as $t)
                                                      <div class="col-xl-6">
                                                         <div class="togo-megamenu-destination-item mb-20">
                                                            <div class="togo-megamenu-destination-thumb">
                                                               <a href="{{ route('treatments.show', $t->slug) }}" aria-label="{{ $t->name }}">
                                                                  <img src="{{ $t->primary_image_url ?? ($m->category->image_url ?? asset('assets/img/placeholder-category.svg')) }}" alt="{{ $t->name }}">
                                                               </a>
                                                            </div>
                                                            <div class="togo-megamenu-destination-content">
                                                               <a href="{{ route('treatments.show', $t->slug) }}">{{ $t->name }}</a>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      @endforeach
                                                   </div>
                                                   <div class="togo-megamenu-show d-none d-xl-block">
                                                      <a class="togo-tour-btn line-border" href="{{ route('treatments', ['category' => $m->category->slug]) }}">
                                                         <span>View all {{ $m->category->name }}</span>
                                                      </a>
                                                   </div>
                                                </div>
                                                @endforeach
                                             </div>
                                          </div>
                                          <div class="col-xl-3">
                                             @php($menuBanner = $company && $company->menu_image_path
                                                ? asset('storage/'.$company->menu_image_path).'?v='.optional($company->updated_at)->timestamp
                                                : asset('assets/img/placeholder-category.svg'))
                                             <div class="togo-megamenu-banner" style="background-color:#0d1b2a; background-image:url('{{ $menuBanner }}'); background-position:center; background-size:cover;">
                                                <h4 class="togo-megamenu-banner-title">{{ $company->company_name ?? 'Gagan Dental & Aesthetics Clinic' }}</h4>
                                                <p>Healthy smiles start with the right care.</p>
                                                <a class="togo-btn-primary" href="{{ route('appointment') }}">Book an Appointment</a>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    @endif
                                 </li>
