@extends('layouts.admin')

@section('title', 'Add Testimonial')

@section('content')
<div class="page-head">
    <h2 class="h4 fw-bold mb-1"><a href="{{ route('admin.testimonials.index') }}" class="text-muted text-decoration-none"><i class="bi bi-arrow-left"></i></a> Add Testimonial</h2>
    <p>Add a customer testimonial.</p>
</div>

<div class="card" style="max-width: 760px;">
    <div class="card-header"><span class="sec-icon"><i class="bi bi-chat-quote"></i></span> New Testimonial</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.testimonials.store') }}" enctype="multipart/form-data">
            @include('admin.testimonials._form', ['submitLabel' => 'Create Testimonial'])
        </form>
    </div>
</div>
@endsection
