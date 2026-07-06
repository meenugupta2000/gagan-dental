@extends('layouts.public')

@section('title', 'Blog · ' . ($company->company_name ?? 'Gagan Dental & Aesthetics Clinic'))
@section('meta_description', 'Oral health tips, treatment guides and clinic news from ' . ($company->company_name ?? 'Gagan Dental & Aesthetics Clinic') . '.')

@section('content')
<style>

    .blog-section { padding: 80px 0 100px; background: #f6f8fb; }
    .blog-grid { display: grid; grid-template-columns: 1fr; gap: 30px; }
    @media (min-width: 768px) { .blog-grid { grid-template-columns: repeat(2, 1fr); } }

    .blog-card {
        display: flex; flex-direction: column;
        background: #fff; border: 1px solid #eceff5; border-radius: 18px; overflow: hidden;
        text-decoration: none; color: inherit;
        transition: transform .4s cubic-bezier(.2,.8,.2,1), box-shadow .4s ease, border-color .4s ease;
    }
    .blog-card:hover { transform: translateY(-8px); box-shadow: 0 22px 45px rgba(13,27,42,.13); border-color: transparent; }
    .blog-card-thumb { aspect-ratio: 16 / 9; overflow: hidden; background: #e9eef5; }
    .blog-card-thumb img { width: 100%; height: 100%; object-fit: cover; transition: transform .6s cubic-bezier(.2,.8,.2,1); }
    .blog-card:hover .blog-card-thumb img { transform: scale(1.07); }
    .blog-card-body { padding: 24px 24px 26px; display: flex; flex-direction: column; flex: 1; }
    .blog-card-title { font-size: 1.2rem; font-weight: 700; color: #14233a; margin: 0 0 10px; line-height: 1.35; }
    .blog-card-excerpt { color: #647089; font-size: .95rem; line-height: 1.6; margin: 0 0 18px; flex: 1; }
    .blog-card-link { display: inline-flex; align-items: center; gap: 7px; color: #2e7d32; font-weight: 600; font-size: .92rem; }
    .blog-card-link svg { transition: transform .3s ease; }
    .blog-card:hover .blog-card-link svg { transform: translateX(4px); }
    .blog-empty { text-align: center; padding: 70px 0; color: #8893a5; font-size: 1.05rem; }
</style>

<x-page-hero
    title="Our Blog"
    subtitle="Oral health tips, treatment guides and advice from our specialists to keep you smiling." />

<section class="blog-section">
    <div class="container container-1440">
        @if ($blogs->isEmpty())
            <div class="blog-empty">No articles published yet — check back soon!</div>
        @else
            <div class="blog-grid">
                @foreach ($blogs as $blog)
                    <a href="{{ route('blog.show', $blog->slug) }}" class="blog-card">
                        <div class="blog-card-thumb">
                            @if ($blog->image_url)
                                <img src="{{ $blog->image_url }}" alt="{{ $blog->title }}" loading="lazy">
                            @endif
                        </div>
                        <div class="blog-card-body">
                            <h3 class="blog-card-title">{{ $blog->title }}</h3>
                            <p class="blog-card-excerpt">{{ $blog->excerpt }}</p>
                            <span class="blog-card-link">Read more
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9 6L15 12L9 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection
