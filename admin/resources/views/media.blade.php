@extends('layouts.public')

@section('title', 'Media Gallery · ' . ($company->company_name ?? 'Gagan Dental & Aesthetics Clinic'))
@section('meta_description', 'Newspaper features and magazine articles covering our work and our clinic.')

@section('content')
<style>
    .media-section { padding: 80px 0 100px; background: #f6f8fb; }

    .media-intro { text-align: center; max-width: 720px; margin: 0 auto 48px; }
    .media-intro .eyebrow { color: #2e7d32; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; font-size: .8rem; }
    .media-intro h2 { font-size: clamp(1.6rem, 3.4vw, 2.3rem); font-weight: 800; color: #14233a; margin: 8px 0 12px; }
    .media-intro p { color: #5d6a82; font-size: 1.02rem; line-height: 1.7; margin: 0; }

    /* 3 per row, responsive to 2 then 1 */
    .media-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 28px; }
    @media (max-width: 991.98px) { .media-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 575.98px) { .media-grid { grid-template-columns: 1fr; } }

    .media-card {
        background: #fff; border: 1px solid #e9edf3; border-radius: 16px; overflow: hidden;
        box-shadow: 0 8px 24px rgba(13,27,42,.06); display: flex; flex-direction: column;
        transition: transform .4s cubic-bezier(.2,.8,.2,1), box-shadow .4s ease, border-color .4s ease;
    }
    .media-card:hover { transform: translateY(-6px); box-shadow: 0 22px 45px rgba(46,125,50,.15); border-color: transparent; }

    .media-photo { position: relative; display: block; width: 100%; aspect-ratio: 4 / 3; overflow: hidden; background: #eef2f7; }
    .media-photo img { width: 100%; height: 100%; object-fit: cover; transition: transform .55s cubic-bezier(.2,.8,.2,1); display: block; }
    .media-card:hover .media-photo img { transform: scale(1.06); }
    .media-photo::after { content: ''; position: absolute; inset: 0; background: rgba(13,27,42,.18); opacity: 0; transition: opacity .3s ease; }
    .media-card:hover .media-photo::after { opacity: 1; }
    .media-zoom {
        position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%) scale(.8); z-index: 2; opacity: 0;
        width: 46px; height: 46px; border-radius: 50%; background: rgba(255,255,255,.95); color: #2e7d32;
        display: grid; place-items: center; box-shadow: 0 6px 18px rgba(0,0,0,.25); transition: opacity .3s ease, transform .3s ease;
    }
    .media-card:hover .media-zoom { opacity: 1; transform: translate(-50%,-50%) scale(1); }
    .media-zoom svg { width: 20px; height: 20px; }

    .media-cap { padding: 16px 18px 18px; }
    .media-cap h3 { font-size: 1rem; font-weight: 700; color: #14233a; line-height: 1.45; margin: 0; }

    .media-empty { text-align: center; padding: 70px 0; color: #8893a5; font-size: 1.05rem; }
</style>

<x-page-hero
    eyebrow="In the News"
    title="Media Gallery"
    subtitle="Our work, featured in newspapers and magazines over the years." />

<section class="media-section">
    <div class="container container-1440">
        <div class="media-intro">
            <span class="eyebrow">Press &amp; Coverage</span>
            <h2>Media Gallery</h2>
            <p>A collection of newspaper features and magazine articles covering our work and our clinic.</p>
        </div>

        @if ($media->isEmpty())
            <div class="media-empty">Our media coverage will appear here soon.</div>
        @else
            <div class="media-grid">
                @foreach ($media as $item)
                    <article class="media-card">
                        <a href="{{ $item->image_url }}" class="popup-image media-photo" title="{{ $item->title }}">
                            <img src="{{ $item->image_url }}" alt="{{ $item->title }}" loading="lazy">
                            <span class="media-zoom">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/><path d="M20 20l-3-3M11 8v6M8 11h6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                            </span>
                        </a>
                        <div class="media-cap"><h3>{{ $item->title }}</h3></div>
                    </article>
                @endforeach
            </div>
        @endif

        <div class="text-center" style="margin-top: 52px;">
            <a class="togo-btn-primary" href="{{ route('appointment') }}">Book an Appointment</a>
        </div>
    </div>
</section>
@endsection
