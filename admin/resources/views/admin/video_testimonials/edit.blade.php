@extends('layouts.admin')

@section('title', 'Edit Video Testimonial')

@section('content')
<div class="page-head">
    <h2 class="h4 fw-bold mb-1"><a href="{{ route('admin.video-testimonials.index') }}" class="text-muted text-decoration-none"><i class="bi bi-arrow-left"></i></a> Edit Video Testimonial</h2>
    <p>Update this YouTube video testimonial.</p>
</div>

<div class="card" style="max-width: 760px;">
    <div class="card-header"><span class="sec-icon"><i class="bi bi-camera-video"></i></span> {{ $videoTestimonial->heading }}</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.video-testimonials.update', $videoTestimonial) }}">
            @method('PUT')
            @include('admin.video_testimonials._form', ['submitLabel' => 'Update Video Testimonial'])
        </form>
    </div>
</div>
@endsection
