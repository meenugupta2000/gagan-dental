@extends('layouts.public')

@section('title', 'About Us · ' . ($company->company_name ?? 'Gagan Dental & Aesthetics Clinic'))
@section('meta_description', $about->intro ? \Illuminate\Support\Str::limit(strip_tags($about->intro), 155) : 'Learn about our dental & aesthetics clinic, our lead doctor and our philosophy of gentle, expert care.')

@section('content')
@php
    $stats = $about->stats;
    $quals = $about->qualification_list;
@endphp
<style>
    /* ---------- Doctor / intro ---------- */
    .ab-doctor { padding: 84px 0 70px; background: #fff; overflow: hidden; }
    .ab-doctor-grid { display: grid; grid-template-columns: 1fr; gap: 46px; align-items: center; }
    @media (min-width: 992px) { .ab-doctor-grid { grid-template-columns: 440px 1fr; gap: 60px; } }

    .ab-photo-wrap { position: relative; }
    .ab-photo {
        position: relative; border-radius: 24px; overflow: hidden; aspect-ratio: 4/5;
        background: linear-gradient(150deg,#183a20,#2e7d32); box-shadow: 0 30px 60px rgba(13,27,42,.18);
    }
    .ab-photo img { width: 100%; height: 100%; object-fit: cover; object-position: top center; display: block; }
    .ab-photo-fallback { position: absolute; inset: 0; display: grid; place-items: center; color: rgba(255,255,255,.9); }
    .ab-photo-fallback svg { width: 96px; height: 96px; opacity: .9; }
    .ab-photo-deco { position: absolute; inset: 0; z-index: -1; }
    .ab-photo-deco::before { content: ''; position: absolute; right: -26px; bottom: -26px; width: 190px; height: 190px; border-radius: 24px; background: rgba(46,125,50,.12); }
    .ab-photo-deco::after { content: ''; position: absolute; left: -22px; top: -22px; width: 120px; height: 120px; border-radius: 20px; border: 3px solid rgba(46,125,50,.25); }

    .ab-exp-badge {
        position: absolute; right: 18px; bottom: 18px; z-index: 3;
        background: #fff; border-radius: 16px; padding: 14px 20px; text-align: center;
        box-shadow: 0 16px 32px rgba(13,27,42,.22);
    }
    .ab-exp-badge .n { font-size: 1.9rem; font-weight: 800; color: #2e7d32; line-height: 1; }
    .ab-exp-badge .t { font-size: .72rem; font-weight: 700; color: #5d6a82; text-transform: uppercase; letter-spacing: .06em; margin-top: 3px; }

    .ab-eyebrow { display: inline-block; color: #2e7d32; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; font-size: .82rem; margin-bottom: 12px; }
    .ab-name { font-size: clamp(1.9rem, 4vw, 2.7rem); font-weight: 800; color: #14233a; line-height: 1.15; margin: 0 0 6px; }
    .ab-role { font-size: 1.06rem; font-weight: 700; color: #2e7d32; margin-bottom: 18px; }
    .ab-intro { color: #4a5568; font-size: 1.08rem; line-height: 1.8; margin: 0 0 22px; }

    .ab-quals { list-style: none; padding: 0; margin: 0 0 26px; display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 10px 22px; }
    .ab-quals li { position: relative; padding-left: 30px; color: #26313f; font-weight: 600; font-size: .98rem; }
    .ab-quals li svg { position: absolute; left: 0; top: 1px; width: 20px; height: 20px; color: #2e7d32; }

    .ab-actions { display: flex; flex-wrap: wrap; gap: 14px; align-items: center; }

    /* ---------- Stats band ---------- */
    .ab-stats { background: linear-gradient(135deg,#12331b,#2e7d32); padding: 54px 0; }
    .ab-stats-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 34px 20px; text-align: center; }
    @media (min-width: 768px) { .ab-stats-grid { grid-template-columns: repeat(4, 1fr); } }
    .ab-stat .n { font-size: clamp(2rem, 4vw, 2.8rem); font-weight: 800; color: #fff; line-height: 1; }
    .ab-stat .t { color: #bfe3c6; font-size: .92rem; font-weight: 600; margin-top: 8px; letter-spacing: .02em; }
    .ab-stat + .ab-stat { position: relative; }

    /* ---------- Story / rich body ---------- */
    .ab-story { padding: 80px 0; background: #f6f8fb; }
    .ab-story-grid { display: grid; grid-template-columns: 1fr; gap: 40px; }
    @media (min-width: 992px) { .ab-story-grid { grid-template-columns: 1fr 340px; gap: 54px; align-items: start; } }

    .ab-prose { color: #3c4657; font-size: 1.04rem; line-height: 1.85; }
    .ab-prose h2, .ab-prose h3 { color: #14233a; font-weight: 800; margin: 34px 0 12px; line-height: 1.3; }
    .ab-prose h2:first-child, .ab-prose h3:first-child { margin-top: 0; }
    .ab-prose h3 { font-size: 1.4rem; }
    .ab-prose p { margin: 0 0 18px; }
    .ab-prose ul, .ab-prose ol { margin: 0 0 18px; padding-left: 22px; }
    .ab-prose li { margin-bottom: 8px; }
    .ab-prose strong { color: #1f2a37; }
    .ab-prose a { color: #2e7d32; text-decoration: underline; }
    .ab-prose blockquote { margin: 0 0 18px; padding: 14px 22px; border-left: 4px solid #2e7d32; background: #eef7f0; border-radius: 0 10px 10px 0; color: #2a4a33; font-style: italic; }

    .ab-aside { position: sticky; top: 100px; display: grid; gap: 22px; }
    .ab-card { background: #fff; border: 1px solid #e9edf3; border-radius: 18px; padding: 26px 24px; box-shadow: 0 12px 30px rgba(13,27,42,.05); }
    .ab-card h4 { font-size: 1.02rem; font-weight: 800; color: #14233a; margin: 0 0 14px; display: flex; align-items: center; gap: 9px; }
    .ab-card h4 svg { width: 20px; height: 20px; color: #2e7d32; }
    .ab-philosophy { background: linear-gradient(150deg,#12331b,#2e7d32); color: #eaf6ec; border: 0; }
    .ab-philosophy h4 { color: #fff; }
    .ab-philosophy h4 svg { color: #bfe3c6; }
    .ab-philosophy p { margin: 0; font-size: 1.02rem; line-height: 1.75; font-style: italic; color: #eef7f0; }
    .ab-mini-quals { list-style: none; padding: 0; margin: 0; }
    .ab-mini-quals li { position: relative; padding: 8px 0 8px 28px; border-top: 1px solid #eef1f6; color: #26313f; font-weight: 600; font-size: .95rem; }
    .ab-mini-quals li:first-child { border-top: 0; }
    .ab-mini-quals li svg { position: absolute; left: 0; top: 9px; width: 18px; height: 18px; color: #2e7d32; }

    /* ---------- Features ---------- */
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

    /* ---------- CTA ---------- */
    .ab-cta { padding: 76px 0; background: linear-gradient(135deg,#12331b,#2e7d32); text-align: center; }
    .ab-cta h2 { color: #fff; font-size: clamp(1.7rem, 3.6vw, 2.4rem); font-weight: 800; margin: 0 0 12px; }
    .ab-cta p { color: #cfe9d5; font-size: 1.05rem; max-width: 560px; margin: 0 auto 26px; line-height: 1.7; }
    .ab-cta .togo-btn-primary.btn-white-bg { color: #12331b; font-weight: 600; }
</style>

<x-page-hero
    eyebrow="About Us"
    title="Get to Know Our Clinic"
    subtitle="{{ $company->tagline ?? 'Advanced dentistry and aesthetic artistry under one roof.' }}" />

{{-- Doctor / intro --}}
<section class="ab-doctor">
    <div class="container container-1440">
        <div class="ab-doctor-grid">
            <div class="ab-photo-wrap">
                <div class="ab-photo-deco"></div>
                <div class="ab-photo">
                    @if ($about->doctor_photo_url)
                        <img src="{{ $about->doctor_photo_url }}" alt="{{ $about->doctor_name ?? 'Our lead doctor' }}">
                    @else
                        <div class="ab-photo-fallback">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 12a5 5 0 1 0 0-10 5 5 0 0 0 0 10ZM3.5 21a8.5 8.5 0 0 1 17 0" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                        </div>
                    @endif
                    @if ($about->experience_years)
                        <div class="ab-exp-badge">
                            <div class="n">{{ $about->experience_years }}+</div>
                            <div class="t">Years<br>Experience</div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="ab-doctor-info">
                @if ($about->doctor_title)
                    <span class="ab-eyebrow">{{ $about->doctor_title }}</span>
                @else
                    <span class="ab-eyebrow">{{ $about->subtitle ?? 'Get To Know Us' }}</span>
                @endif

                <h2 class="ab-name">{{ $about->doctor_name ?? ($company->company_name ?? 'Our Clinic') }}</h2>

                @if ($about->doctor_name && $about->clinic_since)
                    <div class="ab-role">Caring for smiles since {{ $about->clinic_since }}</div>
                @endif

                @if ($about->intro)
                    <p class="ab-intro">{{ $about->intro }}</p>
                @endif

                @if (count($quals))
                    <ul class="ab-quals">
                        @foreach ($quals as $q)
                            <li>
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="m5 13 4 4L19 7" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                {{ $q }}
                            </li>
                        @endforeach
                    </ul>
                @endif

                <div class="ab-actions">
                    <a class="togo-btn-primary" href="{{ route('appointment') }}">Book an Appointment</a>
                    @if (($company->phone ?? null))
                        <a class="togo-btn-primary bdr-style orange-bdr" href="tel:{{ preg_replace('/[^0-9+]/','',$company->phone) }}">Call {{ $company->phone }}</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Stats band --}}
@if (count($stats))
<section class="ab-stats">
    <div class="container container-1440">
        <div class="ab-stats-grid">
            @foreach ($stats as $stat)
                <div class="ab-stat">
                    <div class="n">{{ $stat['value'] }}</div>
                    <div class="t">{{ $stat['label'] }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Story / rich content --}}
@if ($about->body || $about->philosophy || count($quals))
<section class="ab-story">
    <div class="container container-1440">
        <div class="ab-story-grid">
            <div class="ab-prose">
                @if ($about->body)
                    {!! $about->body !!}
                @else
                    <h3>{{ $about->title ? str_replace("\n", ' ', $about->title) : 'Our Commitment to You' }}</h3>
                    <p>{{ $about->description }}</p>
                @endif
            </div>

            <aside class="ab-aside">
                @if ($about->philosophy)
                    <div class="ab-card ab-philosophy">
                        <h4>
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7 8h10M7 12h6m-6 8-3.5-2H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-6l-4 2Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
                            Our Philosophy
                        </h4>
                        <p>{{ $about->philosophy }}</p>
                    </div>
                @endif

                @if (count($quals))
                    <div class="ab-card">
                        <h4>
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 2 3 6v6c0 5 3.8 8.4 9 10 5.2-1.6 9-5 9-10V6l-9-4Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/><path d="m9 12 2 2 4-4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            Qualifications
                        </h4>
                        <ul class="ab-mini-quals">
                            @foreach ($quals as $q)
                                <li>
                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="m5 13 4 4L19 7" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    {{ $q }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </aside>
        </div>
    </div>
</section>
@endif

{{-- Why choose us (features) --}}
@if ($features->isNotEmpty())
<section class="ab-features">
    <div class="container container-1440">
        <div class="ab-sec-head">
            <span class="eyebrow">Why Choose Us</span>
            <h2>What Sets Our Care Apart</h2>
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

{{-- CTA --}}
<section class="ab-cta">
    <div class="container container-1440">
        <h2>Ready to Start Your Smile Journey?</h2>
        <p>Book a consultation today and experience gentle, expert dental &amp; aesthetic care tailored to you.</p>
        <a class="togo-btn-primary btn-white-bg" href="{{ route('appointment') }}">Book an Appointment</a>
    </div>
</section>
@endsection
