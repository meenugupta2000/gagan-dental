@extends('layouts.admin')

@section('title', 'Edit Testimonial')

@section('content')
<div class="page-head">
    <h2 class="h4 fw-bold mb-1"><a href="{{ route('admin.testimonials.index') }}" class="text-muted text-decoration-none"><i class="bi bi-arrow-left"></i></a> Edit Testimonial</h2>
    <p>Update this testimonial.</p>
</div>

<div class="card" style="max-width: 760px;">
    <div class="card-header"><span class="sec-icon"><i class="bi bi-chat-quote"></i></span> {{ $testimonial->name }}</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.testimonials.update', $testimonial) }}" enctype="multipart/form-data">
            @method('PUT')
            @include('admin.testimonials._form', ['submitLabel' => 'Update Testimonial'])
        </form>
    </div>
</div>
@endsection
