@extends('layouts.public')

@section('title', 'Special Offers · ' . ($company->company_name ?? 'Gagan Dental & Aesthetics Clinic'))
@section('meta_description', 'Explore our latest offers on dental and aesthetic treatments.')

@section('content')
<style>

    .offers-section { padding: 80px 0 100px; background: #f6f8fb; }
    .offers-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 30px; }
    @media (max-width: 767.98px) { .offers-grid { grid-template-columns: 1fr; } }

    .offer-card {
        background: #fff; border: 1px solid #eceff5; border-radius: 18px; overflow: hidden;
        display: flex; flex-direction: column;
        transition: transform .4s cubic-bezier(.2,.8,.2,1), box-shadow .4s ease, border-color .4s ease;
    }
    .offer-card:hover { transform: translateY(-8px); box-shadow: 0 22px 45px rgba(13,27,42,.13); border-color: transparent; }
    .offer-card-thumb { position: relative; height: 200px; overflow: hidden; background: #e9eef5; }
    .offer-card-thumb img { width: 100%; height: 100%; object-fit: cover; transition: transform .6s cubic-bezier(.2,.8,.2,1); }
    .offer-card:hover .offer-card-thumb img { transform: scale(1.08); }
    .offer-badge {
        position: absolute; top: 14px; left: 14px; z-index: 1;
        background: #2e7d32; color: #fff; font-size: .72rem; font-weight: 700; letter-spacing: .06em;
        text-transform: uppercase; padding: 5px 12px; border-radius: 50px;
    }
    .offer-card-body { padding: 22px 22px 24px; display: flex; flex-direction: column; flex: 1; }
    .offer-card-title { font-family: var(--togo-ff-marcellus); font-size: 1.25rem; font-weight: 600; color: #14233a; margin: 0 0 10px; }
    .offer-card-desc { color: #647089; font-size: .95rem; line-height: 1.6; margin: 0 0 18px; flex: 1; }
    .offer-card-actions { display: flex; align-items: center; justify-content: space-between; gap: 12px; }
    .offer-book-btn {
        display: inline-flex; align-items: center; gap: 8px;
        background: linear-gradient(135deg,#2e7d32,#43a047); color: #fff;
        border-radius: 50px; padding: 11px 24px; font-weight: 700; font-size: .92rem; text-decoration: none;
        box-shadow: 0 10px 22px rgba(46, 125, 50,.28); transition: transform .25s, box-shadow .25s;
    }
    .offer-book-btn:hover { color: #fff; transform: translateY(-2px); box-shadow: 0 16px 30px rgba(46, 125, 50,.4); }

    /* Book / Call / WhatsApp action row */
    .offer-actions-row { display: flex; align-items: center; gap: 10px; margin-bottom: 14px; }
    .offer-actions-row .offer-book-btn { flex: 1 1 auto; justify-content: center; }
    .offer-icon-btn {
        flex: 0 0 auto; width: 44px; height: 44px; border-radius: 50%;
        display: inline-flex; align-items: center; justify-content: center; color: #fff; text-decoration: none;
        transition: transform .25s ease, box-shadow .25s ease, background .25s ease;
    }
    .offer-icon-btn:hover { color: #fff; transform: translateY(-2px); }
    .offer-icon-btn svg { width: 22px; height: 22px; }
    .offer-icon-call { background: #1e88e5; box-shadow: 0 8px 18px rgba(30,136,229,.4); }
    .offer-icon-call:hover { background: #1670c9; box-shadow: 0 12px 24px rgba(30,136,229,.55); }
    .offer-icon-wa { background: #25D366; box-shadow: 0 8px 18px rgba(37,211,102,.4); }
    .offer-icon-wa:hover { background: #1ebe57; box-shadow: 0 12px 24px rgba(37,211,102,.55); }

    .offer-card-link {
        display: inline-flex; align-items: center; gap: 7px; color: #2e7d32; font-weight: 600; font-size: .92rem;
        background: none; border: 0; padding: 0; cursor: pointer;
    }
    .offer-card-link svg { transition: transform .3s ease; }
    .offer-card:hover .offer-card-link svg { transform: translateX(4px); }
    .offers-empty { text-align: center; padding: 70px 0; color: #8893a5; font-size: 1.05rem; }

    /* ---------- Popup ---------- */
    .offer-modal { position: fixed; inset: 0; z-index: 1090; display: none; }
    .offer-modal.open { display: flex; align-items: center; justify-content: center; padding: 24px; }
    .offer-modal-overlay { position: absolute; inset: 0; background: rgba(13,27,42,.6); opacity: 0; transition: opacity .3s ease; backdrop-filter: blur(2px); }
    .offer-modal.open .offer-modal-overlay { opacity: 1; }
    .offer-modal-dialog {
        position: relative; z-index: 1; background: #fff; width: min(640px, 100%);
        max-height: calc(100vh - 48px); overflow-y: auto; border-radius: 20px;
        box-shadow: 0 30px 70px rgba(0,0,0,.35);
        transform: translateY(24px) scale(.96); opacity: 0;
        transition: transform .35s cubic-bezier(.2,.8,.2,1), opacity .35s ease;
    }
    .offer-modal.open .offer-modal-dialog { transform: none; opacity: 1; }
    .offer-modal-close {
        position: absolute; top: 14px; right: 14px; z-index: 2;
        width: 38px; height: 38px; border: 0; border-radius: 50%;
        background: rgba(255,255,255,.9); color: #14233a; font-size: 1.5rem; line-height: 1;
        cursor: pointer; display: grid; place-items: center; box-shadow: 0 4px 12px rgba(0,0,0,.18);
        transition: background .2s, transform .2s;
    }
    .offer-modal-close:hover { background: #2e7d32; color: #fff; transform: rotate(90deg); }
    .offer-modal-img { width: 100%; height: 280px; overflow: hidden; background: #e9eef5; }
    .offer-modal-img img { width: 100%; height: 100%; object-fit: cover; }
    .offer-modal-content { padding: 28px clamp(22px, 4vw, 38px) 34px; }
    .offer-modal-content h3 { font-size: 1.6rem; font-weight: 800; color: #14233a; margin: 0 0 16px; }
    .offer-modal-desc { color: #41506a; font-size: 1.02rem; line-height: 1.75; margin-bottom: 24px; }
</style>

<x-page-hero
    title="Special Offers"
    subtitle="Smile-friendly savings — our latest offers on dental and aesthetic treatments." />

<section class="offers-section">
    <div class="container container-1440">
        @if ($offers->isEmpty())
            <div class="offers-empty">New offers are on the way — check back soon!</div>
        @else
            <div class="offers-grid">
                @foreach ($offers as $offer)
                    <article class="offer-card" data-offer data-title="{{ $offer->title }}" data-image="{{ $offer->image_url ?? asset('assets/img/placeholder-category.svg') }}">
                        <div class="offer-card-thumb">
                            <span class="offer-badge">Offer</span>
                            <img src="{{ $offer->image_url ?? asset('assets/img/placeholder-category.svg') }}" alt="{{ $offer->title }}" loading="lazy">
                        </div>
                        <div class="offer-card-body">
                            <h3 class="offer-card-title">{{ $offer->title }}</h3>
                            <p class="offer-card-desc">{{ \Illuminate\Support\Str::limit($offer->description, 120) }}</p>
                            <div class="offer-actions-row">
                                <a href="{{ route('appointment') }}" class="offer-book-btn">Book Now</a>
                                @if ($company->phone ?? null)
                                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $company->phone) }}" class="offer-icon-btn offer-icon-call" title="Call us" aria-label="Call us">
                                        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M6.62 10.79a15.53 15.53 0 0 0 6.59 6.59l2.2-2.2a1.02 1.02 0 0 1 1.05-.24c1.16.38 2.4.59 3.69.59a1 1 0 0 1 1 1V20a1 1 0 0 1-1 1A17 17 0 0 1 3 4a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 1.29.21 2.53.59 3.69a1 1 0 0 1-.25 1.05l-2.22 2.05z"/></svg>
                                    </a>
                                @endif
                                @if ($company->whatsapp ?? null)
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $company->whatsapp) }}?text={{ rawurlencode('Hi, I would like to know more about your offer: ' . $offer->title) }}" target="_blank" rel="noopener noreferrer" class="offer-icon-btn offer-icon-wa" title="Chat on WhatsApp" aria-label="Chat on WhatsApp">
                                        <svg viewBox="0 0 32 32" fill="currentColor" aria-hidden="true"><path d="M16.003 3.2c-7.06 0-12.8 5.74-12.8 12.8 0 2.26.6 4.46 1.73 6.4L3.2 28.8l6.57-1.72a12.74 12.74 0 0 0 6.23 1.6h.01c7.06 0 12.8-5.74 12.8-12.8s-5.74-12.8-12.81-12.68zm0 23.04h-.01a10.6 10.6 0 0 1-5.4-1.48l-.39-.23-3.9 1.02 1.04-3.8-.25-.4a10.62 10.62 0 0 1-1.63-5.67c0-5.87 4.78-10.64 10.65-10.64 2.84 0 5.51 1.11 7.52 3.12a10.56 10.56 0 0 1 3.12 7.53c0 5.87-4.78 10.63-10.3 10.53zm5.84-7.96c-.32-.16-1.89-.93-2.18-1.04-.29-.11-.5-.16-.71.16-.21.32-.82 1.04-1 1.25-.18.21-.37.24-.69.08-.32-.16-1.35-.5-2.57-1.59-.95-.85-1.59-1.9-1.78-2.22-.18-.32-.02-.49.14-.65.14-.14.32-.37.48-.56.16-.18.21-.32.32-.53.11-.21.05-.4-.03-.56-.08-.16-.71-1.72-.98-2.35-.26-.62-.52-.54-.71-.55l-.61-.01c-.21 0-.56.08-.85.4-.29.32-1.11 1.09-1.11 2.66s1.14 3.08 1.3 3.29c.16.21 2.24 3.42 5.43 4.8.76.33 1.35.52 1.81.67.76.24 1.45.21 2 .13.61-.09 1.89-.77 2.16-1.52.27-.74.27-1.38.19-1.51-.08-.13-.29-.21-.61-.37z"/></svg>
                                    </a>
                                @endif
                            </div>
                            <button type="button" class="offer-card-link" data-offer-open aria-label="View offer: {{ $offer->title }}">View details
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9 6L15 12L9 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </button>
                        </div>
                        <div class="offer-full" hidden>{!! nl2br(e($offer->description)) !!}</div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
</section>

{{-- Offer details popup --}}
<div class="offer-modal" id="offerModal" aria-hidden="true">
    <div class="offer-modal-overlay" data-offer-close></div>
    <div class="offer-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="offerModalTitle">
        <button class="offer-modal-close" data-offer-close aria-label="Close">&times;</button>
        <div class="offer-modal-img" id="offerModalImgWrap"><img id="offerModalImg" src="" alt=""></div>
        <div class="offer-modal-content">
            <h3 id="offerModalTitle"></h3>
            <div id="offerModalDesc" class="offer-modal-desc"></div>
            <div class="offer-actions-row">
                <a href="{{ route('appointment') }}" class="offer-book-btn">Book Now</a>
                @if ($company->phone ?? null)
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $company->phone) }}" class="offer-icon-btn offer-icon-call" title="Call us" aria-label="Call us">
                        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M6.62 10.79a15.53 15.53 0 0 0 6.59 6.59l2.2-2.2a1.02 1.02 0 0 1 1.05-.24c1.16.38 2.4.59 3.69.59a1 1 0 0 1 1 1V20a1 1 0 0 1-1 1A17 17 0 0 1 3 4a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 1.29.21 2.53.59 3.69a1 1 0 0 1-.25 1.05l-2.22 2.05z"/></svg>
                    </a>
                @endif
                @if ($company->whatsapp ?? null)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $company->whatsapp) }}?text={{ rawurlencode('Hi, I would like to know more about your offers.') }}" target="_blank" rel="noopener noreferrer" class="offer-icon-btn offer-icon-wa" title="Chat on WhatsApp" aria-label="Chat on WhatsApp">
                        <svg viewBox="0 0 32 32" fill="currentColor" aria-hidden="true"><path d="M16.003 3.2c-7.06 0-12.8 5.74-12.8 12.8 0 2.26.6 4.46 1.73 6.4L3.2 28.8l6.57-1.72a12.74 12.74 0 0 0 6.23 1.6h.01c7.06 0 12.8-5.74 12.8-12.8s-5.74-12.8-12.81-12.68zm0 23.04h-.01a10.6 10.6 0 0 1-5.4-1.48l-.39-.23-3.9 1.02 1.04-3.8-.25-.4a10.62 10.62 0 0 1-1.63-5.67c0-5.87 4.78-10.64 10.65-10.64 2.84 0 5.51 1.11 7.52 3.12a10.56 10.56 0 0 1 3.12 7.53c0 5.87-4.78 10.63-10.3 10.53zm5.84-7.96c-.32-.16-1.89-.93-2.18-1.04-.29-.11-.5-.16-.71.16-.21.32-.82 1.04-1 1.25-.18.21-.37.24-.69.08-.32-.16-1.35-.5-2.57-1.59-.95-.85-1.59-1.9-1.78-2.22-.18-.32-.02-.49.14-.65.14-.14.32-.37.48-.56.16-.18.21-.32.32-.53.11-.21.05-.4-.03-.56-.08-.16-.71-1.72-.98-2.35-.26-.62-.52-.54-.71-.55l-.61-.01c-.21 0-.56.08-.85.4-.29.32-1.11 1.09-1.11 2.66s1.14 3.08 1.3 3.29c.16.21 2.24 3.42 5.43 4.8.76.33 1.35.52 1.81.67.76.24 1.45.21 2 .13.61-.09 1.89-.77 2.16-1.52.27-.74.27-1.38.19-1.51-.08-.13-.29-.21-.61-.37z"/></svg>
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    (function () {
        var modal = document.getElementById('offerModal');
        if (!modal) return;
        // The theme wraps content in a transformed smooth-scroll container, which
        // would make position:fixed relative to that wrapper. Move the modal to
        // <body> so it centers against the viewport.
        if (modal.parentElement !== document.body) document.body.appendChild(modal);
        var imgWrap = document.getElementById('offerModalImgWrap');
        var img = document.getElementById('offerModalImg');
        var titleEl = document.getElementById('offerModalTitle');
        var descEl = document.getElementById('offerModalDesc');

        function openOffer(card) {
            var title = card.getAttribute('data-title') || '';
            var image = card.getAttribute('data-image') || '';
            var tpl = card.querySelector('.offer-full');
            titleEl.textContent = title;
            descEl.innerHTML = tpl ? tpl.innerHTML : '';
            if (image) { img.src = image; img.alt = title; imgWrap.style.display = ''; }
            else { imgWrap.style.display = 'none'; }
            modal.classList.add('open');
            modal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        }
        function closeOffer() {
            modal.classList.remove('open');
            modal.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        }

        document.addEventListener('click', function (e) {
            var trigger = e.target.closest('[data-offer-open]');
            if (trigger) {
                var card = trigger.closest('[data-offer]');
                if (card) { e.preventDefault(); openOffer(card); return; }
            }
            if (e.target.closest('[data-offer-close]')) closeOffer();
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeOffer();
        });
    })();
</script>
@endpush
@endsection
