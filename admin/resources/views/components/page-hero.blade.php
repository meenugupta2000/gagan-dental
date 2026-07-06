@props([
    'title',
    'subtitle' => null,
    'eyebrow' => null,
    'image' => null,
])

@php($bg = $image ?: ($pageBanner ?? asset(\App\Models\HeroSection::DEFAULT_INNER_BANNER)))

@once
<style>
    .page-hero {
        position: relative;
        padding: 210px 0 90px;
        background-size: cover;
        background-position: center;
        text-align: center;
        color: #fff;
    }
    .page-hero::before {
        content: '';
        position: absolute; inset: 0;
        background: linear-gradient(180deg, rgba(13, 27, 42, .78), rgba(13, 27, 42, .68));
    }
    .page-hero .container { position: relative; z-index: 1; }
    .page-hero-eyebrow {
        display: inline-block; color: #ff9aa0; font-weight: 600;
        letter-spacing: .12em; text-transform: uppercase; font-size: .8rem; margin-bottom: 10px;
    }
    .page-hero h1 {
        color: #fff;
        font-size: clamp(2rem, 5vw, 3.4rem);
        font-weight: 800;
        margin: 0 0 16px;
        text-shadow: 0 2px 16px rgba(0, 0, 0, .45);
    }
    .page-hero h1:last-child { margin-bottom: 0; }
    .page-hero p {
        color: #fff;
        font-size: 1.2rem;
        line-height: 1.7;
        font-weight: 500;
        max-width: 680px;
        margin: 0 auto;
        text-shadow: 0 1px 10px rgba(0, 0, 0, .5);
    }
    .page-hero-flag {
        width: 64px; height: 48px; object-fit: cover; border-radius: 6px;
        box-shadow: 0 6px 18px rgba(0, 0, 0, .3); margin-bottom: 18px;
    }
</style>
@endonce

<section class="page-hero" style="background-image:url('{{ $bg }}');">
    <div class="container container-1440">
        {{ $slot }}
        @if ($eyebrow)
            <span class="page-hero-eyebrow">{{ $eyebrow }}</span>
        @endif
        <h1>{{ $title }}</h1>
        @if ($subtitle)
            <p>{{ $subtitle }}</p>
        @endif
    </div>
</section>
