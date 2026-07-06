@extends('layouts.public')

@section('title', $treatment->name . ' · ' . ($company->company_name ?? 'Gagan Dental & Aesthetics Clinic'))
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags((string) $treatment->description), 150))

@php
    $waDigits = preg_replace('/[^0-9]/', '', (string) ($company->whatsapp ?? ''));
    $waLink = $waDigits ? 'https://wa.me/' . $waDigits . '?text=' . rawurlencode('Hi, I would like to know more about the treatment: ' . $treatment->name) : null;
@endphp

@section('content')
<style>
    .trtd-section { padding: 60px 0 100px; background: #f4f6fa; }
    .trtd-grid { display: grid; grid-template-columns: 1fr; gap: 34px; }
    @media (min-width: 992px) { .trtd-grid { grid-template-columns: minmax(0,1fr) 360px; align-items: start; } }

    .trtd-main { border-radius: 18px; overflow: hidden; border: 1px solid #e7ecf3; box-shadow: 0 12px 34px rgba(13,27,42,.07); background: #dde5f0; }
    .trtd-main img { width: 100%; height: clamp(280px, 46vw, 480px); object-fit: cover; display: block; }
    .trtd-thumbs { display: grid; grid-template-columns: repeat(auto-fill, minmax(86px, 1fr)); gap: 10px; margin-top: 12px; }
    .trtd-thumb { border-radius: 12px; overflow: hidden; border: 2px solid transparent; cursor: pointer; aspect-ratio: 4/3; }
    .trtd-thumb.active { border-color: #2e7d32; }
    .trtd-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }

    .trtd-body { background: #fff; border: 1px solid #e7ecf3; border-radius: 18px; padding: 30px clamp(22px,4vw,40px); margin-top: 26px; box-shadow: 0 10px 30px rgba(13,27,42,.05); }
    .trtd-body :is(h1,h2,h3,h4) { color: #14233a; font-weight: 800; }
    .trtd-body p { color: #41506a; line-height: 1.8; }
    .trtd-body ul, .trtd-body ol { color: #41506a; line-height: 1.8; padding-left: 1.2rem; }
    .trtd-body img { max-width: 100%; border-radius: 12px; }

    .trtd-tags { display: flex; flex-wrap: wrap; gap: 8px; margin: 0 0 18px; }
    .trtd-tag { background: #e7f4ea; color: #1b5e20; font-size: .82rem; font-weight: 700; padding: 5px 13px; border-radius: 7px; }
    .trtd-meta { display: flex; flex-wrap: wrap; gap: 18px; color: #5d6a82; font-size: .94rem; margin-bottom: 6px; }
    .trtd-meta span { display: inline-flex; align-items: center; gap: 7px; }

    /* Sticky booking card */
    .trtd-aside { position: sticky; top: 100px; }
    .trtd-book { background: #0d1b2a; color: #dfe7f0; border-radius: 18px; padding: 28px 26px; }
    .trtd-badge { display: inline-block; background: linear-gradient(135deg,#2e7d32,#43a047); color: #fff; font-size: .72rem; font-weight: 800; padding: 5px 13px; border-radius: 50px; text-transform: uppercase; letter-spacing: .03em; margin-bottom: 14px; }
    .trtd-dur { color: #9fb0c3; font-size: .95rem; display: inline-flex; align-items: center; gap: 8px; margin: 0 0 20px; }
    .trtd-btn { display: flex; align-items: center; justify-content: center; gap: 9px; width: 100%; border-radius: 12px; padding: 14px 18px; font-weight: 800; text-decoration: none; transition: transform .25s, box-shadow .25s, background .25s; }
    .trtd-btn-book { background: linear-gradient(135deg,#2e7d32,#43a047); color: #fff; box-shadow: 0 12px 26px rgba(46, 125, 50,.3); }
    .trtd-btn-book:hover { color: #fff; transform: translateY(-2px); box-shadow: 0 18px 34px rgba(46, 125, 50,.42); }
    .trtd-btn-wa { background: #25d366; color: #fff; margin-top: 12px; box-shadow: 0 12px 26px rgba(37,211,102,.3); }
    .trtd-btn-wa:hover { color: #fff; background: #1ebe57; transform: translateY(-2px); box-shadow: 0 18px 34px rgba(37,211,102,.45); }
    .trtd-btn svg { width: 20px; height: 20px; }
    .trtd-aside-note { color: #9fb0c3; font-size: .8rem; text-align: center; margin: 14px 0 0; }

    .trtd-back { display: inline-flex; align-items: center; gap: 8px; margin-top: 30px; color: #2e7d32; font-weight: 700; }
    .trtd-back svg { transition: transform .25s ease; } .trtd-back:hover svg { transform: translateX(-4px); }

    .trtd-related { margin-top: 60px; }
    .trtd-related-title { font-size: 1.5rem; font-weight: 800; color: #14233a; margin: 0 0 26px; }
</style>

<x-page-hero :title="$treatment->name" :eyebrow="$treatment->category?->name" :image="$treatment->primary_image_url" />

<section class="trtd-section">
    <div class="container container-1440">
        <div class="trtd-grid">
            {{-- Left: gallery + description --}}
            <div>
                <div class="trtd-main">
                    @if ($treatment->images->isNotEmpty())
                        <img id="trtdMain" src="{{ $treatment->images->first()->image_url }}" alt="{{ $treatment->name }}">
                    @else
                        <img src="{{ asset('assets/img/placeholder-category.svg') }}" alt="{{ $treatment->name }}">
                    @endif
                </div>
                @if ($treatment->images->count() > 1)
                    <div class="trtd-thumbs">
                        @foreach ($treatment->images as $i => $img)
                            <div class="trtd-thumb {{ $i === 0 ? 'active' : '' }}" data-trtd-thumb data-src="{{ $img->image_url }}">
                                <img src="{{ $img->image_url }}" alt="{{ $treatment->name }} image {{ $i + 1 }}">
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="trtd-body">
                    @if ($treatment->duration)
                    <div class="trtd-meta">
                        <span><svg width="17" height="17" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/><path d="M12 7v5l3 2" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>{{ $treatment->duration }}</span>
                    </div>
                    @endif

                    @if ($treatment->category || $treatment->badge)
                    <div class="trtd-tags">
                        @if ($treatment->category)<span class="trtd-tag">{{ $treatment->category->name }}</span>@endif
                        @if ($treatment->badge)<span class="trtd-tag">{{ $treatment->badge }}</span>@endif
                    </div>
                    @endif

                    @if (filled($treatment->description))
                        {!! $treatment->description !!}
                    @else
                        <p class="mb-0 text-muted">Full details for this treatment will be available soon. Please book an appointment or contact us to learn more.</p>
                    @endif
                </div>

                <a href="{{ route('treatments') }}" class="trtd-back">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 6L9 12L15 18" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Back to all treatments
                </a>
            </div>

            {{-- Right: sticky booking card --}}
            <aside class="trtd-aside">
                <div class="trtd-book">
                    @if ($treatment->badge)<span class="trtd-badge">{{ $treatment->badge }}</span>@endif
                    @if ($treatment->duration)
                        <p class="trtd-dur"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/><path d="M12 7v5l3 2" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>{{ $treatment->duration }}</p>
                    @endif

                    <a href="{{ route('appointment') }}" class="trtd-btn trtd-btn-book">Book an Appointment</a>
                    @if ($waLink)
                        <a href="{{ $waLink }}" target="_blank" rel="noopener noreferrer" class="trtd-btn trtd-btn-wa">
                            <svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M17.47 14.38c-.3-.15-1.75-.86-2.02-.96-.27-.1-.47-.15-.67.15-.2.3-.77.96-.94 1.16-.17.2-.35.22-.64.07-.3-.15-1.25-.46-2.38-1.47-.88-.78-1.47-1.75-1.64-2.05-.17-.3-.02-.46.13-.6.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.07-.15-.67-1.6-.92-2.2-.24-.58-.49-.5-.67-.5h-.57c-.2 0-.52.07-.79.37-.27.3-1.04 1.02-1.04 2.47s1.07 2.86 1.22 3.06c.15.2 2.1 3.2 5.08 4.49.71.3 1.26.49 1.69.63.71.22 1.36.19 1.87.12.57-.09 1.75-.72 2-1.41.25-.69.25-1.28.17-1.41-.07-.13-.27-.2-.57-.35zM12.04 21.5h-.01a9.46 9.46 0 0 1-4.82-1.32l-.35-.2-3.58.94.96-3.49-.23-.36a9.45 9.45 0 0 1-1.45-5.04c0-5.23 4.26-9.49 9.5-9.49 2.54 0 4.92.99 6.71 2.79a9.43 9.43 0 0 1 2.78 6.71c0 5.23-4.26 9.49-9.49 9.49zm8.08-17.58A11.42 11.42 0 0 0 12.04.5C5.74.5.62 5.62.62 11.92c0 2.1.55 4.15 1.6 5.96L.5 23.5l5.77-1.51a11.4 11.4 0 0 0 5.77 1.47h.01c6.3 0 11.42-5.12 11.42-11.42 0-3.05-1.19-5.92-3.35-8.08z"/></svg>
                            Chat on WhatsApp
                        </a>
                    @endif
                    <p class="trtd-aside-note">Our team will confirm your appointment and answer every question.</p>
                </div>
            </aside>
        </div>

        @if ($related->isNotEmpty())
            <div class="trtd-related">
                <h2 class="trtd-related-title">Related Treatments</h2>
                <div class="trt-grid">
                    @foreach ($related as $rel)
                        <x-treatment-card :treatment="$rel" />
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>

@push('scripts')
<script>
(function () {
    var main = document.getElementById('trtdMain');
    if (!main) return;
    document.querySelectorAll('[data-trtd-thumb]').forEach(function (t) {
        t.addEventListener('click', function () {
            main.src = t.getAttribute('data-src');
            document.querySelectorAll('[data-trtd-thumb]').forEach(function (x) { x.classList.remove('active'); });
            t.classList.add('active');
        });
    });
})();
</script>
@endpush
@endsection
