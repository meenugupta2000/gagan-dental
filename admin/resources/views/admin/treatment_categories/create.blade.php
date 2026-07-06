@extends('layouts.admin')

@section('title', 'Add Treatment Category')

@section('content')
<div class="page-head">
    <h2 class="h4 fw-bold mb-1"><a href="{{ route('admin.treatment-categories.index') }}" class="text-muted text-decoration-none"><i class="bi bi-arrow-left"></i></a> Add Treatment Category</h2>
    <p>Add a treatment category.</p>
</div>

<div class="card" style="max-width: 760px;">
    <div class="card-header"><span class="sec-icon"><i class="bi bi-collection"></i></span> New Category</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.treatment-categories.store') }}" enctype="multipart/form-data">
            @include('admin.treatment_categories._form', ['submitLabel' => 'Create Category'])
        </form>
    </div>
</div>
@endsection
