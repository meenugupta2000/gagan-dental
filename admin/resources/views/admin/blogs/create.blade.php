@extends('layouts.admin')

@section('title', 'Add Blog')

@section('content')
<div class="page-head">
    <h2 class="h4 fw-bold mb-1"><a href="{{ route('admin.blogs.index') }}" class="text-muted text-decoration-none"><i class="bi bi-arrow-left"></i></a> Add Blog</h2>
    <p>Write a new blog post.</p>
</div>

<div class="card" style="max-width: 980px;">
    <div class="card-header"><span class="sec-icon"><i class="bi bi-journal-text"></i></span> New Blog</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.blogs.store') }}" enctype="multipart/form-data">
            @include('admin.blogs._form', ['submitLabel' => 'Create Blog'])
        </form>
    </div>
</div>
@endsection
