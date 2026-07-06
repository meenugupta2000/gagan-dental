@extends('layouts.admin')

@section('title', 'Add Feature')

@section('content')
<div class="page-head">
    <h2 class="h4 fw-bold mb-1"><a href="{{ route('admin.features.index') }}" class="text-muted text-decoration-none"><i class="bi bi-arrow-left"></i></a> Add Feature</h2>
    <p>Add a "Why choose us" feature card.</p>
</div>

<div class="card" style="max-width: 760px;">
    <div class="card-header"><span class="sec-icon"><i class="bi bi-stars"></i></span> New Feature</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.features.store') }}" enctype="multipart/form-data">
            @include('admin.features._form', ['submitLabel' => 'Create Feature'])
        </form>
    </div>
</div>
@endsection
