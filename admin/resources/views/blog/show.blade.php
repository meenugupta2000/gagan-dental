@extends('layouts.public')

@section('title', $blog->title . ' · ' . ($company->company_name ?? 'Gagan Dental & Aesthetics Clinic'))
@section('meta_description', $blog->excerpt)

@section('content')
<style>

    .blog-show-section { padding: 0 0 100px; background: #f6f8fb; }
    .blog-layout { display: grid; grid-template-columns: 1fr; gap: 30px; margin-top: -55px; position: relative; z-index: 2; }
    @media (min-width: 992px) { .blog-layout { grid-template-columns: minmax(0, 1fr) 340px; align-items: start; } }

    .blog-article {
        background: #fff; border: 1px solid #eceff5; border-radius: 18px;
        box-shadow: 0 10px 30px rgba(13,27,42,.06); overflow: hidden;
    }
    .blog-article-cover { width: 100%; aspect-ratio: 16 / 9; object-fit: cover; display: block; }
    .blog-article-body { padding: 36px clamp(22px, 4vw, 48px) 44px; color: #36435a; font-size: 1.04rem; line-height: 1.8; }
    .blog-article-body h1, .blog-article-body h2, .blog-article-body h3, .blog-article-body h4 { color: #14233a; font-weight: 700; margin: 1.5em 0 .6em; line-height: 1.3; }
    .blog-article-body h1 { font-size: 1.8rem; } .blog-article-body h2 { font-size: 1.45rem; } .blog-article-body h3 { font-size: 1.2rem; }
    .blog-article-body p { margin: 0 0 1.1em; }
    .blog-article-body ul, .blog-article-body ol { margin: 0 0 1.2em; padding-left: 1.5em; }
    .blog-article-body li { margin-bottom: .5em; }
    .blog-article-body a { color: #2e7d32; text-decoration: underline; }
    .blog-article-body blockquote { border-left: 4px solid #2e7d32; background: #fff7f3; margin: 1.4em 0; padding: .9em 1.3em; border-radius: 0 10px 10px 0; color: #5a4030; }
    .blog-article-body img { max-width: 100%; height: auto; border-radius: 10px; margin: .5em 0; }
    .blog-article-body :first-child { margin-top: 0; }
    .blog-empty-note { text-align: center; color: #8893a5; padding: 30px 0; }
    .blog-back {
        display: inline-flex; align-items: center; gap: 10px;
        margin: 0 0 40px clamp(22px, 4vw, 48px);
        padding: 13px 30px;
        background: linear-gradient(135deg, #2e7d32 0%, #43a047 100%);
        color: #fff; text-decoration: none; font-weight: 700; font-size: .95rem;
        border-radius: 50px;
        box-shadow: 0 10px 24px rgba(46, 125, 50, .28);
        transition: transform .3s cubic-bezier(.2, .8, .2, 1), box-shadow .3s ease, letter-spacing .3s ease;
    }
    .blog-back:hover { color: #fff; transform: translateY(-3px); box-shadow: 0 16px 34px rgba(46, 125, 50, .42); letter-spacing: .3px; }
    .blog-back svg { transition: transform .3s ease; }
    .blog-back:hover svg { transform: translateX(-5px); }

    /* ---------- Sidebar ---------- */
    .blog-sidebar-card {
        background: #fff; border: 1px solid #eceff5; border-radius: 18px;
        box-shadow: 0 10px 30px rgba(13,27,42,.06); padding: 24px 22px;
    }
    .blog-sidebar-title { font-size: 1.15rem; font-weight: 800; color: #14233a; margin: 0 0 16px; }
    .blog-sidebar-search { position: relative; margin-bottom: 18px; }
    .blog-sidebar-search input {
        width: 100%; border: 1.5px solid #e3e8f0; border-radius: 50px;
        padding: 11px 16px 11px 42px; font-size: .92rem; outline: none; background: #f8fafc;
        transition: border-color .2s ease, box-shadow .2s ease;
    }
    .blog-sidebar-search input:focus { border-color: #2e7d32; box-shadow: 0 0 0 4px rgba(46, 125, 50,.1); background: #fff; }
    .blog-sidebar-search svg { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #9aa6b8; }
    .blog-sidebar-list { list-style: none; margin: 0; padding: 4px; }
    .blog-sidebar-item { margin-bottom: 16px; }
    .blog-sidebar-item:last-child { margin-bottom: 0; }
    .blog-sidebar-item a {
        display: block; border-radius: 14px; overflow: hidden; background: #fff;
        border: 1px solid #eceff5; text-decoration: none; color: #2a3850;
        transition: transform .35s cubic-bezier(.2,.8,.2,1), box-shadow .35s ease, border-color .35s ease;
    }
    .blog-sidebar-item a:hover { transform: translateY(-4px); box-shadow: 0 16px 32px rgba(13,27,42,.14); border-color: transparent; }
    .blog-sidebar-thumb-wrap { position: relative; display: block; width: 100%; height: 140px; overflow: hidden; background: linear-gradient(135deg, #e9eef5, #dfe6f0); }
    .blog-sidebar-thumb { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform .55s cubic-bezier(.2,.8,.2,1); }
    .blog-sidebar-item a:hover .blog-sidebar-thumb { transform: scale(1.07); }
    .blog-sidebar-thumb-ph { width: 100%; height: 100%; display: block; background: linear-gradient(135deg, #e9eef5, #dfe6f0); }
    .blog-sidebar-badge {
        position: absolute; top: 10px; left: 10px;
        background: linear-gradient(135deg, #2e7d32, #43a047); color: #fff;
        font-size: .66rem; font-weight: 700; letter-spacing: .05em; text-transform: uppercase;
        padding: 4px 11px; border-radius: 50px; box-shadow: 0 4px 12px rgba(46, 125, 50,.4);
    }
    .blog-sidebar-item-text { display: block; padding: 13px 15px 15px; }
    .blog-sidebar-item-title {
        font-size: .95rem; font-weight: 700; line-height: 1.35; color: #14233a;
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
        transition: color .25s ease;
    }
    .blog-sidebar-item a:hover .blog-sidebar-item-title,
    .blog-sidebar-item.active .blog-sidebar-item-title { color: #2e7d32; }
    .blog-sidebar-item.active a { border-color: #2e7d32; box-shadow: 0 8px 22px rgba(46, 125, 50,.18); }
    .blog-sidebar-item-excerpt {
        font-size: .8rem; color: #8893a5; margin-top: 6px; line-height: 1.5;
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    }
    .blog-sidebar-empty { color: #8893a5; font-size: .9rem; text-align: center; padding: 16px 0; }
</style>

<x-page-hero :title="$blog->title" :image="$blog->image_url" />

<section class="blog-show-section">
    <div class="container container-1440">
        <div class="blog-layout">
            <div>
                <article class="blog-article">
                    @if ($blog->image_url)
                        <img class="blog-article-cover" src="{{ $blog->image_url }}" alt="{{ $blog->title }}">
                    @endif
                    <div class="blog-article-body">
                        @if (filled(trim(strip_tags((string) $blog->content))))
                            {!! $blog->content !!}
                        @else
                            <div class="blog-empty-note">This article has no content yet.</div>
                        @endif
                    </div>
                    <a href="{{ route('blog') }}" class="blog-back">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 6L9 12L15 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        Back to all articles
                    </a>
                </article>
            </div>

            <aside class="blog-sidebar">
                <div class="blog-sidebar-card">
                    <h3 class="blog-sidebar-title">All Articles</h3>
                    <div class="blog-sidebar-search">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/><path d="M20 20L17 17" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                        <input type="text" id="blogSidebarSearch" placeholder="Search articles…" autocomplete="off">
                    </div>
                    <ul class="blog-sidebar-list" id="blogSidebarList">
                        @foreach ($allBlogs as $b)
                            <li class="blog-sidebar-item {{ $b->id === $blog->id ? 'active' : '' }}" data-title="{{ strtolower($b->title) }}">
                                <a href="{{ route('blog.show', $b->slug) }}">
                                    <span class="blog-sidebar-thumb-wrap">
                                        @if ($b->image_url)
                                            <img class="blog-sidebar-thumb" src="{{ $b->image_url }}" alt="{{ $b->title }}" loading="lazy">
                                        @else
                                            <span class="blog-sidebar-thumb-ph"></span>
                                        @endif
                                        @if ($b->id === $blog->id)
                                            <span class="blog-sidebar-badge">Reading</span>
                                        @endif
                                    </span>
                                    <span class="blog-sidebar-item-text">
                                        <span class="blog-sidebar-item-title">{{ $b->title }}</span>
                                        <span class="blog-sidebar-item-excerpt">{{ \Illuminate\Support\Str::limit($b->excerpt, 75) }}</span>
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="blog-sidebar-empty" id="blogSidebarEmpty" style="display:none;">No articles match your search.</div>
                </div>
            </aside>
        </div>
    </div>
</section>

@push('scripts')
<script>
    (function () {
        var input = document.getElementById('blogSidebarSearch');
        if (!input) return;
        var items = [].slice.call(document.querySelectorAll('#blogSidebarList .blog-sidebar-item'));
        var empty = document.getElementById('blogSidebarEmpty');
        input.addEventListener('input', function () {
            var q = input.value.trim().toLowerCase();
            var shown = 0;
            items.forEach(function (li) {
                var match = li.getAttribute('data-title').indexOf(q) !== -1;
                li.style.display = match ? '' : 'none';
                if (match) shown++;
            });
            if (empty) empty.style.display = shown === 0 ? 'block' : 'none';
        });
    })();
</script>
@endpush
@endsection
