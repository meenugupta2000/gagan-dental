@extends('layouts.public')

@section('title', 'FAQs · ' . ($company->company_name ?? 'Gagan Dental & Aesthetics Clinic'))
@section('meta_description', 'Answers to common questions about our dental & aesthetic treatments, appointments, safety and more.')

@section('content')
<style>
    .faq-section { padding: 80px 0 100px; background: #f6f8fb; position: relative; overflow: hidden; }
    .faq-section::before { content: ''; position: absolute; top: -120px; right: -120px; width: 340px; height: 340px; border-radius: 50%; background: radial-gradient(circle, rgba(46,125,50,.10), transparent 70%); }
    .faq-section::after { content: ''; position: absolute; bottom: -140px; left: -120px; width: 360px; height: 360px; border-radius: 50%; background: radial-gradient(circle, rgba(46,125,50,.08), transparent 70%); }

    .faq-wrap { position: relative; z-index: 1; max-width: 860px; margin: 0 auto; }

    .faq-head { text-align: center; margin-bottom: 46px; }
    .faq-head .eyebrow { display:inline-block; color: #2e7d32; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; font-size: .8rem; margin-bottom: 10px; }
    .faq-head h2 { font-size: clamp(1.7rem, 3.6vw, 2.4rem); font-weight: 800; color: #14233a; margin: 0 0 12px; }
    .faq-head p { color: #5d6a82; font-size: 1.04rem; line-height: 1.7; max-width: 620px; margin: 0 auto; }

    .faq-item {
        background: #fff; border: 1px solid #e9edf3; border-radius: 16px; margin-bottom: 16px; overflow: hidden;
        box-shadow: 0 6px 18px rgba(13,27,42,.04);
        transition: box-shadow .35s ease, border-color .35s ease, transform .35s ease;
        opacity: 0; transform: translateY(22px); animation: faqIn .55s cubic-bezier(.2,.8,.2,1) forwards;
    }
    @keyframes faqIn { to { opacity: 1; transform: translateY(0); } }
    .faq-item.open { border-color: #bfe0c6; box-shadow: 0 16px 38px rgba(46,125,50,.12); }

    .faq-q {
        width: 100%; text-align: left; background: none; border: 0; cursor: pointer;
        display: flex; align-items: center; gap: 16px; padding: 22px 24px;
        font-size: 1.06rem; font-weight: 700; color: #14233a; line-height: 1.45;
    }
    .faq-q:focus-visible { outline: 2px solid #2e7d32; outline-offset: -2px; }
    .faq-num {
        flex: 0 0 auto; width: 30px; height: 30px; border-radius: 9px; display: grid; place-items: center;
        background: #e7f4ea; color: #2e7d32; font-size: .85rem; font-weight: 800;
        transition: background .3s ease, color .3s ease;
    }
    .faq-item.open .faq-num { background: linear-gradient(135deg,#2e7d32,#43a047); color: #fff; }
    .faq-q-text { flex: 1; }
    .faq-icon {
        flex: 0 0 auto; width: 30px; height: 30px; border-radius: 50%; display: grid; place-items: center;
        background: #f1f4f9; color: #2e7d32; transition: transform .4s cubic-bezier(.2,.8,.2,1), background .3s ease, color .3s ease;
    }
    .faq-item.open .faq-icon { transform: rotate(180deg); background: #2e7d32; color: #fff; }
    .faq-icon svg { width: 16px; height: 16px; }

    .faq-a { max-height: 0; overflow: hidden; transition: max-height .45s cubic-bezier(.2,.8,.2,1); }
    .faq-a-inner { padding: 0 24px 24px 70px; color: #4a5568; font-size: 1rem; line-height: 1.8; }
    @media (max-width: 575.98px) { .faq-a-inner { padding-left: 24px; } }

    .faq-empty { text-align: center; padding: 60px 0; color: #8893a5; font-size: 1.05rem; }

    /* CTA band */
    .faq-cta { position: relative; z-index: 1; margin-top: 54px; text-align: center;
        background: linear-gradient(135deg,#12331b,#2e7d32); border-radius: 22px; padding: 46px clamp(22px,5vw,54px); color: #fff; }
    .faq-cta h3 { color: #fff; font-size: clamp(1.4rem, 3vw, 1.9rem); font-weight: 800; margin: 0 0 10px; }
    .faq-cta p { color: #d7ecdb; font-size: 1.02rem; margin: 0 auto 24px; max-width: 520px; line-height: 1.7; }
    .faq-cta-btns { display: flex; flex-wrap: wrap; gap: 14px; justify-content: center; }
    .faq-cta .btn-solid { background: #fff; color: #1b5e20; border-radius: 50px; padding: 13px 30px; font-weight: 700; text-decoration: none; transition: transform .25s ease, box-shadow .25s ease; }
    .faq-cta .btn-solid:hover { transform: translateY(-3px); box-shadow: 0 14px 30px rgba(0,0,0,.25); }
    .faq-cta .btn-ghost { background: rgba(255,255,255,.12); color: #fff; border: 1px solid rgba(255,255,255,.5); border-radius: 50px; padding: 13px 30px; font-weight: 700; text-decoration: none; transition: background .25s ease, transform .25s ease; }
    .faq-cta .btn-ghost:hover { background: rgba(255,255,255,.22); transform: translateY(-3px); }
</style>

<x-page-hero
    eyebrow="Help Centre"
    title="Frequently Asked Questions"
    subtitle="Everything you might want to know before your visit — from treatments and comfort to appointments and aftercare." />

<section class="faq-section">
    <div class="container container-1440">
        <div class="faq-wrap">
            <div class="faq-head">
                <span class="eyebrow">Got Questions?</span>
                <h2>We've Got Answers</h2>
                <p>Can't find what you're looking for? Our friendly team is always happy to help — just reach out.</p>
            </div>

            @if ($faqs->isEmpty())
                <div class="faq-empty">FAQs will appear here soon.</div>
            @else
                <div class="faq-list" id="faqList">
                    @foreach ($faqs as $faq)
                        <div class="faq-item {{ $loop->first ? 'open' : '' }}" style="animation-delay: {{ $loop->index * 0.07 }}s;">
                            <button type="button" class="faq-q" aria-expanded="{{ $loop->first ? 'true' : 'false' }}">
                                <span class="faq-num">{{ sprintf('%02d', $loop->iteration) }}</span>
                                <span class="faq-q-text">{{ $faq->question }}</span>
                                <span class="faq-icon">
                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </span>
                            </button>
                            <div class="faq-a">
                                <div class="faq-a-inner">{!! nl2br(e($faq->answer)) !!}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="faq-cta">
                <h3>Still have questions?</h3>
                <p>We're here to help. Book an appointment or get in touch and we'll answer everything.</p>
                <div class="faq-cta-btns">
                    <a class="btn-solid" href="{{ route('appointment') }}">Book an Appointment</a>
                    <a class="btn-ghost" href="{{ route('contact') }}">Contact Us</a>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    (function () {
        var list = document.getElementById('faqList');
        if (!list) return;

        function setOpen(item, open) {
            var ans = item.querySelector('.faq-a');
            var btn = item.querySelector('.faq-q');
            if (open) {
                item.classList.add('open');
                btn.setAttribute('aria-expanded', 'true');
                ans.style.maxHeight = ans.scrollHeight + 'px';
            } else {
                item.classList.remove('open');
                btn.setAttribute('aria-expanded', 'false');
                ans.style.maxHeight = null;
            }
        }

        // Initialise: open the first item to its natural height.
        list.querySelectorAll('.faq-item.open').forEach(function (item) {
            var ans = item.querySelector('.faq-a');
            ans.style.maxHeight = ans.scrollHeight + 'px';
        });

        list.addEventListener('click', function (e) {
            var btn = e.target.closest('.faq-q');
            if (!btn) return;
            var item = btn.closest('.faq-item');
            var isOpen = item.classList.contains('open');
            // Accordion behaviour: close others, then toggle this one.
            list.querySelectorAll('.faq-item.open').forEach(function (other) {
                if (other !== item) setOpen(other, false);
            });
            setOpen(item, !isOpen);
        });

        // Keep the open answer height correct on resize.
        var resizeTimer;
        window.addEventListener('resize', function () {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function () {
                var open = list.querySelector('.faq-item.open .faq-a');
                if (open) open.style.maxHeight = open.scrollHeight + 'px';
            }, 150);
        });
    })();
</script>
@endpush
@endsection
