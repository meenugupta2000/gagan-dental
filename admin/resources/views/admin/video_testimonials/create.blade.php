@extends('layouts.admin')

@section('title', 'Add Video Testimonial')

@section('content')
<div class="page-head">
    <h2 class="h4 fw-bold mb-1"><a href="{{ route('admin.video-testimonials.index') }}" class="text-muted text-decoration-none"><i class="bi bi-arrow-left"></i></a> Add Video Testimonial</h2>
    <p>Add a YouTube video testimonial shown on the public Testimonials page.</p>
</div>

<div class="card" style="max-width: 760px;">
    <div class="card-header"><span class="sec-icon"><i class="bi bi-camera-video"></i></span> New Video Testimonial</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.video-testimonials.store') }}">
            @include('admin.video_testimonials._form', ['submitLabel' => 'Create Video Testimonial'])
        </form>
    </div>
</div>
@endsection
