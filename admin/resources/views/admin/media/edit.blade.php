@extends('layouts.admin')

@section('title', 'Edit Media Item')

@section('content')
<div class="page-head">
    <h2 class="h4 fw-bold mb-1"><a href="{{ route('admin.media.index') }}" class="text-muted text-decoration-none"><i class="bi bi-arrow-left"></i></a> Edit Media Item</h2>
    <p>Update this media item.</p>
</div>

<div class="card" style="max-width: 760px;">
    <div class="card-header"><span class="sec-icon"><i class="bi bi-newspaper"></i></span> {{ \Illuminate\Support\Str::limit($item->title, 60) }}</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.media.update', $item) }}" enctype="multipart/form-data">
            @method('PUT')
            @include('admin.media._form', ['submitLabel' => 'Update Item'])
        </form>
    </div>
</div>
@endsection
