@props(['treatment'])
@php
    $waDigits = preg_replace('/[^0-9]/', '', (string) (($company ?? null)?->whatsapp ?? ''));
@endphp

@once
<style>
    .trt-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(310px, 1fr)); gap: 30px; }

    .trt-card {
        background: #fff; border-radius: 16px; overflow: hidden;
        box-shadow: 0 8px 26px rgba(13,27,42,.08); display: flex; flex-direction: column;
        transition: transform .4s cubic-bezier(.2,.8,.2,1), box-shadow .4s ease;
    }
    .trt-card:hover { transform: translateY(-8px); box-shadow: 0 24px 48px rgba(13,27,42,.16); }

    /* ---- image slider ---- */
    .trt-slider { position: relative; height: 215px; background: #dde5f0; overflow: hidden; }
    .trt-slides { height: 100%; }
    .trt-slide {
        position: absolute; inset: 0;
        transform: translateX(100%);
        transition: transform .8s cubic-bezier(.65, 0, .35, 1);
        will-change: transform;
    }
    .trt-slide.active { transform: translateX(0); }
    .trt-slide.exit-left { transform: translateX(-100%); }
    .trt-slide img { width: 100%; height: 100%; object-fit: cover; }
    .trt-slider-empty { position: absolute; inset: 0; }
    .trt-slider-empty img { width: 100%; height: 100%; object-fit: cover; }
    .trt-dots { position: absolute; left: 0; right: 0; bottom: 10px; display: flex; gap: 6px; justify-content: center; z-index: 2; }
    .trt-dot { width: 7px; height: 7px; border-radius: 50%; background: rgba(255,255,255,.55); cursor: pointer; transition: background .2s, transform .2s; }
    .trt-dot.active { background: #fff; transform: scale(1.25); }
    .trt-arrow {
        position: absolute; top: 50%; transform: translateY(-50%); z-index: 2;
        width: 32px; height: 32px; border: 0; border-radius: 50%; background: rgba(255,255,255,.85); color: #14233a;
        display: grid; place-items: center; cursor: pointer; opacity: 0; transition: opacity .25s, background .2s;
    }
    .trt-card:hover .trt-arrow { opacity: 1; }
    .trt-arrow:hover { background: #fff; }
    .trt-arrow.prev { left: 10px; } .trt-arrow.next { right: 10px; }

    .trt-body { padding: 16px 18px 20px; display: flex; flex-direction: column; flex: 1; }
    .trt-duration { color: #8893a5; font-size: .85rem; margin: 0 0 6px; display: flex; align-items: center; gap: 6px; }
    .trt-title { font-family: var(--togo-ff-marcellus); font-size: 1.15rem; font-weight: 600; color: #14233a; line-height: 1.35; margin: 0 0 12px; }
    .trt-title a { color: inherit; }
    .trt-tags { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 14px; }
    .trt-tag { background: #e7f4ea; color: #1b5e20; font-size: .76rem; font-weight: 700; padding: 4px 11px; border-radius: 6px; }

    /* Badge overlaid on the image (top-left) */
    .trt-badge-over {
        position: absolute; top: 12px; left: 12px; z-index: 3; pointer-events: none;
        background: linear-gradient(135deg,#2e7d32,#43a047); color: #fff;
        font-size: .7rem; font-weight: 800; padding: 5px 12px; border-radius: 50px;
        text-transform: uppercase; letter-spacing: .03em; box-shadow: 0 6px 16px rgba(0,0,0,.22);
    }
    /* Transparent click layer over the image → detail page (below arrows/dots) */
    .trt-img-link { position: absolute; inset: 0; z-index: 1; }

    .trt-actions { display: flex; gap: 8px; margin-top: auto; }
    .trt-cta {
        flex: 1 1 auto; display: flex; align-items: center; justify-content: center; text-align: center;
        background: linear-gradient(135deg,#2e7d32,#43a047); color: #fff;
        border-radius: 10px; padding: 13px 18px; font-weight: 800; text-decoration: none;
        box-shadow: 0 10px 22px rgba(46, 125, 50,.28); transition: transform .25s, box-shadow .25s;
    }
    .trt-cta:hover { color: #fff; transform: translateY(-2px); box-shadow: 0 16px 30px rgba(46, 125, 50,.4); }
    .trt-wa {
        flex: 0 0 auto; width: 50px; display: flex; align-items: center; justify-content: center;
        background: #25d366; color: #fff; border-radius: 10px; text-decoration: none;
        box-shadow: 0 10px 22px rgba(37,211,102,.32); transition: transform .25s, box-shadow .25s, background .25s;
    }
    .trt-wa:hover { color: #fff; background: #1ebe57; transform: translateY(-2px); box-shadow: 0 16px 30px rgba(37,211,102,.45); }
    .trt-wa svg { width: 24px; height: 24px; }

    .trt-empty { text-align: center; padding: 70px 0; color: #8893a5; font-size: 1.05rem; }
</style>
@endonce

<article class="trt-card">
    <div class="trt-slider" data-trt-slider>
        <a class="trt-img-link" href="{{ route('treatments.show', $treatment->slug) }}" aria-label="View {{ $treatment->name }}"></a>
        @if ($treatment->badge)
            <span class="trt-badge-over">{{ $treatment->badge }}</span>
        @endif
        @if ($treatment->images->isNotEmpty())
            <div class="trt-slides">
                @foreach ($treatment->images as $i => $img)
                    <div class="trt-slide {{ $i === 0 ? 'active' : '' }}"><img src="{{ $img->image_url }}" alt="{{ $treatment->name }}" loading="lazy"></div>
                @endforeach
            </div>
            @if ($treatment->images->count() > 1)
                <button class="trt-arrow prev" data-trt-prev aria-label="Previous">&lsaquo;</button>
                <button class="trt-arrow next" data-trt-next aria-label="Next">&rsaquo;</button>
                <div class="trt-dots">
                    @foreach ($treatment->images as $i => $img)
                        <span class="trt-dot {{ $i === 0 ? 'active' : '' }}" data-trt-dot="{{ $i }}"></span>
                    @endforeach
                </div>
            @endif
        @else
            <div class="trt-slider-empty"><img src="{{ asset('assets/img/placeholder-category.svg') }}" alt="{{ $treatment->name }}"></div>
        @endif
    </div>

    <div class="trt-body">
        @if ($treatment->duration)
            <p class="trt-duration">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/><path d="M12 7v5l3 2" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                {{ $treatment->duration }}
            </p>
        @endif
        <h3 class="trt-title"><a href="{{ route('treatments.show', $treatment->slug) }}">{{ $treatment->name }}</a></h3>

        @if ($treatment->category)
        <div class="trt-tags">
            <span class="trt-tag">{{ $treatment->category->name }}</span>
        </div>
        @endif

        <div class="trt-actions">
            <a href="{{ route('appointment') }}" class="trt-cta">Book Appointment</a>
            @if ($waDigits)
                <a href="https://wa.me/{{ $waDigits }}?text={{ rawurlencode('Hi, I would like to know more about the treatment: ' . $treatment->name) }}" target="_blank" rel="noopener noreferrer" class="trt-wa" aria-label="Chat on WhatsApp about {{ $treatment->name }}">
                    <svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M17.47 14.38c-.3-.15-1.75-.86-2.02-.96-.27-.1-.47-.15-.67.15-.2.3-.77.96-.94 1.16-.17.2-.35.22-.64.07-.3-.15-1.25-.46-2.38-1.47-.88-.78-1.47-1.75-1.64-2.05-.17-.3-.02-.46.13-.6.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.07-.15-.67-1.6-.92-2.2-.24-.58-.49-.5-.67-.5h-.57c-.2 0-.52.07-.79.37-.27.3-1.04 1.02-1.04 2.47s1.07 2.86 1.22 3.06c.15.2 2.1 3.2 5.08 4.49.71.3 1.26.49 1.69.63.71.22 1.36.19 1.87.12.57-.09 1.75-.72 2-1.41.25-.69.25-1.28.17-1.41-.07-.13-.27-.2-.57-.35zM12.04 21.5h-.01a9.46 9.46 0 0 1-4.82-1.32l-.35-.2-3.58.94.96-3.49-.23-.36a9.45 9.45 0 0 1-1.45-5.04c0-5.23 4.26-9.49 9.5-9.49 2.54 0 4.92.99 6.71 2.79a9.43 9.43 0 0 1 2.78 6.71c0 5.23-4.26 9.49-9.49 9.49zm8.08-17.58A11.42 11.42 0 0 0 12.04.5C5.74.5.62 5.62.62 11.92c0 2.1.55 4.15 1.6 5.96L.5 23.5l5.77-1.51a11.4 11.4 0 0 0 5.77 1.47h.01c6.3 0 11.42-5.12 11.42-11.42 0-3.05-1.19-5.92-3.35-8.08z"/></svg>
                </a>
            @endif
        </div>
    </div>
</article>

@once
@push('scripts')
<script>
(function () {
    document.querySelectorAll('[data-trt-slider]').forEach(function (slider) {
        var slides = slider.querySelectorAll('.trt-slide');
        if (slides.length < 2) return;
        var dots = slider.querySelectorAll('[data-trt-dot]');
        var cur = 0, timer = null, len = slides.length;
        function go(n) {
            n = (n + len) % len;
            if (n === cur) return;
            var outgoing = slides[cur], incoming = slides[n];
            incoming.style.transition = 'none';
            incoming.classList.remove('active', 'exit-left');
            void incoming.offsetWidth;
            incoming.style.transition = '';
            requestAnimationFrame(function () {
                outgoing.classList.remove('active');
                outgoing.classList.add('exit-left');
                incoming.classList.add('active');
            });
            setTimeout(function () {
                outgoing.style.transition = 'none';
                outgoing.classList.remove('exit-left');
                void outgoing.offsetWidth;
                outgoing.style.transition = '';
            }, 850);
            dots.forEach(function (d, i) { d.classList.toggle('active', i === n); });
            cur = n;
        }
        function start() { timer = setInterval(function () { go(cur + 1); }, 4000); }
        function restart() { clearInterval(timer); start(); }
        slider.querySelector('[data-trt-prev]') && slider.querySelector('[data-trt-prev]').addEventListener('click', function (e) { e.preventDefault(); go(cur - 1); restart(); });
        slider.querySelector('[data-trt-next]') && slider.querySelector('[data-trt-next]').addEventListener('click', function (e) { e.preventDefault(); go(cur + 1); restart(); });
        dots.forEach(function (d) { d.addEventListener('click', function () { go(parseInt(d.getAttribute('data-trt-dot'), 10)); restart(); }); });
        slider.addEventListener('mouseenter', function () { clearInterval(timer); });
        slider.addEventListener('mouseleave', restart);
        start();
    });
})();
</script>
@endpush
@endonce
