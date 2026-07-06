@extends('layouts.public')

@section('title', 'Patient Testimonials · ' . ($company->company_name ?? 'Gagan Dental & Aesthetics Clinic'))
@section('meta_description', 'Watch real patient video testimonials and smile transformation stories from ' . ($company->company_name ?? 'our clinic') . '.')

@section('content')
<style>
    .vt-section { padding: 80px 0 100px; background: #f6f8fb; }

    .vt-intro { text-align: center; max-width: 720px; margin: 0 auto 46px; }
    .vt-intro .eyebrow { color: #2e7d32; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; font-size: .8rem; }
    .vt-intro h2 { font-size: clamp(1.6rem, 3.4vw, 2.3rem); font-weight: 800; color: #14233a; margin: 8px 0 12px; }
    .vt-intro p { color: #5d6a82; font-size: 1.02rem; line-height: 1.7; margin: 0; }

    /* Grid — 4 videos per row, responsive down to 1 */
    .vt-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 28px 24px; }
    @media (max-width: 1199.98px) { .vt-grid { grid-template-columns: repeat(3, 1fr); } }
    @media (max-width: 991.98px)  { .vt-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 575.98px)  { .vt-grid { grid-template-columns: 1fr; } }

    .vt-card {
        background: #fff; border: 1px solid #e9edf3; border-radius: 16px; overflow: hidden;
        box-shadow: 0 8px 24px rgba(13,27,42,.06);
        display: flex; flex-direction: column;
        opacity: 0; transform: translateY(24px);
        animation: vtIn .55s cubic-bezier(.2,.8,.2,1) forwards;
        transition: transform .4s cubic-bezier(.2,.8,.2,1), box-shadow .4s ease, border-color .4s ease;
    }
    @keyframes vtIn { to { opacity: 1; transform: translateY(0); } }
    .vt-card:hover { transform: translateY(-8px); box-shadow: 0 22px 44px rgba(46,125,50,.16); border-color: transparent; }

    .vt-thumb {
        position: relative; display: block; width: 100%; aspect-ratio: 16 / 9; overflow: hidden;
        background: linear-gradient(135deg,#183a20,#2e7d32);
    }
    .vt-thumb img { width: 100%; height: 100%; object-fit: cover; transition: transform .5s cubic-bezier(.2,.8,.2,1); display: block; }
    .vt-card:hover .vt-thumb img { transform: scale(1.07); }
    .vt-thumb::after { content: ''; position: absolute; inset: 0; background: rgba(13,27,42,.20); transition: background .3s ease; }
    .vt-card:hover .vt-thumb::after { background: rgba(13,27,42,.06); }
    .vt-play {
        position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%); z-index: 2;
        width: 52px; height: 52px; border-radius: 50%; background: rgba(255,255,255,.92); color: #2e7d32;
        display: grid; place-items: center; box-shadow: 0 6px 18px rgba(0,0,0,.28); transition: transform .3s ease, background .3s ease;
    }
    .vt-card:hover .vt-play { transform: translate(-50%,-50%) scale(1.12); background: #fff; }
    .vt-play svg { width: 22px; height: 22px; margin-left: 3px; }

    .vt-caption {
        padding: 16px 18px 20px; font-size: 1.02rem; font-weight: 700; color: #14233a; line-height: 1.45;
        display: flex; align-items: flex-start; gap: 10px; flex: 1;
    }
    .vt-caption .q { flex: 0 0 auto; width: 26px; height: 26px; border-radius: 8px; background: #e7f4ea; color: #2e7d32; display: grid; place-items: center; }
    .vt-caption .q svg { width: 15px; height: 15px; }
    .vt-caption a { color: inherit; text-decoration: none; }
    .vt-caption a:hover { color: #2e7d32; }

    .vt-empty { text-align: center; padding: 70px 0; color: #8893a5; font-size: 1.05rem; }
    .vt-cta { text-align: center; margin-top: 50px; }
</style>

<x-page-hero
    eyebrow="Real Patient Stories"
    title="Video Testimonials"
    subtitle="Watch our patients share their smile transformations and their experience of gentle, expert care." />

<section class="vt-section">
    <div class="container container-1440">
        <div class="vt-intro">
            <span class="eyebrow">Hear It From Them</span>
            <h2>Smiles Worth Sharing</h2>
            <p>Nothing speaks louder than a real patient's story. Tap any video below to watch their journey.</p>
        </div>

        @if ($videos->isEmpty())
            <div class="vt-empty">Patient video testimonials will appear here soon.</div>
        @else
            <div class="vt-grid">
                @foreach ($videos as $video)
                    <article class="vt-card" style="animation-delay: {{ $loop->index * 0.06 }}s;">
                        <a href="{{ $video->watch_url }}" class="popup-video vt-thumb" aria-label="Play: {{ $video->heading }}">
                            <img src="{{ $video->thumbnail_url ?? asset('assets/img/placeholder-category.svg') }}"
                                 alt="{{ $video->heading }}" loading="lazy"
                                 onerror="this.style.display='none'">
                            <span class="vt-play">
                                <svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M8 5v14l11-7z"/></svg>
                            </span>
                        </a>
                        <div class="vt-caption">
                            <span class="q">
                                <svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M8 5v14l11-7z"/></svg>
                            </span>
                            <a href="{{ $video->watch_url }}" class="popup-video">{{ $video->heading }}</a>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif

        <div class="vt-cta">
            <a class="togo-btn-primary" href="{{ route('appointment') }}">Book an Appointment</a>
        </div>
    </div>
</section>
@endsection
