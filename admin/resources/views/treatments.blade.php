@extends('layouts.public')

@php
    $activeCat = $activeCategory ? $categories->firstWhere('slug', $activeCategory) : null;
    $pageTitle = $activeCat ? $activeCat->name . ' Treatments' : 'Our Treatments';
@endphp

@section('title', $pageTitle . ' · ' . ($company->company_name ?? 'Gagan Dental & Aesthetics Clinic'))
@section('meta_description', 'Browse our dental and aesthetic treatments — gentle, modern care for every smile.')

@section('content')
<style>
    .trt-section { padding: 60px 0 100px; background: #f4f6fa; }
    .trt-filter { display: flex; flex-wrap: wrap; gap: 10px; justify-content: center; margin-bottom: 44px; }
    .trt-chip {
        display: inline-block; padding: 10px 22px; border-radius: 50px;
        background: #fff; border: 1.5px solid #e3e8f0; color: #41506a;
        font-weight: 700; font-size: .92rem; text-decoration: none;
        transition: color .25s, background .25s, border-color .25s, transform .25s, box-shadow .25s;
    }
    .trt-chip:hover { color: #2e7d32; border-color: #2e7d32; transform: translateY(-2px); }
    .trt-chip.active {
        background: linear-gradient(135deg,#2e7d32,#43a047); color: #fff; border-color: transparent;
        box-shadow: 0 10px 22px rgba(46, 125, 50,.28);
    }
    .trt-listing-empty { text-align: center; padding: 70px 0; color: #8893a5; font-size: 1.05rem; }
    .trt-pagination { margin-top: 44px; display: flex; justify-content: center; }
    .trt-pagination .pagination { gap: 6px; }
    .trt-pagination .page-link { border-radius: 10px; color: #41506a; border: 1.5px solid #e3e8f0; font-weight: 700; }
    .trt-pagination .page-item.active .page-link { background: #2e7d32; border-color: #2e7d32; color: #fff; }
    .trt-pagination .page-link:focus { box-shadow: 0 0 0 4px rgba(46, 125, 50,.12); }
</style>

<x-page-hero
    :title="$pageTitle"
    :eyebrow="$activeCat ? 'Category' : null"
    :subtitle="$activeCat && $activeCat->description ? $activeCat->description : 'Dental and aesthetic treatments delivered with modern technology and a gentle touch.'" />

<section class="trt-section">
    <div class="container container-1440">
        @if ($categories->isNotEmpty())
            <div class="trt-filter">
                <a href="{{ route('treatments') }}" class="trt-chip {{ $activeCategory ? '' : 'active' }}">All</a>
                @foreach ($categories as $cat)
                    <a href="{{ route('treatments', ['category' => $cat->slug]) }}"
                       class="trt-chip {{ $activeCategory === $cat->slug ? 'active' : '' }}">{{ $cat->name }}</a>
                @endforeach
            </div>
        @endif

        @if ($treatments->isEmpty())
            <div class="trt-listing-empty">No treatments available here yet — please check back soon or <a href="{{ route('contact') }}">contact us</a> for more information.</div>
        @else
            <div class="trt-grid">
                @foreach ($treatments as $treatment)
                    <x-treatment-card :treatment="$treatment" />
                @endforeach
            </div>

            @if ($treatments->hasPages())
                <div class="trt-pagination">
                    {{ $treatments->onEachSide(1)->withQueryString()->links() }}
                </div>
            @endif
        @endif
    </div>
</section>
@endsection
