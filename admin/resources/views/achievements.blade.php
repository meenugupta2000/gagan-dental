@extends('layouts.public')

@section('title', 'Achievements & Honours · ' . ($company->company_name ?? 'Gagan Dental & Aesthetics Clinic'))
@section('meta_description', 'Awards, certifications and honours earned by our lead doctor and clinic over the years.')

@section('content')
<style>
    .ach-section { padding: 80px 0 100px; background: #f6f8fb; }

    .ach-intro { text-align: center; max-width: 720px; margin: 0 auto 48px; }
    .ach-intro .eyebrow { color: #2e7d32; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; font-size: .8rem; }
    .ach-intro h2 { font-size: clamp(1.6rem, 3.4vw, 2.3rem); font-weight: 800; color: #14233a; margin: 8px 0 12px; }
    .ach-intro p { color: #5d6a82; font-size: 1.02rem; line-height: 1.7; margin: 0; }

    /* 3 achievements per row, responsive to 2 then 1 */
    .ach-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px 28px; }
    @media (max-width: 991.98px) { .ach-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 575.98px) { .ach-grid { grid-template-columns: 1fr; } }

    .ach-card {
        background: #fff; border: 1px solid #e9edf3; border-radius: 18px; overflow: hidden;
        box-shadow: 0 8px 24px rgba(13,27,42,.06); display: flex; flex-direction: column;
        opacity: 0; transform: translateY(24px); animation: achIn .55s cubic-bezier(.2,.8,.2,1) forwards;
        transition: transform .4s cubic-bezier(.2,.8,.2,1), box-shadow .4s ease, border-color .4s ease;
    }
    @keyframes achIn { to { opacity: 1; transform: translateY(0); } }
    .ach-card:hover { transform: translateY(-8px); box-shadow: 0 24px 48px rgba(46,125,50,.16); border-color: transparent; }

    .ach-photo { position: relative; display: block; width: 100%; aspect-ratio: 4 / 3; overflow: hidden; background: #eef2f7; }
    .ach-photo img { width: 100%; height: 100%; object-fit: cover; transition: transform .55s cubic-bezier(.2,.8,.2,1); display: block; }
    .ach-card:hover .ach-photo img { transform: scale(1.06); }
    .ach-photo::after { content: ''; position: absolute; inset: 0; background: rgba(13,27,42,.16); opacity: 0; transition: opacity .3s ease; }
    .ach-card:hover .ach-photo::after { opacity: 1; }
    .ach-zoom {
        position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%) scale(.8); z-index: 2; opacity: 0;
        width: 46px; height: 46px; border-radius: 50%; background: rgba(255,255,255,.95); color: #2e7d32;
        display: grid; place-items: center; box-shadow: 0 6px 18px rgba(0,0,0,.25); transition: opacity .3s ease, transform .3s ease;
    }
    .ach-card:hover .ach-zoom { opacity: 1; transform: translate(-50%,-50%) scale(1); }
    .ach-zoom svg { width: 20px; height: 20px; }

    /* Placeholder when no photo uploaded yet */
    .ach-photo-ph { position: absolute; inset: 0; display: grid; place-items: center; background: linear-gradient(135deg,#183a20,#2e7d32); color: rgba(255,255,255,.85); }
    .ach-photo-ph svg { width: 54px; height: 54px; }

    .ach-body { padding: 18px 20px 22px; display: flex; flex-direction: column; flex: 1; }
    .ach-badge { display: inline-flex; align-items: center; gap: 6px; align-self: flex-start; background: #e7f4ea; color: #1b5e20; font-size: .7rem; font-weight: 800; letter-spacing: .04em; text-transform: uppercase; padding: 4px 10px; border-radius: 50px; margin-bottom: 10px; }
    .ach-badge svg { width: 13px; height: 13px; }
    .ach-title { font-size: 1.06rem; font-weight: 800; color: #14233a; line-height: 1.4; margin: 0 0 8px; }
    .ach-notes { color: #5d6a82; font-size: .93rem; line-height: 1.6; margin: 0; }

    .ach-empty { text-align: center; padding: 70px 0; color: #8893a5; font-size: 1.05rem; }
    .ach-cta { text-align: center; margin-top: 52px; }
</style>

<x-page-hero
    eyebrow="Recognition & Honours"
    title="Our Achievements"
    subtitle="Years of dedication, reflected in the awards, certifications and honours we've been privileged to receive." />

<section class="ach-section">
    <div class="container container-1440">
        <div class="ach-intro">
            <span class="eyebrow">A Legacy of Excellence</span>
            <h2>Awards &amp; Recognition</h2>
            <p>We're proud of the recognition our work has earned over the years — each one a reflection of our commitment to exceptional, patient-first care.</p>
        </div>

        @if ($achievements->isEmpty())
            <div class="ach-empty">Our achievements will appear here soon.</div>
        @else
            <div class="ach-grid">
                @foreach ($achievements as $achievement)
                    <article class="ach-card" style="animation-delay: {{ ($loop->index % 12) * 0.05 }}s;">
                        @if ($achievement->image_url)
                            <a href="{{ $achievement->image_url }}" class="popup-image ach-photo" title="{{ $achievement->title }}">
                                <img src="{{ $achievement->image_url }}" alt="{{ $achievement->title }}" loading="lazy">
                                <span class="ach-zoom">
                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/><path d="M20 20l-3-3M11 8v6M8 11h6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                                </span>
                            </a>
                        @else
                            <div class="ach-photo">
                                <span class="ach-photo-ph">
                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8 21h8m-4-4v4M7 4h10v4a5 5 0 0 1-10 0V4Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M17 5h2.5A1.5 1.5 0 0 1 21 6.5C21 9 19 10 17 10M7 5H4.5A1.5 1.5 0 0 0 3 6.5C3 9 5 10 7 10" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
                                </span>
                            </div>
                        @endif
                        <div class="ach-body">
                            <span class="ach-badge">
                                <svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M12 2l2.4 4.9 5.4.8-3.9 3.8.9 5.4L12 14.9 7.2 17l.9-5.4L4.2 7.7l5.4-.8L12 2z"/></svg>
                                Achievement
                            </span>
                            <h3 class="ach-title">{{ $achievement->title }}</h3>
                            @if ($achievement->notes)
                                <p class="ach-notes">{{ $achievement->notes }}</p>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
        @endif

        <div class="ach-cta">
            <a class="togo-btn-primary" href="{{ route('appointment') }}">Book an Appointment</a>
        </div>
    </div>
</section>
@endsection
