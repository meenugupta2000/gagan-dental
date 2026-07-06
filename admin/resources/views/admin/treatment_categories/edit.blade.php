@extends('layouts.admin')

@section('title', 'Edit Treatment Category')

@section('content')
<div class="page-head">
    <h2 class="h4 fw-bold mb-1"><a href="{{ route('admin.treatment-categories.index') }}" class="text-muted text-decoration-none"><i class="bi bi-arrow-left"></i></a> Edit Treatment Category</h2>
    <p>Update this category.</p>
</div>

<div class="card" style="max-width: 760px;">
    <div class="card-header"><span class="sec-icon"><i class="bi bi-collection"></i></span> {{ $category->name }}</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.treatment-categories.update', $category) }}" enctype="multipart/form-data">
            @method('PUT')
            @include('admin.treatment_categories._form', ['submitLabel' => 'Update Category'])
        </form>
    </div>
</div>
@endsection
