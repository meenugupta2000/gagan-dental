@extends('layouts.admin')

@section('title', 'Edit Page')

@section('content')
<div class="page-head">
    <h2 class="h4 fw-bold mb-1"><a href="{{ route('admin.pages.index') }}" class="text-muted text-decoration-none"><i class="bi bi-arrow-left"></i></a> Edit Page</h2>
    <p>Update this page's content.</p>
</div>

<div class="card" style="max-width: 980px;">
    <div class="card-header"><span class="sec-icon"><i class="bi bi-file-earmark-text"></i></span> {{ $page->title }}</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.pages.update', $page) }}">
            @method('PUT')
            @include('admin.pages._form', ['submitLabel' => 'Save Page'])
        </form>
    </div>
</div>
@endsection
