@extends('layouts.public')

@section('title', $page->title . ' · ' . ($company->company_name ?? 'Gagan Dental & Aesthetics Clinic'))

@section('content')
<style>

    .page-section { padding: 0 0 100px; background: #f6f8fb; }
    .page-card {
        background: #fff; border: 1px solid #eceff5; border-radius: 18px;
        max-width: 900px; margin: -55px auto 0; position: relative; z-index: 2;
        box-shadow: 0 10px 30px rgba(13,27,42,.06);
        padding: 44px clamp(22px, 5vw, 60px) 50px;
        color: #36435a; font-size: 1.04rem; line-height: 1.8;
    }
    .page-card h1, .page-card h2, .page-card h3, .page-card h4 { color: #14233a; font-weight: 700; margin: 1.5em 0 .6em; line-height: 1.3; }
    .page-card h1 { font-size: 1.8rem; } .page-card h2 { font-size: 1.45rem; } .page-card h3 { font-size: 1.2rem; }
    .page-card p { margin: 0 0 1.1em; }
    .page-card ul, .page-card ol { margin: 0 0 1.2em; padding-left: 1.5em; }
    .page-card li { margin-bottom: .5em; }
    .page-card a { color: #2e7d32; text-decoration: underline; }
    .page-card blockquote { border-left: 4px solid #2e7d32; background: #fff7f3; margin: 1.4em 0; padding: .9em 1.3em; border-radius: 0 10px 10px 0; color: #5a4030; }
    .page-card :first-child { margin-top: 0; }
    .page-empty-note { text-align: center; color: #8893a5; padding: 30px 0; }
</style>

<x-page-hero :title="$page->title" />

<section class="page-section">
    <div class="container container-1440">
        <div class="page-card">
            @if (filled(trim(strip_tags((string) $page->content))))
                {!! $page->content !!}
            @else
                <div class="page-empty-note">This page has no content yet.</div>
            @endif
        </div>
    </div>
</section>
@endsection
