@extends('layouts.admin')

@section('title', 'Edit Blog')

@section('content')
<div class="page-head">
    <h2 class="h4 fw-bold mb-1"><a href="{{ route('admin.blogs.index') }}" class="text-muted text-decoration-none"><i class="bi bi-arrow-left"></i></a> Edit Blog</h2>
    <p>Update this blog post.</p>
</div>

<div class="card" style="max-width: 980px;">
    <div class="card-header"><span class="sec-icon"><i class="bi bi-journal-text"></i></span> {{ $blog->title }}</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.blogs.update', $blog) }}" enctype="multipart/form-data">
            @method('PUT')
            @include('admin.blogs._form', ['submitLabel' => 'Update Blog'])
        </form>
    </div>
</div>
@endsection
